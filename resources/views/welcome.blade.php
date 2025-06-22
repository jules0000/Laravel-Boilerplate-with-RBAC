@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="hero-section bg-primary text-white py-5 mb-5 rounded">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-4">
            <i class="fas fa-rocket me-3"></i>Laravel Boilerplate
        </h1>
        <p class="lead mb-4">
            A powerful starting point for your Laravel applications with built-in RBAC, MySQL integration, and modern UI.
        </p>
        
        @guest
            <div class="d-flex gap-3 justify-content-center">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-plus me-2"></i>Get Started
                </a>
            </div>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
            </a>
        @endguest
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-shield-alt fa-lg"></i>
                </div>
                <h5 class="card-title">Role-Based Access Control</h5>
                <p class="card-text">Complete RBAC system with Admin, Manager, and User roles. Granular permissions for secure access control.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-database fa-lg"></i>
                </div>
                <h5 class="card-title">MySQL Integration</h5>
                <p class="card-text">Pre-configured MySQL database setup with migrations, seeders, and optimized connections for production use.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body text-center">
                <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-code fa-lg"></i>
                </div>
                <h5 class="card-title">Developer Friendly</h5>
                <p class="card-text">Clean, documented code structure with comprehensive guides for extending functionality and adding new features.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6 mb-4">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-users text-primary me-2"></i>User Management
                </h5>
                <ul class="list-unstyled mb-0">
                    <li><i class="fas fa-check text-success me-2"></i>User registration and authentication</li>
                    <li><i class="fas fa-check text-success me-2"></i>Profile management</li>
                    <li><i class="fas fa-check text-success me-2"></i>Role assignment</li>
                    <li><i class="fas fa-check text-success me-2"></i>Activity tracking</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card bg-light">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-tools text-primary me-2"></i>Admin Features
                </h5>
                <ul class="list-unstyled mb-0">
                    <li><i class="fas fa-check text-success me-2"></i>Complete user administration</li>
                    <li><i class="fas fa-check text-success me-2"></i>Role and permission management</li>
                    <li><i class="fas fa-check text-success me-2"></i>System monitoring</li>
                    <li><i class="fas fa-check text-success me-2"></i>Database insights</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@guest
<div class="text-center mt-5 p-4 bg-light rounded">
    <h4>Ready to get started?</h4>
    <p class="mb-3">Join thousands of developers using our Laravel boilerplate to build amazing applications.</p>
    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-rocket me-2"></i>Start Building Now
    </a>
</div>
@endguest

@endsection 