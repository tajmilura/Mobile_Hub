<?php

namespace App\Http\Controllers\Mobilehub;

use App\Http\Controllers\Controller;


use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['user', 'items', 'coupon'])
            ->latest()
            ->paginate(20);

        return view('admin.store.order.all_order', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'coupon'])
            ->findOrFail($id);

        return view('admin.store.order.order_show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $order = Order::with(['user', 'items.product', 'coupon'])
            ->findOrFail($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'tracking_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $order->update($validated);

        return redirect()->route('order.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}
