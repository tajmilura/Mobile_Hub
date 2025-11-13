<?php

namespace App\Http\Controllers\Mobilehub;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SliderAndBanner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class SliderBannerController extends Controller
{
    //to add
    public function index()
    {
        return view('admin.slider_banner.index');
    }

    //to show the create page
    public function create()
    {
        $sliderbanner = SliderAndBanner::orderBy('id', 'desc')->paginate(10);

        return view('admin.store.slider_banner.add_slider_or_banner', compact('sliderbanner'));
    }

    // tp store
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'link' => 'nullable|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $sliderBanner = new SliderAndBanner();
        $sliderBanner->type = $request->type;
        $sliderBanner->title = $request->title;
        $sliderBanner->subtitle = $request->subtitle;
        $sliderBanner->link = $request->link;

        // Handle image upload
        $manager = new ImageManager(new Driver());
        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title);
            $uniqueId = uniqid();
            $imageName = "{$imageName}_image_{$uniqueId}." . $request->file('image')->getClientOriginalExtension();

            $image = $manager->read($request->file('image'));
            if ($request->type == 'slider') {
                $image->resize(1920, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } elseif ($request->type == 'banner') {
                $image->resize(376, 160, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } else {
                $image->resize(1120, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            // $imagePath = 'uploads/categories/images/';
            $imagePath = storage_path('app/public/uploads/banner_slider/');
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }

            $image->save($imagePath . $imageName);
            $sliderBanner->image_path = 'uploads/banner_slider/' . $imageName;
        }

        $sliderBanner->order = $request->order ?? 0;
        $sliderBanner->status = $request->status ?? false;
        $sliderBanner->save();

        toastr('Element created successfully.', 'success');
        return redirect()->back();
    }

    //to update

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        $sliderBanner = SliderAndBanner::findOrFail($id);

        $sliderBanner->type = $request->type;
        $sliderBanner->title = $request->title;
        $sliderBanner->subtitle = $request->subtitle;
        $sliderBanner->link = $request->link;

        $manager = new ImageManager(new Driver());

        // Handle image update
        if ($request->hasFile('image')) {
            // image delete
            if ($sliderBanner->image_path && File::exists(storage_path('app/public/' . $sliderBanner->image_path))) {
                File::delete(storage_path('app/public/' . $sliderBanner->image_path));
            }

            // image upload
            $imageName = Str::slug($request->title ?: 'media') . '_image_' . uniqid() . '.' .
                $request->file('image')->getClientOriginalExtension();

            $image = $manager->read($request->file('image'));

            // Resize according to type
            if ($request->type == 'slider') {
                $image->resize(1920, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } elseif ($request->type == 'banner') {
                $image->resize(376, 160, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } else {
                $image->resize(1120, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            // Save new image
            $imagePath = storage_path('app/public/uploads/banner_slider/');
            if (!File::exists($imagePath)) {
                File::makeDirectory($imagePath, 0755, true);
            }

            $image->save($imagePath . $imageName);
            $sliderBanner->image_path = 'uploads/banner_slider/' . $imageName;
        }

        // Update other fields
        $sliderBanner->order = $request->order ?? 0;
        $sliderBanner->status = $request->status ?? false;
        $sliderBanner->save();

        toastr('Element updated successfully.', 'success');
        return redirect()->back();
    }



    // to delete

    public function destroy($id)
    {
        $slider_banner = SliderAndBanner::findOrFail($id);
        // Delete associated image file
        if ($slider_banner->image_path && File::exists(storage_path('app/public/' . $slider_banner->image_path))) {
            File::delete(storage_path('app/public/' . $slider_banner->image_path));
        }

        $slider_banner->delete();

        // toastr('Element deleted successfully.', 'success');
        // return redirect()->back();
        return response()->json(['success' => true]);
    }
}
