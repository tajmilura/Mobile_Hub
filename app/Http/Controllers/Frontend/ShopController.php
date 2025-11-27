<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Search Functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('colors', 'like', '%' . $searchTerm . '%');
            });
        }

        // Category Filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Brand Filter
        if ($request->has('brand') && !empty($request->brand)) {
            $query->where('brand_id', $request->brand);
        }

        // Price Range Filter
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting - CORRECTED Popular Query
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'latest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_low':
                    $query->orderByRaw('COALESCE(discount_price, price) asc');
                    break;
                case 'price_high':
                    $query->orderByRaw('COALESCE(discount_price, price) desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'popular':
                        $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(18);
        $brands = Brand::All();
        $categories = Category::All();

        return view('frontend.pages.shop', compact('products', 'brands', 'categories'));
    }
}
