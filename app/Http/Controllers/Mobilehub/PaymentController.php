<?php

namespace App\Http\Controllers\Mobilehub;

use Stripe\Stripe;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
     private $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function process($paymentId)
    {
        $payment = Payment::with('order')->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($payment->isPaid()) {
            return redirect()->route('frontend.pages.orderconfirmation', $payment->order_id)
                ->with('info', 'Payment already completed!');
        }

        // For card payments, redirect to Stripe
        if ($payment->payment_method === 'card') {
            return $this->processStripePayment($payment);
        }

        return view('frontend.pages.process', compact('payment'));
    }

    private function processStripePayment($payment)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Order #' . $payment->order->order_number,
                        ],
                        'unit_amount' => $payment->amount * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.stripe.success', ['payment' => $payment->id]) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', $payment->id),
                'metadata' => [
                    'payment_id' => $payment->id,
                    'order_id' => $payment->order_id,
                ],
            ]);

            // Update payment with session ID
            $payment->update([
                'transaction_id' => $checkout_session->id,
                'gateway_name' => 'stripe'
            ]);

            return redirect($checkout_session->url);

        } catch (ApiErrorException $e) {
            return redirect()->route('payment.cancel', $payment->id)
                ->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    public function stripeSuccess(Request $request, $paymentId)
    {
        $payment = Payment::with('order')->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        try {
            $session = $this->stripe->checkout->sessions->retrieve($request->get('session_id'));

            if ($session->payment_status === 'paid') {
                $payment->markAsPaid($session->payment_intent);
                $payment->order->update([
                    'payment_status' => 'paid',
                    'paid_at' => now()
                ]);

                return redirect()->route('frontend.pages.orderconfirmation', $payment->order_id)
                    ->with('success', 'Payment completed successfully!');
            }

        } catch (\Exception $e) {
            // Handle error
        }

        return redirect()->route('payment.cancel', $payment->id)
            ->with('error', 'Payment verification failed.');
    }


    public function show($paymentId)
    {
        $payment = Payment::with('order')->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.payment.show', compact('payment'));
    }

    public function success($paymentId)
    {
        $payment = Payment::with('order')->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Mark payment as completed
        if ($payment->isPending()) {
            $payment->markAsPaid(request()->get('transaction_id'));

            // Update order payment status
            $payment->order->update([
                'payment_status' => 'paid',
                'paid_at' => now()
            ]);
        }

        return redirect()->route('frontend.pages.orderconfirmation', $payment->order_id)
            ->with('success', 'Payment completed successfully!');
    }

    public function cancel($paymentId)
    {
        $payment = Payment::with('order')->where('id', $paymentId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($payment->isPending()) {
            $payment->markAsFailed('User cancelled the payment');

            // You can also cancel the order here if needed
            // $payment->order->update(['status' => 'cancelled']);
        }

        return redirect()->route('checkout')
            ->with('error', 'Payment was cancelled. Please try again.');
    }

    public function webhook(Request $request, $gateway)
    {
        // Handle payment gateway webhooks (bkash, nagad, stripe, etc)
        // This is where you'll verify payment from payment gateway

        $payload = $request->all();

        // Process based on gateway
        switch ($gateway) {
            case 'bkash':
                return $this->handleBkashWebhook($payload);
            case 'nagad':
                return $this->handleNagadWebhook($payload);
            case 'stripe':
                return $this->handleStripeWebhook($payload);
            default:
                return response()->json(['error' => 'Unknown gateway'], 400);
        }
    }

    private function handleBkashWebhook($payload)
    {
        // Implement bKash webhook logic
        // Verify payment and update payment status
    }

    private function handleNagadWebhook($payload)
    {
        // Implement Nagad webhook logic
    }

    private function handleStripeWebhook($payload)
    {
        // Implement Stripe webhook logic
    }
}
