<?php

namespace App\Http\Controllers\Mobilehub;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.user.user', compact('users'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,moderator,admin',
            'status' => 'boolean'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $request->has('status') ? 1 : 0,
            'email_verified_at' => now() // Auto verify for admin created users
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,moderator,admin',
            'status' => 'boolean'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'status' => $request->has('status') ? 1 : 0
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account.'
            ], 403);
        }

        $user->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Make user admin
     */
    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);

        // Prevent self-modification
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot modify your own role.'
            ], 403);
        }

        $user->update(['role' => 'admin']);

        return response()->json(['success' => true]);
    }

    /**
     * Remove admin privileges
     */
    public function removeAdmin($id)
    {
        $user = User::findOrFail($id);

        // Prevent self-modification
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot modify your own role.'
            ], 403);
        }

        $user->update(['role' => 'user']);

        return response()->json(['success' => true]);
    }

    /**
     * Toggle user status
     */
    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Prevent self-deactivation
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot deactivate your own account.'
            ], 403);
        }

        $action = $request->input('action');

        if ($action === 'activate') {
            $user->update(['status' => 1]);
        } elseif ($action === 'deactivate') {
            $user->update(['status' => 0]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Search user by email for making admin
     */
    public function searchByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User not found'
        ]);
    }

    /**
     * Make user admin by email
     */
    public function makeAdminByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Prevent self-modification
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot modify your own role.');
        }

        $user->update(['role' => 'admin']);

        return redirect()->route('admin.users.index')->with('success', 'User has been made admin successfully.');
    }
}
