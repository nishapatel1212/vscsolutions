@extends('layouts.app')

@php
    $isCoes = $type === 'coes';
    $title = $certificate ? 'Edit ' . ($isCoes ? 'COES' : 'Test & Tag') . ' Certificate' : 'New ' . ($isCoes ? 'Certificate of Electrical Safety (COES)' : 'Test & Tag Record');
    $items = $certificate && $certificate->items ? $certificate->items->toArray() : old('items', []);
@endphp

@section('title', $title)

@section('content_header')
<div>
    <h1 class="page-title">{{ $title }}</h1>
    @if($certificate)
        <p class="page-subtitle">{{ $certificate->certificate_number }}</p>
    @endif
</div>
@endsection

@section('content')

@if ($errors->any())
    <div class="alert-soft alert-danger mb-3" style="align-items: flex-start;">
        <i class="fas fa-exclamation-circle mt-1"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ $certificate ? route('certificates.update', $certificate->id) : route('certificates.store') }}" method="POST">
    @csrf
    @if($certificate)
        @method('PUT')
    @endif

    <input type="hidden" name="type" value="{{ $type }}">

    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-info-circle me-2"></i> Certificate Details</h5>
        </div>

        <div class="p-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Client Name <span class="text-danger">*</span></label>
                    <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror"
                           value="{{ old('client_name', $certificate->client_name ?? '') }}">
                    @error('client_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Site Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                           value="{{ old('address', $certificate->address ?? '') }}">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Customer (optional)</label>
                    <select name="customer_id" class="form-control">
                        <option value="">-- None --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id', $certificate->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Linked Safety Check Report (optional)</label>
                    <select name="safety_check_report_id" class="form-control">
                        <option value="">-- None --</option>
                        @foreach($safetyCheckReports as $report)
                            <option value="{{ $report->id }}" {{ old('safety_check_report_id', $certificate->safety_check_report_id ?? '') == $report->id ? 'selected' : '' }}>
                                #{{ $report->id }} — {{ $report->client_name }} ({{ \Carbon\Carbon::parse($report->report_date)->format('d-m-Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Issued Date <span class="text-danger">*</span></label>
                    <input type="date" name="issued_date" class="form-control @error('issued_date') is-invalid @enderror"
                           value="{{ old('issued_date', isset($certificate->issued_date) ? $certificate->issued_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
                    @error('issued_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">{{ $isCoes ? 'Expiry Date' : 'Next Test Due' }}</label>
                    <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror"
                           value="{{ old('expiry_date', isset($certificate->expiry_date) ? $certificate->expiry_date->format('Y-m-d') : '') }}">
                    @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Electrician Name</label>
                    <input type="text" name="electrician_name" class="form-control"
                           value="{{ old('electrician_name', $certificate->electrician_name ?? company('company_name')) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Licence Number</label>
                    <input type="text" name="licence_number" class="form-control"
                           value="{{ old('licence_number', $certificate->licence_number ?? '') }}">
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    @if($isCoes)
                        <select name="status" class="form-control">
                            <option value="compliant" {{ old('status', $certificate->status ?? 'compliant') == 'compliant' ? 'selected' : '' }}>Compliant</option>
                            <option value="non_compliant" {{ old('status', $certificate->status ?? '') == 'non_compliant' ? 'selected' : '' }}>Non-Compliant</option>
                        </select>
                    @else
                        <select name="status" class="form-control">
                            <option value="pass" {{ old('status', $certificate->status ?? 'pass') == 'pass' ? 'selected' : '' }}>Pass — All Items Safe</option>
                            <option value="fail" {{ old('status', $certificate->status ?? '') == 'fail' ? 'selected' : '' }}>Fail — Faulty Item(s) Found</option>
                        </select>
                    @endif
                </div>

                <div class="col-md-6">
                    <label class="form-label">Notes</label>
                    <input type="text" name="notes" class="form-control" value="{{ old('notes', $certificate->notes ?? '') }}">
                </div>
            </div>
        </div>
    </div>

    @if(!$isCoes)
    {{-- Test & Tag item register --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-tags me-2"></i> Appliance Register</h5>
        </div>

        <div class="p-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="itemsTable">
                    <thead>
                        <tr>
                            <th>Appliance <span class="text-danger">*</span></th>
                            <th>Tag Number</th>
                            <th>Result</th>
                            <th>Retest Date</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($items) && count($items) > 0)
                            @foreach($items as $index => $item)
                                <tr>
                                    <td><input type="text" name="items[{{ $index }}][appliance_name]" class="form-control" value="{{ $item['appliance_name'] ?? '' }}"></td>
                                    <td><input type="text" name="items[{{ $index }}][tag_number]" class="form-control" value="{{ $item['tag_number'] ?? '' }}"></td>
                                    <td>
                                        <select name="items[{{ $index }}][test_result]" class="form-control">
                                            <option value="pass" {{ ($item['test_result'] ?? 'pass') == 'pass' ? 'selected' : '' }}>Pass</option>
                                            <option value="fail" {{ ($item['test_result'] ?? '') == 'fail' ? 'selected' : '' }}>Fail</option>
                                        </select>
                                    </td>
                                    <td><input type="date" name="items[{{ $index }}][retest_date]" class="form-control" value="{{ isset($item['retest_date']) ? \Carbon\Carbon::parse($item['retest_date'])->format('Y-m-d') : '' }}"></td>
                                    <td><input type="text" name="items[{{ $index }}][notes]" class="form-control" value="{{ $item['notes'] ?? '' }}"></td>
                                    <td><button type="button" class="btn btn-sm btn-outline-danger removeItemRow"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td><input type="text" name="items[0][appliance_name]" class="form-control"></td>
                                <td><input type="text" name="items[0][tag_number]" class="form-control"></td>
                                <td>
                                    <select name="items[0][test_result]" class="form-control">
                                        <option value="pass" selected>Pass</option>
                                        <option value="fail">Fail</option>
                                    </select>
                                </td>
                                <td><input type="date" name="items[0][retest_date]" class="form-control"></td>
                                <td><input type="text" name="items[0][notes]" class="form-control"></td>
                                <td><button type="button" class="btn btn-sm btn-outline-danger removeItemRow"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-outline-secondary btn-sm" id="addItemRow">
                <i class="fas fa-plus"></i> Add Appliance
            </button>
        </div>
    </div>
    @endif

    <div class="text-center mb-5">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i> Save Certificate
        </button>
        <a href="{{ route('certificates.index') }}" class="btn btn-outline-secondary btn-lg">Cancel</a>
    </div>
</form>

@endsection

@push('scripts')
<script src="{{ asset('js/pages/certificates-create.js') }}"></script>
@endpush
