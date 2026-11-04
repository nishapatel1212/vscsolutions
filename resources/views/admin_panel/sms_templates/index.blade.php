@extends('layouts.app')

@section('title', 'SMS Templates')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
    <div>
        <h1 class="page-title page-title-sm">SMS Templates</h1>
        <p class="page-subtitle">Job reminders, quote follow-ups, and invoice due reminders</p>
    </div>

    <a href="{{ route('sms-templates.create') }}" class="btn btn-gold">
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

@if($driver === 'log')
    <div class="alert-soft alert-warning mb-3">
        <i class="fas fa-triangle-exclamation"></i>
        No real SMS provider is configured yet — messages are only logged, not delivered. Set <code>SMS_DRIVER</code> in <code>.env</code> to <code>twilio</code>, <code>clicksend</code>, or <code>messagemedia</code> (with credentials) to send for real.
    </div>
@endif

<div class="panel">
    <div class="table-responsive">
        <table class="table data-table data-table-striped w-100">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Trigger Type</th>
                    <th>Message</th>
                    <th>Times Sent</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr>
                        <td><span class="quote-number">{{ $template->name }}</span></td>
                        <td>{{ str_replace('_', ' ', ucfirst($template->trigger_type)) }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($template->message, 60) }}</td>
                        <td>{{ $template->sends_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('sms-templates.showSend', $template->id) }}" class="btn-icon" title="Send to Customers">
                                <i class="fas fa-paper-plane"></i>
                            </a>
                            <a href="{{ route('sms-templates.log', $template->id) }}" class="btn-icon" title="Send Log">
                                <i class="fas fa-list"></i>
                            </a>
                            <a href="{{ route('sms-templates.edit', $template->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('sms-templates.destroy', $template->id) }}" method="POST" class="d-inline" data-confirm="Delete this template?">
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
                        <td colspan="5" class="text-center text-muted">No templates yet — add your first one.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
