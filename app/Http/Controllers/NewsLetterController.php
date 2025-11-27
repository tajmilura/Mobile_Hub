<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsLetter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Get all subscribers (for admin)
     */
    public function Newsindex()
    {
        $subscribers = NewsLetter::latest()->paginate(20);

        // Statistics
        $totalSubscribers = NewsLetter::count();
        $activeSubscribers = NewsLetter::active()->count();
        $inactiveSubscribers = $totalSubscribers - $activeSubscribers;
        $todaySubscribers = NewsLetter::whereDate('created_at', today())->count();

        return view('admin.newsletter.newsletter', compact(
            'subscribers',
            'totalSubscribers',
            'activeSubscribers',
            'inactiveSubscribers',
            'todaySubscribers'
        ));
    }

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

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }
            return back()->with('error', $validator->errors()->first());
        }

        try {
            NewsLetter::subscribe($request->email);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for subscribing to our newsletter!'
                ]);
            }

            return back()->with('success', 'Thank you for subscribing to our newsletter!');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later.'
                ], 500);
            }
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
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide a valid email address.'
                ], 422);
            }
            return back()->with('error', 'Please provide a valid email address.');
        }

        try {
            NewsLetter::unsubscribe($request->email);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'You have been unsubscribed from our newsletter.'
                ]);
            }

            return back()->with('success', 'You have been unsubscribed from our newsletter.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later.'
                ], 500);
            }
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }

    /**
     * Delete subscriber (for admin)
     */
    public function destroy(NewsLetter $newsletter)
    {
        try {
            $email = $newsletter->email;
            $newsletter->delete();

            if (request()->ajax()) {
                return response()->json(['success' => true]);
            }

            return back()->with('success', 'Subscriber deleted successfully.');

        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false], 500);
            }
            return back()->with('error', 'Failed to delete subscriber.');
        }
    }

    /**
     * Export subscribers
     */
    public function export(Request $request)
    {
        $type = $request->get('type', 'csv');
        $subscribers = NewsLetter::latest()->get();

        if ($type === 'excel') {
            // Excel export logic here
            return response()->streamDownload(function() use ($subscribers) {
                echo "Email,Status,Subscribed At\n";
                foreach ($subscribers as $subscriber) {
                    echo "{$subscriber->email},{$subscriber->is_active},{$subscriber->created_at}\n";
                }
            }, 'subscribers-' . date('Y-m-d') . '.csv');
        }

        // CSV export
        return response()->streamDownload(function() use ($subscribers) {
            echo "Email,Status,Subscribed At\n";
            foreach ($subscribers as $subscriber) {
                echo "{$subscriber->email}," . ($subscriber->is_active ? 'Active' : 'Inactive') . ",{$subscriber->created_at}\n";
            }
        }, 'subscribers-' . date('Y-m-d') . '.csv');
    }
}
