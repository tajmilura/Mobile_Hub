<?php

namespace App\Http\Controllers\Mobilehub;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use function Flasher\Toastr\Prime\toastr;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10); // 10 per page
        return view('admin.store.category.add_category', compact('categories'));
    }

    // Show create form (optional, can use same form as index)
    public function create()
    {
        return view('admin.store.category.add_category');
    }

    // Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,category_name',
            'category_icon' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'category_image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ]);

        $category = new Category();
        $category->category_name = $request->name;

        $manager = new ImageManager(new Driver());

        // Handle Category Icon
        if ($request->hasFile('category_icon')) {
            $categoryName = Str::slug($request->name);
            $uniqueId = uniqid();
            $iconName = "{$categoryName}_icon_{$uniqueId}." . $request->file('category_icon')->getClientOriginalExtension();

            $icon = $manager->read($request->file('category_icon'));
            $icon->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // $iconPath = 'uploads/categories/icons/';
            $iconPath = storage_path('app/public/uploads/categories/icons/');
            if (!File::exists($iconPath)) {
                File::makeDirectory($iconPath, 0755, true);
            }

            $icon->save($iconPath . $iconName);
            $category->category_icon = 'uploads/categories/icons/' . $iconName;
        }

        // Handle Category Main Image
        if ($request->hasFile('category_image')) {
            $categoryName = Str::slug($request->name);
            $uniqueId = uniqid();
            $imageName = "{$categoryName}_image_{$uniqueId}." . $request->file('category_image')->getClientOriginalExtension();

            $image = $manager->read($request->file('category_image'));
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // $imagePath = 'uploads/categories/images/';
            $imagePath = storage_path('app/public/uploads/categories/images/');
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }

            $image->save($imagePath . $imageName);
            $category->category_image = 'uploads/categories/images/' . $imageName;
        }

        $category->save();
        toastr('Category created successfully.', 'success');
        return redirect()->back();
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,category_name,' . $category->id,
            'category_icon' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'category_image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
        ]);

        $category->category_name = $request->name;

        $manager = new ImageManager(new Driver());

        // Update category_icon
        if ($request->hasFile('category_icon')) {
            if ($category->category_icon && File::exists(storage_path('app/public/' . $category->category_icon))) {
                File::delete(storage_path('app/public/' . $category->category_icon));
            }

            $categoryName = Str::slug($request->name);
            $uniqueId = uniqid();
            $iconName = "{$categoryName}_icon_{$uniqueId}." . $request->file('category_icon')->getClientOriginalExtension();

            $icon = $manager->read($request->file('category_icon'));
            $icon->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $iconPath = storage_path('app/public/uploads/categories/icons/');
            if (!File::exists($iconPath)) {
                File::makeDirectory($iconPath, 0755, true);
            }

            $icon->save($iconPath . $iconName);
            $category->category_icon = 'uploads/categories/icons/' . $iconName;
        }

        // Update category_image
        if ($request->hasFile('category_image')) {
            if ($category->category_image && File::exists(storage_path('app/public/' . $category->category_image))) {
                File::delete(storage_path('app/public/' . $category->category_image));
            }

            $categoryName = Str::slug($request->name);
            $uniqueId = uniqid();
            $imageName = "{$categoryName}_image_{$uniqueId}." . $request->file('category_image')->getClientOriginalExtension();

            $image = $manager->read($request->file('category_image'));
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

              $imagePath = storage_path('app/public/uploads/categories/images/');
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }

            $image->save($imagePath . $imageName);
            $category->category_image = 'uploads/categories/images/' . $imageName;
        }

        $category->save();
        toastr()->success('Category updated successfully.');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete category category_icon from folder if it exists
        if ($category->category_icon && File::exists(storage_path('app/public/' . $category->category_icon))) {
            File::delete(storage_path('app/public/' . $category->category_icon));
        }

        // Delete category image from folder if it exists
         if ($category->category_icon && File::exists(storage_path('app/public/' . $category->category_image))) {
            File::delete(storage_path('app/public/' . $category->category_image));
        }
        // Delete category record from database
        $category->delete();

        // AJAX response
        return response()->json(['success' => true]);
    }
}
