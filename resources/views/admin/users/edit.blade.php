@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary me-3">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1 class="mb-0">
        <i class="fas fa-user-edit me-2"></i>Edit User: {{ $user->name }}
    </h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

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

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Leave blank to keep current password. Must be at least 8 characters if changed.</div>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Select a role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" 
                                    {{ old('role', $user->getRoleNames()->first()) == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active User
                            </label>
                        </div>
                        <div class="form-text">Inactive users cannot log in to the system.</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Account Info</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <small class="text-muted">
                                        <strong>Created:</strong> {{ $user->created_at->format('M d, Y H:i') }}<br>
                                        <strong>Last Login:</strong> {{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}<br>
                                        @if($user->last_login_ip)
                                            <strong>Last IP:</strong> {{ $user->last_login_ip }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update User
                        </button>
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        @if($user->id !== auth()->id())
                            <button type="button" class="btn btn-danger ms-auto" onclick="deleteUser()">
                                <i class="fas fa-trash me-2"></i>Delete User
                            </button>
                        @endif
                    </div>
                </form>

                @if($user->id !== auth()->id())
                    <form id="deleteForm" method="POST" action="{{ route('admin.users.delete', $user) }}" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function deleteUser() {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection 