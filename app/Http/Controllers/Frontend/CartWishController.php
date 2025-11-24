<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartWishController extends Controller
{
    // ==================== CART METHODS ====================

    public function Cartindex()
    {
        try {
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

            // Calculate totals
            $subtotal = 0;
            $total = 0;
            $discount = 0;

            foreach ($cartItems as $item) {
                $itemTotal = $item->product->price * $item->quantity;
                $subtotal += $itemTotal;
            }

            // Coupon calculation
            $coupon = null;
            if (session('applied_coupon')) {
                $couponData = session('applied_coupon');
                $coupon = Coupon::find($couponData['id']);
                if ($coupon && $coupon->isValid()) {
                    $discount = $coupon->calculateDiscount($subtotal);
                } else {
                    session()->forget('applied_coupon');
                }
            }

            $total = $subtotal - $discount;

            return view('frontend.pages.cart', compact('cartItems', 'subtotal', 'total', 'discount'));
        } catch (\Exception $e) {
            Log::error('Cart index error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function CartAdd(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['message' => 'Login required'], 401);
            }

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'sometimes|integer|min:1|max:10',
                'color' => 'nullable|string|max:50',
                'size' => 'nullable|string|max:50',
            ]);

            $product = Product::findOrFail($request->product_id);

            // Check stock availability
            if ($product->stock < ($request->quantity ?? 1)) {
                return response()->json(['message' => 'Not enough stock available'], 400);
            }

            // Check if item already exists in cart with same attributes
            $cart = Cart::where('user_id', auth()->id())
                ->where('product_id', $request->product_id)
                ->where('color', $request->color)
                ->where('size', $request->size)
                ->first();

            if ($cart) {
                $newQuantity = $cart->quantity + ($request->quantity ?? 1);

                // Check stock for updated quantity
                if ($product->stock < $newQuantity) {
                    return response()->json(['message' => 'Not enough stock available'], 400);
                }

                $cart->quantity = $newQuantity;
                $cart->price = $product->discount_price ?? $product->price;
                $cart->save();

                $message = 'Cart quantity updated';
            } else {
                Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity ?? 1,
                    'color' => $request->color ?? null,
                    'size' => $request->size ?? null,
                    'price' => $product->discount_price ?? $product->price,
                ]);

                $message = 'Product added to cart';
            }

            $cartCount = Cart::where('user_id', auth()->id())->count();

            return response()->json([
                'message' => $message,
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('CartAdd error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function CartUpdate(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:carts,id',
                'quantity' => 'required|integer|min:1|max:10'
            ]);

            $cart = Cart::with('product')
                ->where('id', $request->id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Check stock availability
            if ($cart->product->stock < $request->quantity) {
                return response()->json(['message' => 'Not enough stock available'], 400);
            }

            $cart->update([
                'quantity' => $request->quantity
            ]);

            // Recalculate totals
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
            $subtotal = 0;

            foreach ($cartItems as $item) {
                $itemTotal = $item->product->price * $item->quantity;
                $subtotal += $itemTotal;
            }

            $cartCount = Cart::where('user_id', auth()->id())->count();

            return response()->json([
                'message' => 'Cart updated successfully',
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal, 2),
                'cart_count' => $cartCount
            ]);
        } catch (\Exception $e) {
            Log::error('CartUpdate error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function CartRemove(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:carts,id'
            ]);

            Cart::where('id', $request->id)
                ->where('user_id', auth()->id())
                ->delete();

            $cartCount = Cart::where('user_id', auth()->id())->count();
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();

            // Recalculate totals
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $itemTotal = $item->product->price * $item->quantity;
                $subtotal += $itemTotal;
            }

            return response()->json([
                'message' => 'Item removed from cart',
                'cart_count' => $cartCount,
                'subtotal' => number_format($subtotal, 2),
                'total' => number_format($subtotal, 2)
            ]);
        } catch (\Exception $e) {
            Log::error('CartRemove error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function ClearCart()
    {
        try {
            Cart::where('user_id', auth()->id())->delete();

            // Clear coupon session
            session()->forget('applied_coupon');

            return response()->json([
                'message' => 'Cart cleared successfully',
                'cart_count' => 0
            ]);
        } catch (\Exception $e) {
            Log::error('ClearCart error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    // ==================== WISHLIST METHODS ====================

    public function Wishindex()
    {
        try {
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Please login to view your wishlist.');
            }

            $wishlistItems = Wishlist::with('product')
                ->where('user_id', auth()->id())
                ->get();

            return view('frontend.pages.wishlist', compact('wishlistItems'));
        } catch (\Exception $e) {
            Log::error('Wishlist index error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function MoveToCart(Request $request)
    {
        try {
            $request->validate([
                'wishlist_id' => 'required|exists:wishlists,id'
            ]);

            $wishlistItem = Wishlist::with('product')
                ->where('id', $request->wishlist_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Check if already in cart
            $cartExists = Cart::where('user_id', auth()->id())
                ->where('product_id', $wishlistItem->product_id)
                ->exists();

            if (!$cartExists) {
                Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $wishlistItem->product_id,
                    'quantity' => 1,
                    'price' => $wishlistItem->product->discount_price ?? $wishlistItem->product->price,
                ]);
            }

            $wishlistItem->delete();

            $cartCount = Cart::where('user_id', auth()->id())->count();
            $wishlistCount = Wishlist::where('user_id', auth()->id())->count();

            return response()->json([
                'message' => 'Product moved to cart',
                'cart_count' => $cartCount,
                'wishlist_count' => $wishlistCount
            ]);
        } catch (\Exception $e) {
            Log::error('MoveToCart error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function WishAdd(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['message' => 'Login required'], 401);
            }

            $request->validate([
                'product_id' => 'required|exists:products,id'
            ]);

            $exists = Wishlist::where('user_id', auth()->id())
                ->where('product_id', $request->product_id)
                ->exists();

            if (!$exists) {
                Wishlist::create([
                    'user_id' => auth()->id(),
                    'product_id' => $request->product_id
                ]);

                $message = 'Added to wishlist';
            } else {
                $message = 'Product already in wishlist';
            }

            $wishlistCount = Wishlist::where('user_id', auth()->id())->count();

            return response()->json([
                'message' => $message,
                'wishlist_count' => $wishlistCount
            ]);
        } catch (\Exception $e) {
            Log::error('WishAdd error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function WishRemove(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:wishlists,id'
            ]);

            Wishlist::where('id', $request->id)
                ->where('user_id', auth()->id())
                ->delete();

            $wishlistCount = Wishlist::where('user_id', auth()->id())->count();

            return response()->json([
                'message' => 'Removed from wishlist',
                'wishlist_count' => $wishlistCount
            ]);
        } catch (\Exception $e) {
            Log::error('WishRemove error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    // Move all wishlist items to cart
    public function moveAllToCart(Request $request)
    {
        try {
            $wishlistItems = Wishlist::with('product')
                ->where('user_id', auth()->id())
                ->get();

            $movedCount = 0;

            foreach ($wishlistItems as $wishlistItem) {
                // Check if product is already in cart
                $cartExists = Cart::where('user_id', auth()->id())
                    ->where('product_id', $wishlistItem->product_id)
                    ->exists();

                if (!$cartExists && $wishlistItem->product->stock > 0) {
                    Cart::create([
                        'user_id' => auth()->id(),
                        'product_id' => $wishlistItem->product_id,
                        'quantity' => 1,
                        'price' => $wishlistItem->product->price,
                    ]);
                    $movedCount++;
                }

                // Remove from wishlist
                $wishlistItem->delete();
            }

            $cartCount = Cart::where('user_id', auth()->id())->count();
            $wishlistCount = Wishlist::where('user_id', auth()->id())->count();

            return response()->json([
                'message' => $movedCount . ' items moved to cart successfully',
                'cart_count' => $cartCount,
                'wishlist_count' => $wishlistCount
            ]);
        } catch (\Exception $e) {
            Log::error('MoveAllToCart error: ' . $e->getMessage());
            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
