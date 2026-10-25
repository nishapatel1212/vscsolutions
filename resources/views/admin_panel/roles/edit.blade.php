@extends('layouts.app')

@section('title', 'Edit Role')

@section('content_header')
<div>
    <h1 class="page-title">Edit Role</h1>
</div>
@endsection

@section('content')

@if($errors->any())
    <div class="alert-soft alert-danger mb-3">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-user-shield me-2"></i> Role Details</h5>
        </div>

        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Role Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}" required
                        {{ in_array($role->name, ['super-admin', 'electrician']) ? 'readonly' : '' }}>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-12">
                    <label class="form-label">Permissions</label>
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm-{{ $permission->id }}"
                                        {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i> Save Role
        </button>
        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>

@endsection
