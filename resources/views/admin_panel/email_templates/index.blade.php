@extends('layouts.app')

@section('title', 'Email Templates')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title page-title-sm">Email Templates</h1>
        <p class="page-subtitle">Marketing templates you can send to selected customers</p>
    </div>

    <a href="{{ route('email-templates.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i>
        Add Template
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
    <div class="table-responsive">
        <table class="table data-table data-table-striped w-100">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Times Sent</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr>
                        <td><span class="quote-number">{{ $template->name }}</span></td>
                        <td>{{ $template->subject }}</td>
                        <td>{{ $template->sends_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('email-templates.showSend', $template->id) }}" class="btn-icon" title="Send to Customers">
                                <i class="fas fa-paper-plane"></i>
                            </a>
                            <a href="{{ route('email-templates.log', $template->id) }}" class="btn-icon" title="Send Log">
                                <i class="fas fa-list"></i>
                            </a>
                            <a href="{{ route('email-templates.edit', $template->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('email-templates.destroy', $template->id) }}" method="POST" class="d-inline" data-confirm="Delete this template?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon" title="Delete" style="border:none;background:none;color:var(--danger);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No templates yet — add your first one.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
