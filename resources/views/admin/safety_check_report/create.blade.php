@extends('adminlte::page')

@section('title', 'Create Safety Report')

@section('content_header')
<h1>Create Safety Check Report</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('safetycheckreport.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror

                </div>

                <div class="col-md-6 mb-3">
                    <label>Report Date</label>
                    <input type="date" name="report_date" class="form-control" value="{{ old('report_date') }}">
                    @error('report_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label>Details</label>
                <textarea name="details" class="form-control" rows="4">{{ old('details') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('safetycheckreport.index') }}" class="btn btn-secondary">Back</a>

        </form>

    </div>
</div>

@endsection