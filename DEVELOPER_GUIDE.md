# Laravel Boilerplate Developer Guide

## Table of Contents

1. [Getting Started](#getting-started)
2. [Project Structure](#project-structure)
3. [Database Setup](#database-setup)
4. [RBAC System](#rbac-system)
5. [Adding New Pages](#adding-new-pages)
6. [Database Operations](#database-operations)
7. [Creating Controllers](#creating-controllers)
8. [Working with Models](#working-with-models)
9. [Adding Middleware](#adding-middleware)
10. [Frontend Development](#frontend-development)
11. [Best Practices](#best-practices)

## Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & npm (optional, for asset compilation)

### Installation

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Environment Setup**
   ```bash
   copy env.example .env
   php artisan key:generate
   ```

3. **Database Configuration**
   Edit your `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_boilerplate
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

4. **Run Migrations and Seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   ```

## Project Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   └── DashboardController.php
│   │   └── Middleware/
│   ├── Models/
│   │   └── User.php
│   └── Providers/
├── config/
│   ├── app.php
│   └── database.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       ├── admin/
│       ├── dashboard/
│       └── layouts/
└── routes/
    └── web.php
```

## Database Setup

### Creating Migrations

Create a new migration:
```bash
php artisan make:migration create_posts_table
```

Example migration for a blog post:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('slug')->unique();
            $table->boolean('is_published')->default(false);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
```

### Running Migrations
```bash
php artisan migrate
php artisan migrate:rollback    # Rollback last batch
php artisan migrate:refresh     # Rollback all and re-run
```

## RBAC System

This boilerplate uses [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission) for RBAC.

### Default Roles and Permissions

**Roles:**
- `admin` - Full system access
- `manager` - Limited admin access
- `user` - Basic user access

**Permissions:**
- User management: `view-users`, `create-users`, `edit-users`, `delete-users`
- Role management: `view-roles`, `create-roles`, `edit-roles`, `delete-roles`
- Dashboard access: `admin-access`, `manager-access`, `user-access`

### Adding New Permissions

1. **Create Permission**
   ```php
   use Spatie\Permission\Models\Permission;
   
   Permission::create(['name' => 'edit-posts']);
   ```

2. **Assign to Role**
   ```php
   use Spatie\Permission\Models\Role;
   
   $role = Role::findByName('manager');
   $role->givePermissionTo('edit-posts');
   ```

3. **Check Permissions in Controllers**
   ```php
   public function editPost()
   {
       $this->authorize('edit-posts');
       // Your code here
   }
   ```

4. **Check in Blade Templates**
   ```blade
   @can('edit-posts')
       <a href="/posts/edit" class="btn btn-primary">Edit Post</a>
   @endcan
   ```

## Adding New Pages

### Step 1: Create a Controller

```bash
php artisan make:controller PostController
```

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }
}
```

### Step 2: Add Routes

In `routes/web.php`:
```php
Route::middleware(['auth'])->group(function () {
    Route::resource('posts', PostController::class);
});
```

### Step 3: Create Views

Create `resources/views/posts/index.blade.php`:
```blade
@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Posts</h1>
    @can('create-posts')
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>New Post
        </a>
    @endcan
</div>

<div class="row">
    @foreach($posts as $post)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                    <small class="text-muted">
                        By {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{ $posts->links() }}
@endsection
```

## Database Operations

### Creating Models

```bash
php artisan make:model Post
```

Example model with relationships:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'is_published',
        'user_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
```

### Database Queries

**Basic Operations:**
```php
// Create
$post = Post::create([
    'title' => 'Sample Post',
    'content' => 'Post content here',
    'user_id' => auth()->id(),
]);

// Read
$posts = Post::with('user')->get();
$post = Post::find(1);

// Update
$post->update(['title' => 'Updated Title']);

// Delete
$post->delete();
```

**Advanced Queries:**
```php
// With relationships
$posts = Post::with('user')
    ->where('is_published', true)
    ->orderBy('created_at', 'desc')
    ->paginate(10);

// Search
$posts = Post::where('title', 'like', '%search%')
    ->orWhere('content', 'like', '%search%')
    ->get();

// Counting
$publishedCount = Post::published()->count();
```

## Creating Controllers

### Resource Controllers

```bash
php artisan make:controller PostController --resource
```

This creates a controller with standard CRUD methods:
- `index()` - List all resources
- `create()` - Show create form
- `store()` - Store new resource
- `show()` - Show single resource
- `edit()` - Show edit form
- `update()` - Update resource
- `destroy()` - Delete resource

### API Controllers

```bash
php artisan make:controller Api/PostController --api
```

### Controller Best Practices

1. **Use Form Requests for Validation:**
   ```bash
   php artisan make:request StorePostRequest
   ```

2. **Keep Controllers Thin:**
   ```php
   public function store(StorePostRequest $request)
   {
       $post = $this->postService->create($request->validated());
       return redirect()->route('posts.index')
           ->with('success', 'Post created successfully!');
   }
   ```

## Working with Models

### Model Relationships

```php
// User.php
public function posts()
{
    return $this->hasMany(Post::class);
}

// Post.php
public function user()
{
    return $this->belongsTo(User::class);
}

public function tags()
{
    return $this->belongsToMany(Tag::class);
}
```

### Accessors and Mutators

```php
// Accessor
public function getTitleAttribute($value)
{
    return ucfirst($value);
}

// Mutator
public function setTitleAttribute($value)
{
    $this->attributes['title'] = strtolower($value);
}
```

### Scopes

```php
// Local Scope
public function scopePublished($query)
{
    return $query->where('is_published', true);
}

// Usage
$publishedPosts = Post::published()->get();
```

## Adding Middleware

### Creating Middleware

```bash
php artisan make:middleware CheckPostOwner
```

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPostOwner
{
    public function handle(Request $request, Closure $next)
    {
        $post = $request->route('post');
        
        if ($post && $post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
```

### Registering Middleware

In `app/Http/Kernel.php`:
```php
protected $routeMiddleware = [
    // ... existing middleware
    'post.owner' => \App\Http\Middleware\CheckPostOwner::class,
];
```

### Using Middleware

```php
Route::middleware(['auth', 'post.owner'])->group(function () {
    Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
});
```

## Frontend Development

### Adding CSS/JS Assets

1. **Via CDN (Current approach):**
   ```blade
   @push('styles')
       <link href="https://example.com/custom.css" rel="stylesheet">
   @endpush

   @push('scripts')
       <script src="https://example.com/custom.js"></script>
   @endpush
   ```

2. **Using Laravel Mix (Advanced):**
   ```bash
   npm install
   npm run dev
   ```

### Creating Reusable Components

Create `resources/views/components/alert.blade.php`:
```blade
@props(['type' => 'info', 'message'])

<div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
```

Usage:
```blade
<x-alert type="success" message="Operation completed successfully!" />
```

## Best Practices

### Security

1. **Always validate input:**
   ```php
   $request->validate([
       'email' => 'required|email|unique:users',
       'password' => 'required|min:8|confirmed',
   ]);
   ```

2. **Use mass assignment protection:**
   ```php
   protected $fillable = ['name', 'email'];
   protected $guarded = ['id', 'password'];
   ```

3. **Sanitize output:**
   ```blade
   {{ $user->name }}  {{-- Escaped --}}
   {!! $content !!}   {{-- Raw HTML --}}
   ```

### Performance

1. **Use eager loading:**
   ```php
   $posts = Post::with('user', 'tags')->get();
   ```

2. **Implement caching:**
   ```php
   $posts = Cache::remember('posts', 3600, function () {
       return Post::published()->get();
   });
   ```

3. **Use database indexing:**
   ```php
   $table->index('user_id');
   $table->unique(['email']);
   ```

### Code Organization

1. **Use Service Classes:**
   ```php
   // app/Services/PostService.php
   class PostService
   {
       public function createPost(array $data)
       {
           return Post::create($data);
       }
   }
   ```

2. **Repository Pattern:**
   ```php
   // app/Repositories/PostRepository.php
   interface PostRepositoryInterface
   {
       public function getPublished();
   }
   ```

3. **Form Requests:**
   ```php
   // app/Http/Requests/StorePostRequest.php
   class StorePostRequest extends FormRequest
   {
       public function rules()
       {
           return [
               'title' => 'required|max:255',
               'content' => 'required',
           ];
       }
   }
   ```

## Common Tasks

### Adding a New Admin Page

1. **Create Controller Method:**
   ```php
   public function reports()
   {
       $data = [
           'total_posts' => Post::count(),
           'published_posts' => Post::published()->count(),
       ];
       
       return view('admin.reports', compact('data'));
   }
   ```

2. **Add Route:**
   ```php
   Route::get('/admin/reports', [AdminController::class, 'reports'])
       ->name('admin.reports');
   ```

3. **Create View:**
   ```blade
   @extends('layouts.app')
   
   @section('content')
   <h1>Reports</h1>
   <div class="row">
       <div class="col-md-3">
           <div class="card">
               <div class="card-body">
                   <h5>Total Posts</h5>
                   <h2>{{ $data['total_posts'] }}</h2>
               </div>
           </div>
       </div>
   </div>
   @endsection
   ```

4. **Add to Navigation:**
   In `layouts/app.blade.php`, add to admin dropdown:
   ```blade
   <li><a class="dropdown-item" href="{{ route('admin.reports') }}">Reports</a></li>
   ```

### Working with File Uploads

1. **Update Model:**
   ```php
   protected $fillable = ['title', 'content', 'image_path'];
   ```

2. **Handle Upload in Controller:**
   ```php
   public function store(Request $request)
   {
       $request->validate([
           'image' => 'image|mimes:jpeg,png,jpg|max:2048',
       ]);

       $imagePath = $request->file('image')->store('posts', 'public');

       Post::create([
           'title' => $request->title,
           'image_path' => $imagePath,
       ]);
   }
   ```

3. **Display Image:**
   ```blade
   <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}">
   ```

## Troubleshooting

### Common Issues

1. **Permission Denied Errors:**
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

2. **Database Connection Issues:**
   - Check `.env` database credentials
   - Ensure MySQL service is running
   - Verify database exists

3. **Class Not Found:**
   ```bash
   composer dump-autoload
   ```

4. **Clear Cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

### Debug Mode

Enable debug mode in `.env`:
```env
APP_DEBUG=true
```

Use `dd()` for debugging:
```php
dd($variable); // Dump and die
dump($variable); // Dump and continue
```

## Conclusion

This Laravel boilerplate provides a solid foundation for building web applications with RBAC, user management, and modern UI. Follow this guide to extend the functionality according to your project requirements.

For more advanced Laravel features, refer to the [official Laravel documentation](https://laravel.com/docs).

## Support

If you encounter any issues or need help:

1. Check the Laravel documentation
2. Review this guide
3. Check GitHub issues
4. Create a new issue with detailed information 