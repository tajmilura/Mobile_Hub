<?php


namespace App\Http\Controllers\Mobilehub;


use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use function Flasher\Toastr\Prime\toastr;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Laravel\Facades\Image;

class BrandController extends Controller
{
    // Show all brands
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(10); // per page 10 brand
        return view('admin.store.brand.add_brand', compact('brands'));
    }

    // Show create form
    public function create()
    {
        return view('admin.brands.create');
    }

    // Store new brand
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'brand_icon' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'brand_image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;

        // // Icon
        // if ($request->hasFile('brand_icon')) {
        //     $brandName = Str::slug($request->name);
        //     $uniqueId = uniqid();
        //     $iconName = "{$brandName}_icon_{$uniqueId}." . $request->file('brand_icon')->getClientOriginalExtension();

        //     $icon = Image::make($request->file('brand_icon'));
        //     $icon->resize(200, 200, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     });

        //     $iconPath = 'uploads/brands/icons/';

        //     // Create folder if not exists
        //     if (!File::exists(public_path($iconPath))) {
        //         File::makeDirectory(public_path($iconPath), 0755, true);
        //     }

        //     $icon->save(public_path($iconPath . $iconName));
        //     $brand->brand_icon = $iconPath . $iconName;
        // } else {
        //     $brand->brand_icon = null;
        // }

        // // Main Image
        // if ($request->hasFile('brand_image')) {
        //     $brandName = Str::slug($request->name);
        //     $uniqueId = uniqid();
        //     $imageName = "{$brandName}_image_{$uniqueId}." . $request->file('brand_image')->getClientOriginalExtension();

        //     $image = Image::make($request->file('brand_image'));
        //     $image->resize(800, 800, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     });

        //     $imagePath = 'uploads/brands/images/';

        //     if (!File::exists(public_path($imagePath))) {
        //         File::makeDirectory(public_path($imagePath), 0755, true);
        //     }

        //     $image->save(public_path($imagePath . $imageName));
        //     $brand->brand_image = $imagePath . $imageName;
        // } else {
        //     $brand->brand_image = null;
        // }

        // Create a new ImageManager instance
        $manager = new ImageManager(new Driver());

        // -------------------
        // Handle Brand Icon
        // -------------------
        if ($request->hasFile('brand_icon')) {

            // Delete old icon if exists
            if ($brand->brand_icon && File::exists(public_path($brand->brand_icon))) {
                File::delete(public_path($brand->brand_icon));
            }

            $brandName = Str::slug($request->name);
            $uniqueId = uniqid();
            $iconName = "{$brandName}_icon_{$uniqueId}." . $request->file('brand_icon')->getClientOriginalExtension();

            $icon = $manager->read($request->file('brand_icon'));
            $icon->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // $iconPath = 'uploads/brands/icons/';
            $iconPath = storage_path('app/public/uploads/brands/icons/');

            if (!File::exists($iconPath)) {
                File::makeDirectory($iconPath, 0755, true);
            }

            $icon->save($iconPath . $iconName);
            $brand->brand_icon = 'uploads/brands/icons/' . $iconName;
        } else {
            if (!isset($brand->brand_icon)) {
                $brand->brand_icon = null;
            }
        }

        // -------------------
        // Handle Brand Main Image
        // -------------------
        if ($request->hasFile('brand_image')) {

            // // Delete old image if exists
            // if ($brand->brand_image && File::exists(public_path($brand->brand_image))) {
            //     File::delete(public_path($brand->brand_image));
            // }

            $brandName = Str::slug($request->name);
            $uniqueId = uniqid();
            $imageName = "{$brandName}_image_{$uniqueId}." . $request->file('brand_image')->getClientOriginalExtension();

            $image = $manager->read($request->file('brand_image'));
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // $imagePath = 'uploads/brands/images/';
            $imagePath = storage_path('app/public/uploads/brands/images/');
            // if (!File::exists(public_path($imagePath))) {
            //     File::makeDirectory(public_path($imagePath), 0755, true);
            // }

            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }

            $image->save($imagePath . $imageName);
            $brand->brand_image = 'uploads/brands/images/' . $imageName;
        } else {
            if (!isset($brand->brand_image)) {
                $brand->brand_image = null;
            }
        }
        $brand->save();
        toastr('Brand created successfully.', 'success');
        return redirect()->back();
    }

    // Show edit form
    // public function edit(Brand $brand)
    // {
    //     return view('admin.brands.edit', compact('brand'));
    // }

    // Update brand
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id,
            'brand_icon' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'brand_image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ]);

        $brand->name = $request->name;

        $manager = new ImageManager(new Driver());

        // -------------------
        // Update brand_icon
        // -------------------
        if ($request->hasFile('brand_icon')) {
            // Delete old icon if exists
            if ($brand->brand_icon && File::exists(storage_path('app/public/' . $brand->brand_icon))) {
                File::delete(storage_path('app/public/' . $brand->brand_icon));
            }

            $brandName = Str::slug($request->name);
            $uniqueId = uniqid();
            $iconName = "{$brandName}_icon_{$uniqueId}.{$request->file('brand_icon')->getClientOriginalExtension()}";

            $icon = $manager->read($request->file('brand_icon'));
            $icon->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });


            // $iconPath = 'uploads/brands/icons/';
            $iconPath = storage_path('app/public/uploads/brands/icons/');
            if (!File::exists($iconPath)) {
                File::makeDirectory($iconPath, 0755, true);
            }

            $icon->save($iconPath . $iconName);
            $brand->brand_icon = 'uploads/brands/icons/' . $iconName;
        }

        // -------------------
        // Update brand_image
        // -------------------
        if ($request->hasFile('brand_image')) {
            // Delete old image if exists
            if ($brand->brand_image && File::exists(storage_path('app/public/' . $brand->brand_image))) {
                File::delete(storage_path('app/public/' . $brand->brand_image));
            }

            $brandName = Str::slug($request->name);
            $uniqueId = uniqid();
            $imageName = "{$brandName}_image_{$uniqueId}.{$request->file('brand_image')->getClientOriginalExtension()}";
            $image = $manager->read($request->file('brand_image'));
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            // $imagePath = 'uploads/brands/images/';
            $imagePath = storage_path('app/public/uploads/brands/images/');
            // if (!File::exists(public_path($imagePath))) {
            //     File::makeDirectory(public_path($imagePath), 0755, true);
            // }

            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }

            $image->save($imagePath . $imageName);
            $brand->brand_image = $imagePath . $imageName;
        }


        $brand->save();
        toastr()->success('Brand updated successfully.');
        return redirect()->back();
    }



    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        // Delete brand icon if exists
        if ($brand->brand_image && File::exists(storage_path('app/public/' . $brand->brand_icon))) {
            File::delete(storage_path('app/public/' . $brand->brand_icon));
        }
        // Delete brand image if exists
        if ($brand->brand_image && File::exists(storage_path('app/public/' . $brand->brand_image))) {
            File::delete(storage_path('app/public/' . $brand->brand_image));
        }

        // Delete brand record from database
        $brand->delete();

        return response()->json(['success' => true]);
    }
}
