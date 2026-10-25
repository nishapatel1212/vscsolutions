@extends('layouts.app')

@section('title', 'Roles')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Roles</h1>
        <p class="page-subtitle">Manage roles and their permissions</p>
    </div>

    <a href="{{ route('roles.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i>
        Add Role
    </a>
</div>
@endsection

@section('content')

@if(session('success'))
    <div class="alert-soft alert-success mb-3">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-soft alert-danger mb-3">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<div class="panel">
    <div class="panel-header">
        <h5><i class="fas fa-user-shield me-2"></i> All Roles</h5>
    </div>

    <div class="table-responsive">
        <table class="table w-100">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Users</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td><span class="quote-number">{{ $role->name }}</span></td>
                        <td>{{ $role->permissions->count() }}</td>
                        <td>{{ $role->users_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @unless(in_array($role->name, ['super-admin', 'electrician']))
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" data-confirm="Delete this role?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="Delete" style="border:none;background:none;color:var(--danger);">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endunless
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
