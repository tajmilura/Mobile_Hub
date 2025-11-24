<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductView;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SliderAndBanner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sliders = SliderAndBanner::where('type', 'slider')
            ->where('status', true)
            // ->orderBy('order', 'asc')
            ->latest()
            ->get();

        $banners = SliderAndBanner::where('type', 'banner')
            ->where('status', true)
            // ->orderBy('order', 'asc')
            ->latest()
            ->take(3)   // Just 3 banners
            ->get();
        $newArrivals = Product::NewArrivals()->get();
        $longBanner = SliderAndBanner::where('type', 'long_banner')
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->first();

        $hotDeals = Product::where('is_hot_deal', true)
            ->whereNotNull('discount_price')
            ->orderBy('discount_end', 'asc')
            ->take(2)
            ->get();
        $categories = Category::all();

        $isFeaturedProductOne = Product::IsFeatured()->latest()->first();
        $isFeaturedProducts = Product::IsFeatured()->get();
        $recommendedProducts = $this->getRecommendedProducts($request);
        return view('frontend.index', compact(
            'sliders',
            'categories',
            'banners',
            'newArrivals',
            'longBanner',
            'hotDeals',
            'isFeaturedProductOne',
            'isFeaturedProducts',
            'recommendedProducts'

        ));
    }


    public function getRecommendedProducts(Request $request)
    {
        $user = auth()->user();
        $visitorId = $request->cookie('visitor_id');

        // -------------------------------
        // STEP 1: Find categories & brands user viewed before
        // -------------------------------
        $viewQuery = ProductView::query()
            ->when($user, fn($q) => $q->where('user_id', $user->id))
            ->when(!$user, fn($q) => $q->where('visitor_id', $visitorId));

        $viewedCategoryIds = $viewQuery->clone()->pluck('category_id')->unique();
        $viewedBrandIds    = $viewQuery->clone()->pluck('brand_id')->unique();

        // -------------------------------
        // STEP 2: If user has history → recommend from viewed cat/brand
        // -------------------------------
        if ($viewedCategoryIds->isNotEmpty() || $viewedBrandIds->isNotEmpty()) {
            $recommended = Product::query()
                ->when($viewedCategoryIds->isNotEmpty(), function ($q) use ($viewedCategoryIds) {
                    $q->whereIn('category_id', $viewedCategoryIds);
                })
                ->orWhere(function ($q) use ($viewedBrandIds) {
                    if ($viewedBrandIds->isNotEmpty()) {
                        $q->whereIn('brand_id', $viewedBrandIds);
                    }
                })
                ->inRandomOrder()
                ->take(12)
                ->get();


            if ($recommended->count() < 12) {
                $extra = Product::inRandomOrder()
                    ->take(12 - $recommended->count())
                    ->get();

                $recommended = $recommended->merge($extra);
            }

            return $recommended;
        }

        // -------------------------------
        // STEP 3: No history → fallback (all products random 12)
        // -------------------------------
        return Product::inRandomOrder()
            ->take(12)
            ->get();
    }


    public function trackView(Request $request, $productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Logged in user
        $user = auth()->user();

        // -------------------------
        // Detect visitor (guest user)
        // -------------------------
        $visitorId = $request->cookie('visitor_id');

        if (!$visitorId) {
            $visitorId = Str::uuid()->toString();
            Cookie::queue('visitor_id', $visitorId, 60 * 24 * 30); // valid for 30 days
        }

        // -------------------------
        // Prevent duplicate within 10 minutes
        // -------------------------
        $query = ProductView::where('product_id', $productId)
            ->where('created_at', '>', now()->subMinutes(10));

        if ($user) {
            // Logged in user
            $query->where('user_id', $user->id);
        } else {
            // Guest user
            $query->where('visitor_id', $visitorId);
        }

        $exists = $query->exists();

        if ($exists) {
            return response()->json(['message' => 'Already counted'], 200);
        }

        // -------------------------
        // Save new view
        // -------------------------
        ProductView::create([
            'product_id' => $productId,
            'user_id'    => $user->id ?? null,
            'visitor_id' => $user ? null : $visitorId,
            'ip_address' => $request->ip(),
        ]);
        return response()->json(['message' => 'View counted'], 201);
    }


    public function productDetails($id)
    {
        // Product model
        $product = Product::with(['category', 'brand', 'images', 'video'])->findOrFail($id);

        // Optional: related products / you may also like
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $id)
                                ->take(5)
                                ->get();

        return view('frontend.pages.product', compact('product', 'relatedProducts'));
    }
}
