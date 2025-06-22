<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',
            
            // Role management
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            
            // Permission management
            'view-permissions',
            'create-permissions',
            'edit-permissions',
            'delete-permissions',
            
            // Dashboard access
            'admin-access',
            'manager-access',
            'user-access',
            
            // Profile management
            'edit-profile',
            'view-profile',
            
            // System management
            'view-system-info',
            'manage-settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // Admin Role - Full access
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Manager Role - Limited admin access
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'view-users',
            'create-users',
            'edit-users',
            'view-roles',
            'manager-access',
            'edit-profile',
            'view-profile',
        ]);

        // User Role - Basic access
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'user-access',
            'edit-profile',
            'view-profile',
        ]);

        // Create default admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // Create default manager user
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $manager->assignRole('manager');

        // Create default regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');

        echo "Default users created:\n";
        echo "Admin: admin@example.com / password\n";
        echo "Manager: manager@example.com / password\n";
        echo "User: user@example.com / password\n";
    }
} 