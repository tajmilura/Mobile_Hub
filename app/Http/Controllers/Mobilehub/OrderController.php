<?php

namespace App\Http\Controllers\Mobilehub;

use App\Models\Cart;
use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Order Confirmation Page
     */
    public function confirmation($orderId)
    {
        $order = Order::with(['Items', 'user', 'payment'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.pages.orderconfirmation', compact('order'));
    }

    /**
     * Order Details Page
     */
    public function show($orderId)
    {
        $order = Order::with(['Items', 'user', 'payment'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.pages.orderdetails', compact('order'));
    }

    /**
     * Order History Page
     */
    public function history()
    {
        $orders = Order::with('Items')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.pages.orderhistory', compact('orders'));
    }

    /**
     * Order Tracking Page
     */
    public function tracking($orderId)
    {
        $order = Order::with(['Items'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.pages.ordertracking', compact('order'));
    }

    /**
     * Cancel Order
     */
    public function cancel(Request $request, $orderId)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $order->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
            'cancelled_at' => now()
        ]);

        // Restore product stock
        foreach ($order->Items as $item) {
            if ($item->product) {
                $item->product()->increment('stock', $item->quantity);
            }
        }

        return redirect()->route('order.details', $order->id)
            ->with('success', 'Order cancelled successfully.');
    }

    /**
     * Download Invoice as PDF
     */
    public function downloadInvoice($orderId)
    {
        $order = Order::with(['Items', 'user'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Generate PDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('frontend.pages.invoice', compact('order'));

        // Set PDF options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        // Download PDF
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    /**
     * Reorder Functionality
     */
    public function reorder($orderId)
    {
        $order = Order::with('Items.product')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Add order items to cart
        foreach ($order->Items as $item) {
            // Check if product exists and has stock
            if ($item->product && $item->product->stock > 0) {
                Cart::updateOrCreate([
                    'user_id' => Auth::id(),
                    'product_id' => $item->product_id,
                    'color' => $item->color,
                    'size' => $item->size
                ], [
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }
        }

        return redirect()->route('cart')
            ->with('success', 'Items from order #' . $order->order_number . ' have been added to your cart.');
    }

    /**
     * Track Order by Order Number (Public)
     */
    public function trackOrder(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email'
        ]);

        $order = Order::with('Items')
            ->where('order_number', $request->order_number)
            ->where('billing_email', $request->email)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found. Please check your order number and email.');
        }

        return view('frontend.pages.ordertracking', compact('order'));
    }

    /**
     * Get Order Status API
     */
    public function getOrderStatus($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'grand_total' => $order->grand_total,
                'created_at' => $order->created_at->format('M d, Y'),
                'estimated_delivery' => $order->created_at->addDays(7)->format('M d, Y')
            ]
        ]);
    }

    /**
     * Order Print View
     */
    public function print($orderId)
    {
        $order = Order::with(['Items', 'user'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.pages.orderprint', compact('order'));
    }

    /**
     * View Invoice in Browser
     */
    public function viewInvoice($orderId)
    {
        $order = Order::with(['Items', 'user'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('frontend.pages.invoice', compact('order'));
        
        return $pdf->stream('invoice-' . $order->order_number . '.pdf');
    }
}