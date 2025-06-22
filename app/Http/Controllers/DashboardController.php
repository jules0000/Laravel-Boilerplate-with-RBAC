<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get user-specific data
        $userStats = [
            'profile_completion' => $this->calculateProfileCompletion($user),
            'last_login' => $user->last_login_at,
            'member_since' => $user->created_at,
            'role' => $user->getRoleNames()->first() ?? 'user',
        ];

        return view('dashboard.index', compact('userStats'));
    }

    /**
     * Show manager dashboard
     */
    public function managerDashboard()
    {
        $this->authorize('manager-access');
        
        $managerStats = [
            'total_users' => User::role('user')->count(),
            'active_users' => User::role('user')->where('is_active', true)->count(),
            'recent_registrations' => User::role('user')->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        $recentUsers = User::role('user')->latest()->take(5)->get();

        return view('dashboard.manager', compact('managerStats', 'recentUsers'));
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->password) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
                'current_password' => 'required',
            ]);

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Calculate profile completion percentage
     */
    private function calculateProfileCompletion($user)
    {
        $totalFields = 4; // name, email, password, profile_complete
        $completedFields = 0;

        if ($user->name) $completedFields++;
        if ($user->email) $completedFields++;
        if ($user->password) $completedFields++;
        if ($user->email_verified_at) $completedFields++;

        return round(($completedFields / $totalFields) * 100);
    }
} 