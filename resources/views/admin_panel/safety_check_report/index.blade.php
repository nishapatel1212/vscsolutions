@extends('adminlte::page')

@section('title', 'Safety Check Reports')

@section('content_header') <h1>Safety Check Reports</h1>
@endsection

@section('css') <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('safetycheckreport.create') }}" class="btn btn-primary mb-3">
        Add Report
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered" id="reportsTable">
            <thead>
                <tr>
                    {{-- <th>Safety Check ID</th> --}}
                    <th>Actions</th>
                    <th>Client Name</th>
                    <th>Address</th>
                    <th>Date</th>
                    <th>Created</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection

@section('js') <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#reportsTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            pageLength: 10,
            ajax: "{{ route('safetycheckreport.index') }}",

            columns: [
                // {
                //     data: 'DT_RowIndex',
                //     name: 'DT_RowIndex',
                //     orderable: false,
                //     searchable: false
                // },
                // {
                //     data: 'id',
                //     name: 'id'
                // },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'client_name',
                    name: 'client_name'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'report_date',
                    name: 'report_date'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ]
        });
    });
</script>

@endsection