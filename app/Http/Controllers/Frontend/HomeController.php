<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SliderAndBanner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = SliderAndBanner::where('type', 'slider')
                    ->where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();

        $banners = SliderAndBanner::where('type', 'banner')
                ->where('status', true)
                ->orderBy('order', 'asc')
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
        return view('frontend.index', compact('sliders', 'categories','banners','newArrivals','longBanner','hotDeals'));
    }
}
