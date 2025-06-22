<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();

        return view('admin.dashboard', compact('totalUsers', 'activeUsers', 'totalRoles', 'totalPermissions'));
    }

    /**
     * Show users list
     */
    public function users()
    {
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->has('is_active'),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }

    /**
     * Show edit user form
     */
    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    /**
     * Show roles list
     */
    public function roles()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show permissions list
     */
    public function permissions()
    {
        $permissions = Permission::paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show system info
     */
    public function systemInfo()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_connection' => config('database.default'),
        ];

        return view('admin.system-info', compact('info'));
    }
} 