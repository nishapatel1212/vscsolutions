@extends('layouts.app')

@section('title', 'Create Safety Report')

@section('content_header')
<div>
    <h1 class="page-title">Create Safety Check Report</h1>
</div>
@endsection

@push('styles')
<style>
    .big-checkbox {
        transform: scale(1.6);
        margin-right: 10px;
        accent-color: var(--latin-navy);
    }

    .form-check-label {
        margin-left: 10px;
        font-size: 14px;
    }

    .form-label {
        font-weight: 600;
        font-size: 13.5px;
        color: var(--latin-navy-deep);
        margin-bottom: 6px;
    }

    .fault-table th {
        background: var(--latin-tint);
        color: var(--latin-navy-deep);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 700;
        border: none;
        padding: 12px 10px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .fault-table td {
        vertical-align: middle;
        padding: 10px;
        border-color: var(--border-soft);
    }

    .row-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        transition: all 0.15s ease;
    }

    .row-action-btn.addRow {
        background: var(--latin-tint);
        color: var(--latin-navy);
    }

    .row-action-btn.addRow:hover {
        background: var(--latin-navy);
        color: #fff;
    }

    .row-action-btn.removeRow {
        background: #FDECEA;
        color: var(--danger);
    }

    .row-action-btn.removeRow:hover {
        background: var(--danger);
        color: #fff;
    }

    .image-row {
        background: var(--page-bg);
        border-color: var(--border-soft) !important;
    }

    .remove-row {
        width: 34px;
        height: 34px;
        border-radius: 7px;
        border: none;
        background: #FDECEA;
        color: var(--danger);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
    }

    .remove-row:hover {
        background: var(--danger);
        color: #fff;
    }

    #add-more {
        background: var(--latin-tint);
        color: var(--latin-navy);
        border: none;
        font-weight: 600;
        border-radius: 7px;
        padding: 9px 16px;
        transition: all 0.15s ease;
    }

    #add-more:hover {
        background: var(--latin-navy);
        color: #fff;
    }

    .add-item-inline .btn {
        background: var(--latin-gold);
        border-color: var(--latin-gold);
        color: var(--latin-navy-deep);
        font-weight: 700;
        white-space: nowrap;
    }

    .add-item-inline .btn:hover {
        background: var(--latin-gold-dark);
        border-color: var(--latin-gold-dark);
    }

    /* ============ RESPONSIVE ============ */

    @media (max-width: 767px) {
        .panel .p-4 {
            padding: 18px !important;
        }

        .fault-table-wrap {
            overflow-x: auto;
        }

        .fault-table {
            min-width: 900px;
        }

        .image-row .col-md-1.text-end {
            text-align: left !important;
            margin-top: 8px;
        }
    }

    @media (max-width: 575px) {
        .page-title {
            font-size: 22px;
        }

        .d-flex.justify-content-center.gap-2 {
            flex-direction: column;
        }

        .d-flex.justify-content-center.gap-2 .btn {
            width: 100%;
        }
    }
</style>
@endpush

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

<form action="{{ !empty($data) ? route('safetycheckreport.update') : route('safetycheckreport.store') }}" method="POST" enctype="multipart/form-data">
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
            <div id="image-wrapper">

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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    // add new fault row
    $(document).on('click', '.addRow', function() {
        let table = $('#faultTable tbody');
        let firstRowInput = table.find('tr:first input[name*="[fault]"]');

        if (firstRowInput.val().trim() === '') {
            alert('Please fill the first Fault before adding a new row.');
            firstRowInput.focus();
            return;
        }

        let row = table.find('tr:first').clone();
        let index = table.find('tr').length;

        row.find('input, select').each(function () {
            let name = $(this).attr('name');

            if (name) {
                let newName = name.replace(/\d+/, index);
                $(this).attr('name', newName);
            }

            if ($(this).is('input[type="text"], input[type="file"]')) {
                $(this).val('');
            } else if ($(this).is('select')) {
                $(this).prop('selectedIndex', 0);
            }
        });

        row.find('img.img-preview').each(function () {
            $(this).attr('src', '');
            $(this).hide();
        });

        table.append(row);
    });

    // Remove fault row
    $(document).on('click', '.removeRow', function() {
        if ($('#faultTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });

    // fault image settings
    $(document).on('change', '.image-input', function () {
        let input = this;
        let reader = new FileReader();
        let preview = $(this).closest('td').find('.img-preview');

        if (input.files && input.files[0]) {
            reader.onload = function (e) {
                preview.attr('src', e.target.result);
                preview.show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    });

    // add new inspection item
    function addNewItem() {
        let name = document.getElementById('newItemName').value;

        if (!name) {
            alert('Enter item name');
            return;
        }

        fetch("{{ route('inspection-items.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ name: name })
        })
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector('[name="inspection_items[]"]')
                ?.closest('.row') ?? document.createElement('div');

            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
                <div class="form-check mb-2">
                    <input type="checkbox"
                        name="inspection_items[]"
                        value="${data.id}"
                        class="form-check-input big-checkbox"
                        id="item${data.id}"
                        checked>
                    <label class="form-check-label" for="item${data.id}">
                        ${data.name}
                    </label>
                </div>`;

            container.appendChild(col);
            document.getElementById('newItemName').value = '';
        });
    }

    // Add new visual Item
    function addNewVisualItem() {
        const input = document.getElementById('newVisualItemName');
        const name  = input.value.trim();

        if (!name) return;

        fetch('{{ route("visual-inspection-items.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name })
        })
        .then(res => res.json())
        .then(item => {
            const container = document.querySelector('[name="visual_inspection_items[]"]')
                ?.closest('.row') ?? document.createElement('div');

            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
                <div class="form-check mb-2">
                    <input type="checkbox"
                        name="visual_inspection_items[]"
                        value="${item.id}"
                        class="form-check-input big-checkbox"
                        id="visualItem${item.id}"
                        checked>
                    <label class="form-check-label" for="visualItem${item.id}">
                        ${item.name}
                    </label>
                </div>`;

            container.appendChild(col);
            input.value = '';
        })
        .catch(err => console.error('Failed to add item:', err));
    }

    // Add new polarity Item
    function addNewPolarityItem() {
        let name = document.getElementById('newPolarityItemName').value;
        if (!name) { alert('Enter item name'); return; }

        fetch("{{ route('polarity-testing-items.store') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ name: name })
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('polarityTestingItemsContainer');
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
                <div class="form-check mb-2">
                    <input type="checkbox" name="polarity_testing_items[]" value="${data.id}"
                        class="form-check-input big-checkbox" id="polarityItem${data.id}" checked>
                    <label class="form-check-label" for="polarityItem${data.id}">${data.name}</label>
                </div>`;
            container.appendChild(col);
            document.getElementById('newPolarityItemName').value = '';
        });
    }

    // Add new earth Item
    function addNewEarthItem() {
        let name = document.getElementById('newEarthItemName').value;
        if (!name) { alert('Enter item name'); return; }

        fetch("{{ route('earth-testing-items.store') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
            body: JSON.stringify({ name: name })
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('earthTestingItemsContainer');
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
                <div class="form-check mb-2">
                    <input type="checkbox" name="earth_testing_items[]" value="${data.id}"
                        class="form-check-input big-checkbox" id="earthItem${data.id}" checked>
                    <label class="form-check-label" for="earthItem${data.id}">${data.name}</label>
                </div>`;
            container.appendChild(col);
            document.getElementById('newEarthItemName').value = '';
        });
    }

    // image preview
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('image-input')) {
            let reader = new FileReader();
            let img = e.target.closest('.image-row').querySelector('.preview-img');

            reader.onload = function (event) {
                img.src = event.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    let index = {{ isset($data) ? $data->images->count() : 1 }};

    /* Image - ADD MORE ROW */
    $('#add-more').on('click', function () {
        let html = `
        <div class="row g-3 align-items-center image-row mb-3 p-4 border rounded">

            <div class="col-md-4">
                <label class="form-label">Image Title</label>
                <input type="text" name="images[${index}][title]" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Choose Image</label>
                <input type="file"
                    name="images[${index}][file]"
                    class="form-control image-input"
                    accept="image/*">
            </div>

            <div class="col-md-3">
                <label class="form-label">Preview</label>
                <img src="" class="img-thumbnail preview-img" style="height:200px; width:100%; object-fit:cover; display:none;">
            </div>

            <div class="col-md-1 text-end">
                <button type="button" class="remove-row">
                    <i class="fas fa-times"></i>
                </button>
            </div>

        </div>`;

        $('#image-wrapper').append(html);
        index++;
    });

    /* Image - REMOVE ROW */
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
            e.target.closest('.image-row').remove();
        }
    });

</script>
@endpush