<?php

namespace App\Http\Controllers\Mobilehub;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('sort_order')->paginate(10);
        return view('admin.payment.add_payment', compact('paymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'description' => 'nullable|string|max:500',
            'config' => 'nullable|json',
            'charge' => 'nullable|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_online' => 'boolean',
        ]);

        // Convert checkboxes
        $validated['is_active'] = $request->has('is_active');
        $validated['is_online'] = $request->has('is_online');

        PaymentMethod::create($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name,' . $paymentMethod->id,
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $paymentMethod->id,
            'description' => 'nullable|string|max:500',
            'config' => 'nullable|json',
            'charge' => 'nullable|numeric|min:0|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_online' => 'boolean',
        ]);

        // Convert checkboxes
        $validated['is_active'] = $request->has('is_active');
        $validated['is_online'] = $request->has('is_online');

        $paymentMethod->update($validated);

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
