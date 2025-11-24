<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    // Apply coupon
    public function apply(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string|max:50'
            ]);

            $coupon = Coupon::where('code', $request->code)->first();

            if (!$coupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid coupon code.'
                ], 400);
            }

            if (!$coupon->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon is no longer valid.'
                ], 400);
            }

            // Check if user already used this coupon
            if (auth()->check() && $coupon->users()->where('user_id', auth()->id())->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already used this coupon.'
                ], 400);
            }

            // Calculate cart total
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
            $subtotal = 0;

            foreach ($cartItems as $item) {
                $subtotal += $item->product->price * $item->quantity;
            }

            $discount = $coupon->calculateDiscount($subtotal);

            if ($discount <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimum order amount not reached for this coupon.'
                ], 400);
            }

            // Store coupon in session
            session([
                'applied_coupon' => [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'discount' => $discount,
                    'min_order_amount' => $coupon->min_order_amount,
                    'max_discount' => $coupon->max_discount
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully!',
                'coupon' => [
                    'code' => $coupon->code,
                    'discount' => number_format($discount, 2),
                    'type' => $coupon->type,
                    'value' => $coupon->value
                ],
                'discount_amount' => $discount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply coupon. Please try again.'
            ], 500);
        }
    }

    // Remove coupon
    public function remove()
    {
        try {
            session()->forget('applied_coupon');

            return response()->json([
                'success' => true,
                'message' => 'Coupon removed successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove coupon.'
            ], 500);
        }
    }

    // Get coupon details
    public function check(Request $request)
    {
        try {
            $coupon = Coupon::where('code', $request->code)->first();

            if (!$coupon) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Invalid coupon code.'
                ]);
            }

            if (!$coupon->isValid()) {
                return response()->json([
                    'valid' => false,
                    'message' => 'This coupon is expired or inactive.'
                ]);
            }

            return response()->json([
                'valid' => true,
                'coupon' => [
                    'code' => $coupon->code,
                    'description' => $coupon->description,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'min_order_amount' => $coupon->min_order_amount,
                    'max_discount' => $coupon->max_discount,
                    'end_date' => $coupon->end_date ? $coupon->end_date->format('M d, Y') : null
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Error checking coupon.'
            ]);
        }
    }
}
