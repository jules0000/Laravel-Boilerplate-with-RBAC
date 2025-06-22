# Laravel Boilerplate with RBAC

A powerful and modern Laravel boilerplate with built-in Role-Based Access Control (RBAC), MySQL integration, and a beautiful responsive UI. Perfect for kickstarting your next web application project.

## 🚀 Features

- **Complete RBAC System** - Admin, Manager, and User roles with granular permissions
- **MySQL Integration** - Pre-configured database setup with optimized connections
- **Modern UI** - Bootstrap 5 with Font Awesome icons and responsive design
- **User Management** - Complete user administration with profile management
- **Authentication System** - Secure login/register with session management
- **Admin Dashboard** - Comprehensive admin panel with system statistics
- **Manager Dashboard** - Limited admin access for managers
- **Permission System** - Granular permission control using Spatie Laravel Permission
- **Database Seeders** - Pre-populated with demo users and roles
- **Developer Friendly** - Clean, documented code with comprehensive guides

## 📋 Default User Accounts

After installation, you can use these demo accounts:

- **Admin:** admin@example.com / password
- **Manager:** manager@example.com / password  
- **User:** user@example.com / password

## 🛠️ Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Step 1: Install Dependencies

```bash
composer install
```

### Step 2: Environment Configuration

1. Copy the environment file:
```bash
copy env.example .env
```

2. Generate application key:
```bash
php artisan key:generate
```

3. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_boilerplate
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 3: Database Setup

1. Create the database:
```sql
CREATE DATABASE laravel_boilerplate;
```

2. Run migrations:
```bash
php artisan migrate
```

3. Seed the database with demo data:
```bash
php artisan db:seed
```

### Step 4: Start the Application

```bash
php artisan serve
```

Visit `http://localhost:8000` to see your application!

## 🏗️ Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php       # Admin panel management
│   │   │   ├── AuthController.php        # Authentication logic
│   │   │   └── DashboardController.php   # User dashboards
│   │   └── Middleware/                   # Custom middleware
│   ├── Models/
│   │   └── User.php                      # User model with RBAC traits
│   └── Providers/                        # Service providers
├── config/
│   ├── app.php                          # Application configuration
│   └── database.php                     # Database configuration
├── database/
│   ├── migrations/                      # Database migrations
│   └── seeders/                         # Database seeders
├── resources/
│   └── views/
│       ├── auth/                        # Authentication views
│       ├── admin/                       # Admin panel views
│       ├── dashboard/                   # User dashboard views
│       └── layouts/                     # Layout templates
└── routes/
    └── web.php                          # Web routes
```

## 🔐 Role-Based Access Control

### Default Roles

**Admin Role:**
- Full system access
- User management (create, edit, delete)
- Role and permission management
- System configuration access

**Manager Role:**
- Limited admin access
- User viewing and creation
- Basic user management
- Manager dashboard access

**User Role:**
- Basic user access
- Profile management
- User dashboard access

### Permissions

The system includes comprehensive permissions:

- **User Management:** `view-users`, `create-users`, `edit-users`, `delete-users`
- **Role Management:** `view-roles`, `create-roles`, `edit-roles`, `delete-roles`
- **Dashboard Access:** `admin-access`, `manager-access`, `user-access`
- **Profile Management:** `edit-profile`, `view-profile`
- **System Management:** `view-system-info`, `manage-settings`

### Usage Examples

**In Controllers:**
```php
// Check permission
$this->authorize('edit-users');

// Check role
if (auth()->user()->hasRole('admin')) {
    // Admin logic
}
```

**In Blade Templates:**
```blade
@role('admin')
    <a href="/admin">Admin Panel</a>
@endrole

@can('edit-users')
    <button>Edit User</button>
@endcan
```

## 📊 Database Operations

### Creating Models

```bash
php artisan make:model Post -m
```

### Example Model with Relationships

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### Database Queries

```php
// Basic operations
$posts = Post::with('user')->paginate(10);
$post = Post::find(1);
$post->update(['title' => 'New Title']);

// Advanced queries
$publishedPosts = Post::where('status', 'published')
    ->orderBy('created_at', 'desc')
    ->get();
```

## 🎨 Frontend Development

### Adding Custom Styles

```blade
@push('styles')
    <link href="/custom.css" rel="stylesheet">
@endpush
```

### Adding Custom JavaScript

```blade
@push('scripts')
    <script src="/custom.js"></script>
@endpush
```

### Creating Reusable Components

Create `resources/views/components/alert.blade.php`:
```blade
@props(['type' => 'info'])

<div class="alert alert-{{ $type }} alert-dismissible fade show">
    {{ $slot }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
```

Usage:
```blade
<x-alert type="success">
    Operation completed successfully!
</x-alert>
```

## 🔧 Adding New Features

### 1. Creating a New Page

**Step 1:** Create Controller
```bash
php artisan make:controller PostController
```

**Step 2:** Add Routes
```php
Route::resource('posts', PostController::class);
```

**Step 3:** Create Views
```blade
@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    <!-- Your content here -->
@endsection
```

### 2. Adding New Permissions

```php
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Create permission
Permission::create(['name' => 'edit-posts']);

// Assign to role
$role = Role::findByName('manager');
$role->givePermissionTo('edit-posts');
```

### 3. Database Migrations

```bash
php artisan make:migration create_posts_table
```

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->foreignId('user_id')->constrained();
    $table->timestamps();
});
```

## 🛡️ Security Best Practices

1. **Input Validation**
```php
$request->validate([
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
]);
```

2. **Mass Assignment Protection**
```php
protected $fillable = ['name', 'email'];
protected $guarded = ['id', 'password'];
```

3. **Output Escaping**
```blade
{{ $user->name }}  {{-- Escaped --}}
{!! $content !!}   {{-- Raw HTML --}}
```

## 📈 Performance Optimization

1. **Eager Loading**
```php
$posts = Post::with('user', 'comments')->get();
```

2. **Database Indexing**
```php
$table->index('user_id');
$table->unique(['email']);
```

3. **Caching**
```php
$posts = Cache::remember('posts', 3600, function () {
    return Post::published()->get();
});
```

## 🐛 Troubleshooting

### Common Issues

**Permission Denied:**
```bash
chmod -R 775 storage bootstrap/cache
```

**Database Connection:**
- Check `.env` database credentials
- Ensure MySQL service is running
- Verify database exists

**Clear Cache:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📚 Development Resources

- [Developer Guide](DEVELOPER_GUIDE.md) - Comprehensive development documentation
- [Laravel Documentation](https://laravel.com/docs) - Official Laravel docs
- [Spatie Permission](https://spatie.be/docs/laravel-permission) - RBAC package docs
- [Bootstrap 5](https://getbootstrap.com/docs/5.3/) - UI framework docs

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 🆘 Support

If you encounter any issues:

1. Check the [Developer Guide](DEVELOPER_GUIDE.md)
2. Review the [troubleshooting section](#-troubleshooting)
3. Search existing GitHub issues
4. Create a new issue with detailed information

## 🎯 What's Next?

This boilerplate provides a solid foundation for:

- **E-commerce Applications** - Add products, orders, payments
- **Content Management** - Blog posts, pages, media management
- **Project Management** - Tasks, teams, time tracking
- **Social Applications** - Posts, comments, likes, follows
- **API Development** - RESTful APIs with authentication

Start building your dream application today! 🚀

---

**Built with ❤️ using Laravel, Bootstrap, and modern web technologies.** 