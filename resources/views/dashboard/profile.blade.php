@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-user-cog me-2"></i>My Profile
    </h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h5>{{ $user->name }}</h5>
                            <p class="text-muted">
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info">{{ ucfirst($role->name) }}</span>
                                @endforeach
                            </p>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Account Status:</strong>
                                    @if($user->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Member Since:</strong>
                                    {{ $user->created_at->format('M d, Y') }}
                                </div>
                                <div class="col-md-6 mt-2">
                                    <strong>Last Login:</strong>
                                    {{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}
                                </div>
                                <div class="col-md-6 mt-2">
                                    <strong>Email Verified:</strong>
                                    @if($user->email_verified_at)
                                        <span class="text-success"><i class="fas fa-check-circle"></i> Yes</span>
                                    @else
                                        <span class="text-warning"><i class="fas fa-exclamation-triangle"></i> No</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3"><i class="fas fa-edit me-2"></i>Update Information</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <h5 class="mb-3"><i class="fas fa-lock me-2"></i>Change Password</h5>
                    <p class="text-muted">Leave password fields blank if you don't want to change your password.</p>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 