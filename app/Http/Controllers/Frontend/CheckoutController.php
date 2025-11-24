<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
public function index()
    {
        // Fix: Load product with cart items
        $cartItems = Cart::with(['product' => function($query) {
            $query->select('id', 'name', 'price', 'image', 'stock');
        }])->where('user_id', Auth::id())->get();
        // dd($cartItems);
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // Debug: Check what data we're getting
        // dd($cartItems->toArray());

        $subtotal = $cartItems->sum(function($item) {
            // Fix: Check if product exists and has price
            if ($item->product && $item->product->price) {
                return $item->product->price * $item->quantity;
            }
            return 0;
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

        return view('frontend.pages.checkout', compact(
            'cartItems', 'subtotal', 'shipping', 'tax', 'discount',
            'total', 'couponCode', 'discountType', 'appliedCoupon'
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
            'payment_method' => 'required|in:cod,card,bkash,bank',
            'terms' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Your cart is empty!');
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
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

                // Increment coupon usage
                if ($coupon) {
                    $coupon->incrementUsage();
                }
            }

            $grandTotal = $subtotal + $shipping + $tax - $discount;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'status' => 'pending',
                'payment_status' => $request->payment_method == 'cod' ? 'pending' : 'paid',
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
                    'sale_price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                    'tax' => ($cartItem->product->price * $cartItem->quantity) * 0.05,
                    'total' => ($cartItem->product->price * $cartItem->quantity) * 1.05,
                    'color' => $cartItem->color,
                    'size' => $cartItem->size,
                ]);

                // Update product stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Clear cart and coupon session
            Cart::where('user_id', Auth::id())->delete();
            session()->forget('applied_coupon');

            DB::commit();

            return redirect()->route('order.confirmation', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
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
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code!'
            ]);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon is no longer valid!'
            ]);
        }

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $subtotal = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        $discount = $coupon->calculateDiscount($subtotal);

        if ($discount <= 0) {
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

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully!'
        ]);
    }
}
