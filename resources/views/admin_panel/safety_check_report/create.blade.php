@extends('adminlte::page')

@section('title', 'Create Safety Report')

@section('content_header')
<h1>Create Safety Check Report</h1>
@endsection

@section('content')

<form action="{{ !empty($data) ? route('safetycheckreport.update') : route('safetycheckreport.store') }}" method="POST">
    @csrf

    <input type="hidden" name="id" class="form-control" value="{{ $data->id ?? '' }}">

    <div class="card card-warning shadow-sm">
        <div class="card-header text-white">
            <h5 class="mb-0">General Information</h5>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $data->address ?? old('address') }}">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror

                </div>

                <div class="col-md-6 mb-3">
                    <label>Report Date</label>
                    <input type="date" name="report_date" class="form-control @error('report_date') is-invalid @enderror" value="{{ old('report_date', isset($data->report_date) ? \Carbon\Carbon::parse($data->report_date)->format('Y-m-d') : date('Y-m-d')) }}">
                    @error('report_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Date of previous Safety Check (if any):</label>
                    <input type="date" name="previous_safety_date" class="form-control @error('previous_safety_date') is-invalid @enderror" value="{{ old('previous_safety_date', $data->previous_safety_date) }}">
                    @error('previous_safety_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Electrical Safety Check</label>
                    <input type="text" name="safety_check_status" class="form-control @error('safety_check_status') is-invalid @enderror" value="{{ $data->safety_check_status ?? old('safety_check_status') }}">
                    @error('safety_check_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Details</label>
                    <textarea name="details" class="form-control" rows="1">{{ $data->details ?? old('details') }}</textarea>
                </div>
            </div>

        </div>
    </div>

    <div class="card card-warning shadow-sm">
        <div class="card-header text-white">
            <h5 class="mb-0">Observations And Recommendations For Any Actions To Be Taken</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="faultTable">
                <thead>
                    <tr>
                        <th>Fault</th>
                        <th>Required Rectification</th>
                        <th>Repair Completed?</th>
                        <th>Assessment</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($data->faults))
                        @foreach($data->faults as $index => $fault)
                            <tr>
                                <input type="hidden" name="faults[id][]" value="{{ $fault->id }}" class="form-control">
                                <td>
                                    <input type="text" name="faults[fault_name][]" value="{{ $fault->fault }}" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="faults[required_rectification][]" class="form-control" value="{{ $fault->required_rectification }}">
                                </td>
                                <td>
                                    <select name="faults[repair_completed][]" class="form-control">
                                        <option value="1" {{ $fault->repair_completed ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$fault->repair_completed ? 'selected' : '' }}>No</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="faults[assessment][]" value="{{ $fault->assessment }}" class="form-control">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success addRow">+</button>
                                    <button type="button" class="btn btn-danger removeRow">−</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <!-- Empty row for create page -->
                        <tr>
                            <td>
                                <input type="text" name="faults[fault_name][]" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="faults[required_rectification][]" class="form-control">
                            </td>
                            <td>
                                <select name="faults[repair_completed][]" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="faults[assessment][]" class="form-control">
                            </td>
                            <td>
                                <button type="button" class="btn btn-success addRow">+</button>
                                <button type="button" class="btn btn-danger removeRow">−</button>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('safetycheckreport.index') }}" class="btn btn-secondary">Back</a>

</form>
@endsection

@section('js') <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).on('click', '.addRow', function() {
        let table = $('#faultTable tbody');
        let row = table.find('tr:first').clone();

        // clear input values
        row.find('input').val('');

        // reset dropdown
        row.find('select').prop('selectedIndex', 0);

        table.append(row);
    });

    $(document).on('click', '.removeRow', function() {
        if ($('#faultTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });
</script>

@endsection