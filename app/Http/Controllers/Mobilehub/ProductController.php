<?php

namespace App\Http\Controllers\Mobilehub;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->get();
        return view('admin.store.product.add_product', compact('products'));
    }
        // creating product
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.create', compact('categories', 'brands'));
    }

    // store product

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'gallery' => 'nullable',
            'ram' => 'nullable|string',
            'storage' => 'nullable|string',
            'processor' => 'nullable|string',
            'os' => 'nullable|string',
            'battery' => 'nullable|string',
            'charging' => 'nullable|string',
            'display' => 'nullable|string',
            'resolution' => 'nullable|string',
            'camera' => 'nullable|string',
            'front_camera' => 'nullable|string',
            'network' => 'nullable|string',
            'sim' => 'nullable|string',
            'build' => 'nullable|string',
            'weight' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'colors' => 'nullable|string',
            'fingerprint' => 'nullable|string',
            'water_resistance' => 'nullable|string',
            'bluetooth' => 'nullable|string',
            'wifi' => 'nullable|string',
            'usb' => 'nullable|string',
            'audio' => 'nullable|string',
            'sensors' => 'nullable|string',
            'release_date' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->gallery) {
            $data['gallery'] = json_encode($request->gallery);
        }

        Product::create($data);
        return redirect()->route('products.index');
    }


    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('products.edit', compact('product', 'categories', 'brands'));
    }

    // to  update products
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'gallery' => 'nullable',
            'ram' => 'nullable|string',
            'storage' => 'nullable|string',
            'processor' => 'nullable|string',
            'os' => 'nullable|string',
            'battery' => 'nullable|string',
            'charging' => 'nullable|string',
            'display' => 'nullable|string',
            'resolution' => 'nullable|string',
            'camera' => 'nullable|string',
            'front_camera' => 'nullable|string',
            'network' => 'nullable|string',
            'sim' => 'nullable|string',
            'build' => 'nullable|string',
            'weight' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'colors' => 'nullable|string',
            'fingerprint' => 'nullable|string',
            'water_resistance' => 'nullable|string',
            'bluetooth' => 'nullable|string',
            'wifi' => 'nullable|string',
            'usb' => 'nullable|string',
            'audio' => 'nullable|string',
            'sensors' => 'nullable|string',
            'release_date' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->gallery) {
            $data['gallery'] = json_encode($request->gallery);
        }

        $product->update($data);
        return redirect()->route('products.index');
    }

    // to delete a product

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
