@extends('layouts.app')

@section('title', 'Customers')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="page-title">Customers</h1>
        <p class="page-subtitle">All clients you've worked with</p>
    </div>

    <a href="{{ route('customer.create') }}" class="btn btn-gold">
        <i class="fas fa-plus"></i>
        Add Customer
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
        <h5><i class="fas fa-users me-2"></i> All Customers</h5>
    </div>

    <div class="table-responsive">
        <table class="table data-table w-100" id="customersTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Quotes</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td><span class="quote-number">{{ $customer->name }}</span></td>
                        <td>{{ $customer->phone ?? '—' }}</td>
                        <td>{{ $customer->email ?? '—' }}</td>
                        <td>{{ $customer->quotes_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('customer.show', $customer->id) }}" class="btn-icon" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('customer.edit', $customer->id) }}" class="btn-icon btn-icon-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    initDataTable('#customersTable', {
        order: [[0, 'asc']],
        language: {
            search: '',
            searchPlaceholder: 'Search customers...',
            emptyTable: 'No customers yet — add your first one to get started.'
        }
    });
});
</script>
@endpush