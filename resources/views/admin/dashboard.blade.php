@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-cog me-2"></i>Admin Dashboard
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>Add User
        </a>
        <a href="{{ route('admin.system-info') }}" class="btn btn-outline-info">
            <i class="fas fa-info-circle me-2"></i>System Info
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="mb-0">{{ $totalUsers }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.users') }}" class="text-white text-decoration-none">
                    View Details <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Active Users</h5>
                        <h2 class="mb-0">{{ $activeUsers }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <small>{{ round(($activeUsers / max($totalUsers, 1)) * 100, 1) }}% of total users</small>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Roles</h5>
                        <h2 class="mb-0">{{ $totalRoles }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.roles') }}" class="text-white text-decoration-none">
                    Manage Roles <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Permissions</h5>
                        <h2 class="mb-0">{{ $totalPermissions }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-key fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.permissions') }}" class="text-white text-decoration-none">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-grid">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-grid">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-success">
                                <i class="fas fa-user-plus me-2"></i>Create New User
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-grid">
                            <a href="{{ route('admin.roles') }}" class="btn btn-outline-info">
                                <i class="fas fa-shield-alt me-2"></i>Manage Roles
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-grid">
                            <a href="{{ route('admin.permissions') }}" class="btn btn-outline-warning">
                                <i class="fas fa-key me-2"></i>View Permissions
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>System Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="border-end">
                            <h3 class="text-primary">{{ $totalUsers }}</h3>
                            <p class="text-muted mb-0">Total Users</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border-end">
                            <h3 class="text-success">{{ $activeUsers }}</h3>
                            <p class="text-muted mb-0">Active Users</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h3 class="text-warning">{{ $totalUsers - $activeUsers }}</h3>
                        <p class="text-muted mb-0">Inactive Users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tools me-2"></i>Admin Tools
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-users me-2 text-primary"></i>User Management</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                    <a href="{{ route('admin.roles') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-shield-alt me-2 text-info"></i>Role Management</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                    <a href="{{ route('admin.permissions') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-key me-2 text-warning"></i>Permissions</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                    <a href="{{ route('admin.system-info') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-info-circle me-2 text-secondary"></i>System Info</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Security Notice
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning mb-0">
                    <strong>Important:</strong> You have administrator privileges. Use them responsibly and ensure proper security measures are in place.
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-2">System activities will appear here.</p>
                <small class="text-muted">
                    Last login: {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'Never' }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
