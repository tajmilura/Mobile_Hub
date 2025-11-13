<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $categories = Category::all();
        return view('frontend.index', compact('sliders', 'categories'));
    }
}
