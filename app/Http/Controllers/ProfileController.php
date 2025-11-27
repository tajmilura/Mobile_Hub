<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Brand;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Validation\Rules\Password;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {  $brands = Brand::all();
        return view('frontend.profile.profile',compact('brands'), [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && File::exists(storage_path('app/public/' . $user->profile_photo))) {
                File::delete(storage_path('app/public/' . $user->profile_photo));
            }

            $profilePhotoName = 'profile_' . $user->id . '_' . uniqid() . '.webp';

            // Intervention Image ব্যবহার করে
            $manager = Image::read($request->file('profile_photo'));

            // Resize and optimize image
            $manager->scale(width: 400, height: 400);
            $manager->toWebp(quality: 80);

            $profilePhotoPath = storage_path('app/public/uploads/user-profile/');
            if (!File::exists($profilePhotoPath)) {
                File::makeDirectory($profilePhotoPath, 0755, true);
            }

            $manager->save($profilePhotoPath . $profilePhotoName);
            $data['profile_photo'] = 'uploads/user-profile/' . $profilePhotoName;
        }

        // Handle profile photo removal
        if ($request->has('remove_profile_photo')) {
            if ($user->profile_photo && File::exists(storage_path('app/public/' . $user->profile_photo))) {
                File::delete(storage_path('app/public/' . $user->profile_photo));
            }
            $data['profile_photo'] = null;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        if(Auth::user()->role=='admin'){
            return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
        }
        else{
                    return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile photo if exists
        if ($user->profile_photo && File::exists(storage_path('app/public/' . $user->profile_photo))) {
            File::delete(storage_path('app/public/' . $user->profile_photo));
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
     /**
     * Custom password update method
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.current_password' => 'The current password is incorrect.',
            'new_password.required' => 'The new password field is required.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        $user = $request->user();

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('status', 'password-updated');
    }
}
