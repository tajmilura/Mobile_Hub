<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsLetter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
   public function subscribe(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:news_letters,email'
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already subscribed to our newsletter.'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        try {
            NewsLetter::subscribe($request->email);
            
            return back()->with('success', 'Thank you for subscribing to our newsletter!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Please provide a valid email address.');
        }

        try {
            NewsLetter::unsubscribe($request->email);

            return back()->with('success', 'You have been unsubscribed from our newsletter.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Get all subscribers (for admin)
     */
    public function index()
    {
        $subscribers = NewsLetter::latest()->paginate(20);
        return view('admin.newsletter.index', compact('subscribers'));
    }

    /**
     * Delete subscriber (for admin)
     */
    public function destroy(NewsLetter $newsletter)
    {
        try {
            $newsletter->delete();
            return back()->with('success', 'Subscriber deleted successfully.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete subscriber.');
        }
    }
}