<?php

namespace App\Http\Controllers\Mobilehub;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class BkashController extends Controller
{
    private $base_url;
    private $app_key;
    private $app_secret;
    private $username;
    private $password;

    public function __construct()
    {
        $this->base_url = env('BKASH_BASE_URL');
        $this->app_key = env('BKASH_APP_KEY');
        $this->app_secret = env('BKASH_APP_SECRET');
        $this->username = env('BKASH_USERNAME');
        $this->password = env('BKASH_PASSWORD');
    }

    public function getToken()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'username' => $this->username,
            'password' => $this->password,
        ])->post($this->base_url . '/tokenized/checkout/token/grant', [
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret,
        ]);

        return $response->json();
    }

    public function createPayment(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $token = $this->getToken();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $token['id_token'],
            'X-APP-Key' => $this->app_key,
        ])->post($this->base_url . '/tokenized/checkout/create', [
            'mode' => '0011',
            'payerReference' => 'user_' . $payment->user_id,
            'callbackURL' => route('payment.bkash.callback', $payment->id),
            'amount' => (string) $payment->amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $payment->order->order_number,
        ]);

        return $response->json();
    }

    public function executePayment($paymentID, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $token = $this->getToken();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $token['id_token'],
            'X-APP-Key' => $this->app_key,
        ])->post($this->base_url . '/tokenized/checkout/execute', [
            'paymentID' => $paymentID,
        ]);

        $result = $response->json();

        if (isset($result['transactionStatus']) && $result['transactionStatus'] === 'Completed') {
            $payment->markAsPaid($result['trxID']);
            $payment->order->update([
                'payment_status' => 'paid',
                'paid_at' => now()
            ]);

            return redirect()->route('order.confirmation', $payment->order_id)
                ->with('success', 'bKash Payment completed successfully!');
        }

        return redirect()->route('payment.cancel', $payment->id)
            ->with('error', 'bKash Payment failed.');
    }

    public function callback(Request $request, $paymentId)
    {
        if ($request->has('paymentID')) {
            return $this->executePayment($request->paymentID, $paymentId);
        }

        return redirect()->route('payment.cancel', $paymentId)
            ->with('error', 'bKash Payment callback failed.');
    }
}
