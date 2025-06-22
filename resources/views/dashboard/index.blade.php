@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>Welcome back, {{ auth()->user()->name }}!
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Here's what's happening with your account today.</p>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Profile Completion</h6>
                                <div class="progress mt-1" style="height: 6px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $userStats['profile_completion'] }}%"></div>
                                </div>
                                <small class="text-muted">{{ $userStats['profile_completion'] }}% complete</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Role</h6>
                                <span class="badge bg-primary">{{ ucfirst($userStats['role']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row text-center">
                    <div class="col-md-6">
                        <h6 class="text-muted">Member Since</h6>
                        <p class="mb-0">{{ $userStats['member_since']->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Last Login</h6>
                        <p class="mb-0">
                            @if($userStats['last_login'])
                                {{ $userStats['last_login']->diffForHumans() }}
                            @else
                                Never
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('profile') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-user-edit me-2"></i>Edit Profile
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button class="btn btn-outline-info w-100" onclick="window.location.reload()">
                            <i class="fas fa-sync-alt me-2"></i>Refresh Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>Account Info
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Email</span>
                        <small class="text-muted">{{ auth()->user()->email }}</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Status</span>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>Role</span>
                        <span class="badge bg-primary">{{ ucfirst($userStats['role']) }}</span>
                    </div>
                </div>
            </div>
        </div>

        @role('manager|admin')
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-crown me-2"></i>Management
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">You have additional privileges.</p>
                <div class="d-grid gap-2">
                    @role('manager')
                    <a href="{{ route('manager.dashboard') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-users me-2"></i>Manager Panel
                    </a>
                    @endrole
                    @role('admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-cog me-2"></i>Admin Panel
                    </a>
                    @endrole
                </div>
            </div>
        </div>
        @endrole

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-question-circle me-2"></i>Need Help?
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Check out these resources:</p>
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-book me-2"></i>Documentation
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-life-ring me-2"></i>Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 