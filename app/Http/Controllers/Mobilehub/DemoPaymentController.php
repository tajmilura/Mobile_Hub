<?php

namespace App\Http\Controllers\Mobilehub;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DemoPaymentController extends Controller
{
      public function showDemoPayment($paymentId)
    {
        $payment = Payment::with('order')->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.pages.demo', compact('payment'));
    }

    public function processDemoPayment(Request $request, $paymentId)
    {
        $request->validate([
            'demo_transaction_id' => 'required|string|min:5',
            'demo_mobile_number' => 'required|string|min:11'
        ]);

        $payment = Payment::with('order')->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Simulate payment processing
        sleep(2); // Simulate API call delay

        // Mark as paid
        $payment->update([
            'status' => 'completed',
            'transaction_id' => 'DEMO_' . $request->demo_transaction_id,
            'transaction_details' => [
                'mobile_number' => $request->demo_mobile_number,
                'method' => $payment->payment_method,
                'demo' => true
            ],
            'paid_at' => now()
        ]);

        // Update order
        $payment->order->update([
            'payment_status' => 'paid',
            'paid_at' => now()
        ]);

        return redirect()->route('frontend.pages.orderconfirmation', $payment->order_id)
            ->with('success', 'Demo payment completed successfully!');
    }
}
