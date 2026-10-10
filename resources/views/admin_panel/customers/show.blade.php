@extends('layouts.app')

@section('title', $customer->name)

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h1 class="page-title">{{ $customer->name }}</h1>
        <p class="page-subtitle">Customer profile</p>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-outline-secondary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="panel mb-4">
            <div class="panel-header">
                <h5><i class="fas fa-address-card me-2"></i> Contact Info</h5>
            </div>
            <div class="p-4">
                <p><strong>Phone:</strong> {{ $customer->phone ?? '—' }}</p>
                <p><strong>Email:</strong> {{ $customer->email ?? '—' }}</p>
                <p><strong>Address:</strong><br>{{ $customer->address ?? '—' }}</p>
                @if($customer->notes)
                    <hr>
                    <p><strong>Notes:</strong><br>{{ $customer->notes }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="panel mb-4">
            <div class="panel-header">
                <h5><i class="fas fa-file-invoice me-2"></i> Quote History</h5>
            </div>

            <div class="table-responsive">
                <table class="table data-table mb-0">
                    <thead>
                        <tr>
                            <th>Quote No.</th>
                            <th>Date</th>
                            <th class="text-end">Total</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer->quotes as $quote)
                            <tr>
                                <td><span class="quote-number">{{ $quote->quote_number }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($quote->quote_date)->format('d/m/Y') }}</td>
                                <td class="text-end fw-bold">${{ number_format($quote->total ?? 0, 2) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('quote.show', $quote->id) }}" class="btn-icon" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-file-invoice"></i>
                                        No quotes for this customer yet.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection