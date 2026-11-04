@extends('layouts.app')

@section('title', 'Quote Price List')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title page-title-sm">Quote Price List</h1>
        <p class="page-subtitle">Drives AI quote drafting and the chatbot's price guide — no code changes needed</p>
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
        <h5><i class="fas fa-plus me-2"></i> Add Price Item</h5>
    </div>
    <div class="p-4">
        <form action="{{ route('settings.price-list.store') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-md-3">
                <label class="form-label">Keyword</label>
                <input type="text" name="keyword" class="form-control" placeholder="e.g. downlight" value="{{ old('keyword') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control" placeholder="e.g. Install downlight" value="{{ old('description') }}" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Amount ($)</label>
                <input type="number" name="amount" class="form-control" step="0.01" min="0" value="{{ old('amount') }}" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" placeholder="domestic" value="{{ old('category') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-gold w-100"><i class="fas fa-plus"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="panel">
    <div class="table-responsive">
        <table class="table data-table data-table-striped w-100" id="priceListTable">
            <thead>
                <tr>
                    <th>Keyword</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Category</th>
                    <th>Active</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($priceItems as $item)
                    <tr class="view-row" data-row-id="{{ $item->id }}">
                        <td>{{ $item->keyword }}</td>
                        <td>{{ $item->description }}</td>
                        <td>${{ number_format($item->amount, 2) }}</td>
                        <td>{{ $item->category ?? '—' }}</td>
                        <td>
                            <span class="status-badge status-{{ $item->active ? 'completed' : 'cancelled' }}">
                                {{ $item->active ? 'active' : 'inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn-icon btn-icon-edit toggle-edit-row" data-row-id="{{ $item->id }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('settings.price-list.destroy', $item->id) }}" method="POST" class="d-inline" data-confirm="Delete this price item?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete" style="border:none;background:none;color:var(--danger);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr class="edit-row" data-row-id="{{ $item->id }}" style="display:none;">
                        <td colspan="6">
                            <form action="{{ route('settings.price-list.update', $item->id) }}" method="POST" class="row g-2 align-items-end">
                                @csrf
                                @method('PUT')
                                <div class="col-md-2">
                                    <input type="text" name="keyword" class="form-control form-control-sm" value="{{ $item->keyword }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="description" class="form-control form-control-sm" value="{{ $item->description }}" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="amount" class="form-control form-control-sm" step="0.01" min="0" value="{{ $item->amount }}" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="category" class="form-control form-control-sm" value="{{ $item->category }}">
                                </div>
                                <div class="col-md-1">
                                    <div class="form-check">
                                        <input type="checkbox" name="active" class="form-check-input" id="active{{ $item->id }}" value="1" {{ $item->active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active{{ $item->id }}">On</label>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex gap-1">
                                    <button type="submit" class="btn btn-sm btn-gold">Save</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary toggle-edit-row" data-row-id="{{ $item->id }}">Cancel</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No price items yet.</td>
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
