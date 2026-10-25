@extends('layouts.app')

@section('title', 'Create Safety Report')

@section('content_header')
<div>
    <h1 class="page-title">Create Safety Check Report</h1>
</div>
@endsection

@php
    $faults = !empty($data->faults) ? $data->faults->toArray() : old('faults', []);
    $oldInspectionItems = old('visual_inspection_items', []);
    $old_inspection_items = old('inspection_items', []);
    $old_polarity_testing_items = old('polarity_testing_items', []);
    $old_earth_testing_items = old('earth_testing_items', []);
@endphp

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

<form action="{{ !empty($data) ? route('safetycheckreport.update') : route('safetycheckreport.store') }}" method="POST" enctype="multipart/form-data"
      data-inspection-items-url="{{ route('inspection-items.store') }}"
      data-visual-inspection-items-url="{{ route('visual-inspection-items.store') }}"
      data-polarity-testing-items-url="{{ route('polarity-testing-items.store') }}"
      data-earth-testing-items-url="{{ route('earth-testing-items.store') }}">
    @csrf

    <input type="hidden" name="id" class="form-control" value="{{ $data->id ?? '' }}">

    {{-- General Information --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-info-circle me-2"></i> General Information</h5>
        </div>

        <div class="p-4">

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Client Name <span class="text-danger">*</span></label>
                    <input type="text" name="client_name" class="form-control @error('client_name') is-invalid @enderror" value="{{ $data->client_name ?? old('client_name') }}">
                    @error('client_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ $data->address ?? old('address') }}">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Report Date</label>
                    <input type="date" name="report_date" class="form-control @error('report_date') is-invalid @enderror" value="{{ old('report_date', isset($data->report_date) ? \Carbon\Carbon::parse($data->report_date)->format('Y-m-d') : date('Y-m-d')) }}">
                    @error('report_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date of previous Safety Check (if any)</label>
                    <input type="date" name="previous_safety_date" class="form-control @error('previous_safety_date') is-invalid @enderror" value="{{ $data->previous_safety_date ?? old('previous_safety_date') }}">
                    @error('previous_safety_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-md-6">
                    <label class="form-label">Electrical Safety Check <span class="text-danger">*</span></label>
                    <input type="text" name="safety_check_status" class="form-control @error('safety_check_status') is-invalid @enderror" value="{{ $data->safety_check_status ?? old('safety_check_status') }}">
                    @error('safety_check_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Details</label>
                    <textarea name="details" class="form-control" rows="1">{{ $data->details ?? old('details') }}</textarea>
                </div>
            </div>

        </div>
    </div>

    {{-- Fault List --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-exclamation-triangle me-2"></i> Observations And Recommendations For Any Actions To Be Taken</h5>
        </div>

        <div class="p-4">
            <div class="fault-table-wrap">
                <table class="table table-bordered fault-table" id="faultTable">
                    <thead>
                        <tr>
                            <th>Fault <span class="text-danger">*</span></th>
                            <th>Rectification</th>
                            <th>Location</th>
                            <th>Repair Completed?</th>
                            <th>Assessment</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($faults) && count($faults) > 0)
                            @foreach($faults as $index => $d)
                                <tr>
                                    <input type="hidden" name="faults[{{ $index }}][id]" value="{{ $d['id'] ?? '' }}" class="form-control">
                                    <td>
                                        <input type="text" name="faults[{{ $index }}][fault]" value="{{ $d['fault'] }}" class="form-control @error('faults.'.$index.'.fault') is-invalid @enderror">

                                        @error('faults.'.$index.'.fault')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="text" name="faults[{{ $index }}][required_rectification]" class="form-control" value="{{ $d['required_rectification'] }}">
                                    </td>
                                    <td>
                                        <input type="text" name="faults[{{ $index }}][location]" value="{{ $d['location'] }}" class="form-control">
                                    </td>
                                    <td>
                                        <select name="faults[{{ $index }}][repair_completed]" class="form-control">
                                            <option value="1" {{ $d['repair_completed'] ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ !$d['repair_completed'] ? 'selected' : '' }}>No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="faults[{{ $index }}][assessment]" value="{{ $d['assessment'] }}" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" name="faults[{{ $index }}][image]" class="form-control image-input" accept="image/*" style="width:200px;">

                                        @if(!empty($d['image']))
                                            <img src="{{ asset('storage/'.$d['image']) }}" class="img-preview mt-2" style="width:150px; height:190px; object-fit:cover; border-radius:6px;">
                                        @else
                                            <img class="img-preview mt-2" style="display:none; width:100px; height:100px; object-fit:cover; border-radius:6px;">
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="row-action-btn addRow"><i class="fas fa-plus"></i></button>
                                        <button type="button" class="row-action-btn removeRow"><i class="fas fa-minus"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>
                                    <input type="text" name="faults[0][fault]" class="form-control @error('faults.fault.0') is-invalid @enderror">
                                    @error('faults.fault.0')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" name="faults[0][required_rectification]" class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="faults[0][location]" class="form-control">
                                </td>
                                <td>
                                    <select name="faults[0][repair_completed]" class="form-control">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="faults[0][assessment]" class="form-control">
                                </td>
                                <td>
                                    <input type="file" name="faults[0][image]" class="form-control image-input" accept="image/*" style="width:200px;">
                                    <img class="img-preview mt-2" style="display:none; width:100px; height:100px; object-fit:cover; border-radius:6px;">
                                </td>
                                <td>
                                    <button type="button" class="row-action-btn addRow"><i class="fas fa-plus"></i></button>
                                    <button type="button" class="row-action-btn removeRow"><i class="fas fa-minus"></i></button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Inspection items --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-clipboard-list me-2"></i> Extent Of The Installation And Limitations Of The Inspection And Testing</h5>
        </div>

        <div class="p-4">

            <div class="row">
                @foreach($inspection_items as $item)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="inspection_items[]"
                                value="{{ $item->id }}"
                                class="form-check-input big-checkbox"
                                id="item{{ $item->id }}"
                                {{ ((isset($data) && $data->inspectionItems->pluck('id')->contains($item->id)) || in_array($item->id, $old_inspection_items)) ? 'checked' : '' }}>

                            <label class="form-check-label" for="item{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            <div class="mt-3 add-item-inline">
                <label class="form-label">Add New Item</label>
                <div class="d-flex">
                    <input type="text" id="newItemName" class="form-control me-2" placeholder="Enter new item">
                    <button type="button" class="btn" onclick="addNewItem()">Add</button>
                </div>
            </div>

        </div>
    </div>

    {{-- Visual Inspection Items --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-eye me-2"></i> C. Safety Check - Verified By Visual Inspection</h5>
        </div>

        <div class="p-4">
            <div class="row">
                @foreach($visual_inspection_items as $item)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="visual_inspection_items[]"
                                value="{{ $item->id }}"
                                class="form-check-input big-checkbox"
                                id="visualItem{{ $item->id }}"
                               {{ ((isset($data) && $data->visualInspectionItems->pluck('id')->contains($item->id)) || in_array($item->id, $oldInspectionItems)) ? 'checked' : '' }}>

                            <label class="form-check-label" for="visualItem{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            <div class="mt-3 add-item-inline">
                <label class="form-label">Add New Item</label>
                <div class="d-flex">
                    <input type="text" id="newVisualItemName" class="form-control me-2" placeholder="Enter new item">
                    <button type="button" class="btn" onclick="addNewVisualItem()">Add</button>
                </div>
            </div>

        </div>
    </div>

    {{-- Polarity And Correct Connections Testing --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-plug me-2"></i> Polarity And Correct Connections Testing</h5>
        </div>

        <div class="p-4">
            <div class="row" id="polarityTestingItemsContainer">
                @foreach($polarity_testing_items as $item)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="polarity_testing_items[]"
                                value="{{ $item->id }}"
                                class="form-check-input big-checkbox"
                                id="polarityItem{{ $item->id }}"
                                {{ ((isset($data) && $data->polarityTestingItems->pluck('id')->contains($item->id)) || in_array($item->id, $old_polarity_testing_items)) ? 'checked' : '' }}>

                            <label class="form-check-label" for="polarityItem{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>
            <div class="mt-3 add-item-inline">
                <label class="form-label">Add New Item</label>
                <div class="d-flex">
                    <input type="text" id="newPolarityItemName" class="form-control me-2" placeholder="Enter new item">
                    <button type="button" class="btn" onclick="addNewPolarityItem()">Add</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Earth Continuity Testing --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-bolt me-2"></i> Earth Continuity Testing</h5>
        </div>

        <div class="p-4">
            <div class="row" id="earthTestingItemsContainer">
                @foreach($earth_testing_items as $item)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="earth_testing_items[]"
                                value="{{ $item->id }}"
                                class="form-check-input big-checkbox"
                                id="earthItem{{ $item->id }}"
                                {{ ((isset($data) && $data->earthTestingItems->pluck('id')->contains($item->id)) || in_array($item->id, $old_earth_testing_items)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="earthItem{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>
            <div class="mt-3 add-item-inline">
                <label class="form-label">Add New Item</label>
                <div class="d-flex">
                    <input type="text" id="newEarthItemName" class="form-control me-2" placeholder="Enter new item">
                    <button type="button" class="btn" onclick="addNewEarthItem()">Add</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Images --}}
    <div class="panel mb-4">
        <div class="panel-header">
            <h5><i class="fas fa-images me-2"></i> Report Images</h5>
        </div>

        <div class="p-4">
            <div id="image-wrapper" data-next-index="{{ isset($data) ? $data->images->count() : 1 }}">

                @if(isset($data) && $data->images->count())
                    @foreach($data->images as $i => $image)
                    <div class="row g-3 align-items-center image-row mb-3 p-4 border rounded">

                        <input type="hidden" name="images[{{ $i }}][id]" value="{{ $image->id }}">

                        <div class="col-md-4">
                            <label class="form-label">Image Title</label>
                            <input type="text" name="images[{{ $i }}][title]" class="form-control" value="{{ $image->title }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Choose Image (leave empty to keep existing)</label>
                            <input type="file" name="images[{{ $i }}][file]" class="form-control image-input" accept="image/*">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Preview</label>
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail preview-img" style="height:200px; width:100%; object-fit:cover;">
                        </div>

                        <div class="col-md-1 text-end">
                            <button type="button" class="remove-row mt-4"><i class="fas fa-times"></i></button>
                        </div>

                    </div>
                    @endforeach

                @else
                    <div class="row g-3 align-items-center image-row mb-3 p-4 border rounded">

                        <div class="col-md-4">
                            <label class="form-label">Image Title</label>
                            <input type="text" name="images[0][title]" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Choose Image</label>
                            <input type="file" name="images[0][file]" class="form-control image-input" accept="image/*">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Preview</label>
                            <img src="" class="img-thumbnail preview-img" style="height:200px; width:100%; object-fit:cover; display:none;">
                        </div>

                        <div class="col-md-1 text-end">
                            <button type="button" class="remove-row mt-4"><i class="fas fa-times"></i></button>
                        </div>

                    </div>
                @endif

            </div>

            <div class="d-flex justify-content-between mt-3">
                <button type="button" id="add-more">
                    <i class="fas fa-plus me-1"></i> Add More Images
                </button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-2">
        <button type="submit" class="btn btn-gold btn-lg">
            <i class="fas fa-save"></i>
            Save
        </button>
        <a href="{{ route('safetycheckreport.index') }}" class="btn btn-outline-secondary btn-lg">
            <i class="fas fa-times"></i>
            Back
        </a>
    </div>

</form>
@endsection

@push('scripts')
<script src="{{ asset('js/pages/safety-check-create.js') }}"></script>
@endpush
