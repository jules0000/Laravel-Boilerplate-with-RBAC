@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-chart-line me-2"></i>Manager Dashboard
    </h1>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users') }}" class="btn btn-primary">
            <i class="fas fa-users me-2"></i>Manage Users
        </a>
    </div>
</div>

<!-- Manager Statistics -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="mb-0">{{ $managerStats['total_users'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Active Users</h5>
                        <h2 class="mb-0">{{ $managerStats['active_users'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">New This Week</h5>
                        <h2 class="mb-0">{{ $managerStats['recent_registrations'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-plus fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i>Recent Users
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px; font-size: 12px;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No recent users</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm">
                        View All Users <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Manager Tools
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-users me-2 text-primary"></i>User Management</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user-plus me-2 text-success"></i>Add New User</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                    <a href="{{ route('dashboard.profile') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-user-cog me-2 text-info"></i>My Profile</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Manager Info
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-2">You have manager-level access to user management features.</p>
                <small class="text-muted">
                    Current role: <strong>Manager</strong><br>
                    Last login: {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'Never' }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection 