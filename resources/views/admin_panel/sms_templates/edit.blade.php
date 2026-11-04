@extends('layouts.app')

@section('title', 'Edit SMS Template')

@section('content_header')
<div>
    <h1 class="page-title">Edit SMS Template</h1>
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

<form action="{{ route('sms-templates.update', $template->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-comment-sms me-2"></i> Template Details</h5>
        </div>

        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Template Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $template->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Trigger Type <span class="text-danger">*</span></label>
                    <select name="trigger_type" class="form-control @error('trigger_type') is-invalid @enderror" required>
                        <option value="manual" {{ old('trigger_type', $template->trigger_type) == 'manual' ? 'selected' : '' }}>Manual only</option>
                        <option value="job_reminder" {{ old('trigger_type', $template->trigger_type) == 'job_reminder' ? 'selected' : '' }}>Job Reminder</option>
                        <option value="quote_followup" {{ old('trigger_type', $template->trigger_type) == 'quote_followup' ? 'selected' : '' }}>Quote Follow-up</option>
                        <option value="invoice_due" {{ old('trigger_type', $template->trigger_type) == 'invoice_due' ? 'selected' : '' }}>Invoice Due Reminder</option>
                    </select>
                    @error('trigger_type') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12">
                    <label class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="4" maxlength="1600">{{ old('message', $template->message) }}</textarea>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i>
                        Use <code>@{{name}}</code> anywhere to insert the customer's name. Keep it short — standard SMS is 160 characters per segment.
                    </small>
                    @error('message') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i> Save Template
        </button>
        <a href="{{ route('sms-templates.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>

@endsection
