<?php

namespace App\Http\Controllers\Mobilehub;

use App\Models\Brand;

use App\Models\Product;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand', 'category'])
            ->latest() // new comes first
            ->get();

        // view
        return view('admin.store.product.all_product', compact('products'));
    }
    // creating product
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        //   dd($brands, $categories);
        return view('admin.store.product.add_product', compact('categories', 'brands'));
    }

    // store product

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // 2 MB
            'gallery.*'  => 'nullable|image|max:5120', // 5 MB per image
            'video'      => 'nullable|mimetypes:video/mp4,video/avi,video/mpeg|max:1048576', // 1 GB
            'video_link' => 'nullable|string'
        ]);

        // dd($request->all());
        $manager = new ImageManager(new Driver());
        $product = new Product();

        // ✅ Basic Info
        $product->fill([
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'discount_start' => $request->discount_start,
            'discount_end' => $request->discount_end,
            'stock' => $request->stock,
            'ram' => $request->ram,
            'storage' => $request->storage,
            'processor' => $request->processor,
            'os' => $request->os,
            'battery' => $request->battery,
            'charging' => $request->charging,
            'display' => $request->display,
            'resolution' => $request->resolution,
            'camera' => $request->camera,
            'front_camera' => $request->front_camera,
            'network' => $request->network,
            'sim' => $request->sim,
            'build' => $request->build,
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
            // 'colors' => json_decode($request->colors, true),
            'colors' => $request->colors ? preg_split('/[\s,]+/', $request->colors) : null,
            'tags'   => $request->tags ? preg_split('/[\s,]+/', $request->tags) : null,
            'fingerprint' => $request->fingerprint,
            'water_resistance' => $request->water_resistance,
            'bluetooth' => $request->bluetooth,
            'wifi' => $request->wifi,
            'usb' => $request->usb,
            'audio' => $request->audio,
            'sensors' => $request->sensors,
            'release_date' => $request->release_date,
            'is_featured'   => $request->boolean('is_featured'),
            'is_new_arrival' => $request->boolean('is_new_arrival'),
            'is_hot_deal'   => $request->boolean('is_hot_deal'),
            'warranty' => $request->warranty,
            // 'tags' => json_decode($request->tags, true),
            'sku' => $request->sku,
            'barcode' => $request->barcode,
        ]);

        // ✅ Main Image
        if ($request->hasFile('image')) {
            $productName = Str::slug($request->name);
            $uniqueId = uniqid();
            $imageName = "{$productName}_main_{$uniqueId}." . $request->file('image')->getClientOriginalExtension();

            $image = $manager->read($request->file('image'));
            $image->resize(277, 277, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $imagePath = 'uploads/products/main_image/';
            if (!File::exists(public_path($imagePath))) {
                File::makeDirectory(public_path($imagePath), 0755, true);
            }

            $image->save(public_path($imagePath . $imageName));
            $product->image = $imagePath . $imageName;
        }

        $product->save(); // Save first to get ID

        // ✅ Gallery Images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $galleryImage) {
                $uniqueId = uniqid();
                $imageName = Str::slug($request->name) . "_gallery_{$uniqueId}." . $galleryImage->getClientOriginalExtension();

                $image = $manager->read($galleryImage);
                $image->resize(280, 280, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $galleryPath = 'uploads/products/gallery/';
                if (!File::exists(public_path($galleryPath))) {
                    File::makeDirectory(public_path($galleryPath), 0755, true);
                }

                $image->save(public_path($galleryPath . $imageName));

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $galleryPath . $imageName,
                ]);
            }
        }

        // ✅ Video (upload + embed link)
        $videoLink = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $uniqueId = uniqid();
            $videoName = Str::slug($request->name) . "_video_{$uniqueId}." . $video->getClientOriginalExtension();

            $videoPath = 'uploads/products/videos/';
            if (!File::exists(public_path($videoPath))) {
                File::makeDirectory(public_path($videoPath), 0755, true);
            }

            $video->move(public_path($videoPath), $videoName);
            $videoLink = $videoPath . $videoName;
        }

        // ✅ YouTube embed conversion
        $embedLink = null;
        if ($request->video_link) {
            $link = $request->video_link;
            if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $link, $m)) {
                $embedLink = 'https://www.youtube.com/embed/' . $m[1];
            } elseif (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $link, $m)) {
                $embedLink = 'https://www.youtube.com/embed/' . $m[1];
            }
        }

        if ($videoLink || $embedLink) {
            ProductVideo::create([
                'product_id' => $product->id,
                'video_path' => $videoLink,
                'embed_link' => $embedLink,
            ]);
        }

        toastr()->success('✅ Product created successfully!');
        return redirect()->route('product.index');
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
    try {
        // 🔹 Delete main image
        if ($product->image && File::exists(public_path($product->main_image))) {
            File::delete(public_path($product->main_image));
        }

        // 🔹 Delete gallery images
        foreach ($product->images as $galleryImage) {
            if ($galleryImage->image_path && File::exists(public_path($galleryImage->image_path))) {
                File::delete(public_path($galleryImage->image_path));
            }
            $galleryImage->delete(); // Remove from database
        }

        // 🔹 Delete videos
        foreach ($product->videos as $video) {
            if ($video->video_path && File::exists(public_path($video->video_path))) {
                File::delete(public_path($video->video_path));
            }
            $video->delete(); // Remove from database
        }

        // 🔹 Finally, delete the product itself
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong: ' . $e->getMessage()
        ], 500);
    }
}


}
