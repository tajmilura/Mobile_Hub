<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with(['product' => function ($query) {
            $query->select('id', 'name', 'price', 'image', 'stock');
        }])->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
              toastr()->error('Your cart is empty!!');
            return redirect()->route('product.cart.index')->with('error', 'Your cart is empty!');
        }

        // FIX: Use cart price instead of product price
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $shipping = 0;
        $tax = $subtotal * 0.05;
        $discount = 0;
        $couponCode = null;
        $discountType = null;
        $appliedCoupon = false;

        if (session('applied_coupon')) {
            $couponData = session('applied_coupon');
            $couponCode = $couponData['code'];
            $discount = $couponData['discount'];
            $appliedCoupon = true;

            $coupon = Coupon::find($couponData['coupon_id']);
            $discountType = $coupon ? $coupon->type : 'fixed';
        }

        $total = $subtotal + $shipping + $tax - $discount;

        // Get active payment methods
        $paymentMethods = PaymentMethod::active()->orderBy('sort_order')->get();
        $brands = Brand::all();
        return view('frontend.pages.checkout', compact(
            'cartItems',
            'subtotal',
            'shipping',
            'tax',
            'discount',
            'total',
            'couponCode',
            'discountType',
            'appliedCoupon',
            'paymentMethods',
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'required|string|max:20',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string',
            'billing_state' => 'required|string',
            'billing_zipcode' => 'required|string',
            'payment_method' => 'required|in:cod,bkash,nagad,rocket,card,bank',
            'terms' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty!');
            }

            // FIX: Use cart price for calculation
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $shipping = 0;
            $tax = $subtotal * 0.05;
            $discount = 0;
            $couponId = null;
            $couponCode = null;
            $couponType = null;

            if (session('applied_coupon')) {
                $couponData = session('applied_coupon');
                $discount = $couponData['discount'];
                $couponId = $couponData['coupon_id'];
                $couponCode = $couponData['code'];

                $coupon = Coupon::find($couponId);
                $couponType = $coupon ? $coupon->type : null;

                if ($coupon) {
                    $coupon->incrementUsage();
                }
            }

            $grandTotal = $subtotal + $shipping + $tax - $discount;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . date('YmdHis') . '-' . strtoupper(uniqid()),
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping_charge' => $shipping,
                'tax_amount' => $tax,
                'grand_total' => $grandTotal,
                'coupon_id' => $couponId,
                'coupon_code' => $couponCode,
                'coupon_type' => $couponType,
                'coupon_discount' => $discount,
                'billing_name' => $request->billing_name,
                'billing_email' => $request->billing_email,
                'billing_phone' => $request->billing_phone,
                'billing_address' => $request->billing_address,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_country' => 'Bangladesh',
                'billing_zipcode' => $request->billing_zipcode,
                'shipping_name' => $request->shipping_name ?: $request->billing_name,
                'shipping_phone' => $request->shipping_phone ?: $request->billing_phone,
                'shipping_address' => $request->shipping_address ?: $request->billing_address,
                'shipping_city' => $request->shipping_city ?: $request->billing_city,
                'shipping_state' => $request->shipping_state ?: $request->billing_state,
                'shipping_country' => 'Bangladesh',
                'shipping_zipcode' => $request->shipping_zipcode ?: $request->billing_zipcode,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'user_id' => Auth::id(),
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->product->sku,
                    'product_description' => $cartItem->product->description,
                    'product_image' => $cartItem->product->image,
                    'product_price' => $cartItem->product->price,
                    'sale_price' => $cartItem->price, // FIX: Use cart price, not product price
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->price * $cartItem->quantity, // FIX: Use cart price
                    'tax' => ($cartItem->price * $cartItem->quantity) * 0.05, // FIX: Use cart price
                    'total' => ($cartItem->price * $cartItem->quantity) * 1.05, // FIX: Use cart price
                    'color' => $cartItem->color,
                    'size' => $cartItem->size,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Handle payment based on method
            if ($request->payment_method === 'cod') {
                // For COD, create pending payment and confirm order
                Payment::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                    'amount' => $grandTotal,
                    'currency' => 'BDT',
                    'status' => 'pending',
                ]);

                // FIX: Update order status properly for COD
                $order->update([
                    'status' => 'confirmed',
                    'payment_status' => 'pending',
                    'confirmed_at' => now()
                ]);

                // Clear cart and coupon session
                Cart::where('user_id', Auth::id())->delete();
                session()->forget('applied_coupon');

                DB::commit();
                // $toastr()->success('Order placed successfully! You will pay $' . number_format($grandTotal, 2) . ' when you receive the product.');
                return redirect()->route('frontend.pages.orderconfirmation', $order->id)
                    ->with('success', 'Order placed successfully! You will pay $' . number_format($grandTotal, 2) . ' when you receive the product.');

            } else {
                // For online payments, create pending payment
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'payment_method' => $request->payment_method,
                    'amount' => $grandTotal,
                    'currency' => 'BDT',
                    'status' => 'pending',
                ]);

                // FIX: Order remains pending until payment
                $order->update([
                    'status' => 'pending',
                    'payment_status' => 'pending'
                ]);

                // Clear cart and coupon session
                Cart::where('user_id', Auth::id())->delete();
                session()->forget('applied_coupon');

                DB::commit();

                // FIX: Simple redirect for now - remove processRealPayment call
                // $toastr()->info('Please complete the payment to confirm your order.');
                return redirect()->route('payment.demo', $payment->id)
                    ->with('info', 'Please complete the payment to confirm your order.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            // $toastr()->error('Order failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Order failed: ' . $e->getMessage());
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('is_active', true)
            ->first();

        if (!$coupon) {
            // $toastr()->error('Invalid coupon code!');
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code!'
            ]);
        }

        if (!$coupon->isValid()) {
            // $toastr()->error('This coupon is no longer valid!');
            return response()->json([
                'success' => false,
                'message' => 'This coupon is no longer valid!'
            ]);
        }

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        // FIX: Use cart price for subtotal calculation
        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $discount = $coupon->calculateDiscount($subtotal);

        if ($discount <= 0) {
                // $toastr()->error('Coupon cannot be applied to your cart!');
            return response()->json([
                'success' => false,
                'message' => 'Coupon cannot be applied to your cart!'
            ]);
        }

        // Store coupon in session
        session(['applied_coupon' => [
            'code' => $coupon->code,
            'discount' => $discount,
            'coupon_id' => $coupon->id
        ]]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => $discount
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        $toastr()->success('Coupon removed successfully!');
        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully!'
        ]);
    }

    // FIX: Add missing method for payment processing
    private function handleOnlinePayment($payment)
    {
        // For now, redirect to demo payment
        return redirect()->route('frontend.pages.demo', $payment->id);
    }
}
