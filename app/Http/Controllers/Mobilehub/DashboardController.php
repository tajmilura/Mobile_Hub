<?php

namespace App\Http\Controllers\Mobilehub;

use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
      public function index()
    {
        // Basic Counts
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();

        // Order Status Counts
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();

        // Revenue Calculations
        $totalRevenue = Order::where('payment_status', 'paid')->sum('grand_total');
        $todayRevenue = Order::where('payment_status', 'paid')
                            ->whereDate('created_at', today())
                            ->sum('grand_total');

        // Stock Information
        $lowStockProducts = Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
        $outOfStockProducts = Product::where('stock', 0)->count();
        $inStockProducts = Product::where('stock', '>', 0)->count();

        // Recent Data
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $recentProducts = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalBrands',
            'totalOrders',
            'totalCustomers',
            'pendingOrders',
            'confirmedOrders',
            'shippedOrders',
            'deliveredOrders',
            'totalRevenue',
            'todayRevenue',
            'lowStockProducts',
            'outOfStockProducts',
            'inStockProducts',
            'recentOrders',
            'recentProducts'
        ));
    }
}
