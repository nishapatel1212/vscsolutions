@extends('layouts.app')

@section('title', 'Permissions')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Permissions</h1>
        <p class="page-subtitle">Manage individual permissions</p>
    </div>

    <a href="{{ route('permissions.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i>
        Add Permission
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

<div class="panel">
    <div class="panel-header">
        <h5><i class="fas fa-key me-2"></i> All Permissions</h5>
    </div>

    <div class="table-responsive">
        <table class="table w-100">
            <thead>
                <tr>
                    <th>Permission</th>
                    <th>Used in Roles</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td><span class="quote-number">{{ $permission->name }}</span></td>
                        <td>{{ $permission->roles_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('permissions.edit', $permission->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline" data-confirm="Delete this permission?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete" style="border:none;background:none;color:var(--danger);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
