@extends('layouts.app')

@section('title', 'Job Type Keywords')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title page-title-sm">Job Type Keywords</h1>
        <p class="page-subtitle">Maps free-text words to a job type — used by the chatbot and lead auto-classification</p>
    </div>
    <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Settings
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

@if($errors->any())
    <div class="alert-soft alert-danger mb-3">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="panel mb-4">
    <div class="panel-header">
        <h5><i class="fas fa-plus me-2"></i> Add Keyword</h5>
    </div>
    <div class="p-4">
        <form action="{{ route('settings.job-keywords.store') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Keyword</label>
                <input type="text" name="keyword" class="form-control" placeholder="e.g. gpo" value="{{ old('keyword') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Job Type</label>
                <input type="text" name="job_type" class="form-control" placeholder="e.g. powerpoint" value="{{ old('job_type') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" placeholder="domestic / commercial / ..." value="{{ old('category') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-gold w-100"><i class="fas fa-plus"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table data-table data-table-striped w-100" id="keywordsTable">
            <thead>
                <tr>
                    <th>Keyword</th>
                    <th>Job Type</th>
                    <th>Category</th>
                    <th>Active</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($keywords as $keyword)
                    <tr class="view-row" data-row-id="{{ $keyword->id }}">
                        <td>{{ $keyword->keyword }}</td>
                        <td>{{ $keyword->job_type }}</td>
                        <td>{{ $keyword->category ?? '—' }}</td>
                        <td>
                            <span class="status-badge status-{{ $keyword->active ? 'completed' : 'cancelled' }}">
                                {{ $keyword->active ? 'active' : 'inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn-icon btn-icon-edit toggle-edit-row" data-row-id="{{ $keyword->id }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('settings.job-keywords.destroy', $keyword->id) }}" method="POST" class="d-inline" data-confirm="Delete this keyword?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete" style="border:none;background:none;color:var(--danger);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr class="edit-row" data-row-id="{{ $keyword->id }}" style="display:none;">
                        <td colspan="5">
                            <form action="{{ route('settings.job-keywords.update', $keyword->id) }}" method="POST" class="row g-2 align-items-end">
                                @csrf
                                @method('PUT')
                                <div class="col-md-3">
                                    <input type="text" name="keyword" class="form-control form-control-sm" value="{{ $keyword->keyword }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="job_type" class="form-control form-control-sm" value="{{ $keyword->job_type }}" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="category" class="form-control form-control-sm" value="{{ $keyword->category }}">
                                </div>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="active" class="form-check-input" id="active{{ $keyword->id }}" value="1" {{ $keyword->active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active{{ $keyword->id }}">Active</label>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex gap-1">
                                    <button type="submit" class="btn btn-sm btn-gold">Save</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary toggle-edit-row" data-row-id="{{ $keyword->id }}">Cancel</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No keywords yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/pages/settings-tables.js') }}"></script>
@endpush
