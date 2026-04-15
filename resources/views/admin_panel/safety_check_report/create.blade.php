@extends('adminlte::page')

@section('title', 'Create Safety Report')

@section('content_header')
<h1>Create Safety Check Report</h1>
@endsection

@section('css')
<style>
    .big-checkbox {
        transform: scale(1.8);
        margin-right: 10px;
    }

    .form-check-label {
        margin-left : 10px;
    }
</style>
@endsection

@php 
    $faults = !empty($data->faults) ? $data->faults->toArray() : old('faults', []);
@endphp














@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ !empty($data) ? route('safetycheckreport.update') : route('safetycheckreport.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id" class="form-control" value="{{ $data->id ?? '' }}">

    {{-- General Information --}}
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
                    <input type="date" name="previous_safety_date" class="form-control @error('previous_safety_date') is-invalid @enderror" value="{{ $data->previous_safety_date ?? old('previous_safety_date') }}">
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

    {{-- Fault List --}}
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
                    @if (!empty($faults) && count($faults) > 0)
                        @foreach($faults as $index => $d)
                            <tr>
                                <input type="hidden" name="faults[{{ $index }}][id]" value="{{ $d['id'] ?? '' }}" class="form-control">
                                <td>
                                    <input type="text" name="faults[{{ $index }}][fault_name]" value="{{ $d['fault'] }}" class="form-control @error('faults.'.$index.'.fault_name') is-invalid @enderror">
                                    
                                    @error('faults.'.$index.'.fault_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" name="faults[{{ $index }}][required_rectification]" class="form-control" value="{{ $d['required_rectification'] }}">
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
                                    <button type="button" class="btn btn-success addRow">+</button>
                                    <button type="button" class="btn btn-danger removeRow">−</button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <!-- Empty row for create page -->
                        <tr>
                            <td>
                                <input type="text" name="faults[0][fault_name]" class="form-control @error('faults.fault_name.0') is-invalid @enderror">
                                @error('faults.fault_name.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>
                            <td>
                                <input type="text" name="faults[0][required_rectification]" class="form-control">
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
                                <button type="button" class="btn btn-success addRow">+</button>
                                <button type="button" class="btn btn-danger removeRow">−</button>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Inspection items --}}
    <div class="card card-warning shadow-4">
        <div class="card-header text-white">
            <h5 class="mb-0">Extent Of The Installation And Limitations Of The Inspection And Testing</h5>
        </div>

        <div class="card-body">

            <div class="row">
                @foreach($inspection_items as $item)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="inspection_items[]"
                                value="{{ $item->id }}"
                                class="form-check-input big-checkbox"
                                id="item{{ $item->id }}"
                                {{ isset($data) && $data->inspectionItems->contains($item->id) ? 'checked' : '' }}>

                            <label class="form-check-label" for="item{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            <!-- ADD NEW ITEM -->
            <div class="mt-3">
                <label>Add New Item</label>
                <div class="d-flex">
                    <input type="text" id="newItemName" class="form-control me-2" placeholder="Enter new item">
                    <button type="button" class="btn btn-primary" onclick="addNewItem()">Add</button>
                </div>
            </div>

        </div>
    </div>

    {{-- Visual Inspection Items --}}
    <div class="card card-warning shadow-4">
        <div class="card-header text-white">
            <h5 class="mb-0">C. Safety Check - Verified By Visual Inspection</h5>
        </div>
    
        <div class="card-body">
            <div class="row">
                @foreach($visual_inspection_items as $item)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="visual_inspection_items[]"
                                value="{{ $item->id }}"
                                class="form-check-input big-checkbox"
                                id="visualItem{{ $item->id }}"
                                {{ isset($data) && $data->visualInspectionItems->contains($item->id) ? 'checked' : '' }}>
    
                            <label class="form-check-label" for="visualItem{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
    
            <hr>
    
            <!-- ADD NEW ITEM -->
            <div class="mt-3">
                <label>Add New Item</label>
                <div class="d-flex">
                    <input type="text" id="newVisualItemName" class="form-control me-2" placeholder="Enter new item">
                    <button type="button" class="btn btn-primary" onclick="addNewVisualItem()">Add</button>
                </div>
            </div>
    
        </div>
    </div>

    {{-- Polarity And Correct Connections Testing --}}
    <div class="card card-warning shadow-4">
        <div class="card-header text-white">
            <h5 class="mb-0">Polarity And Correct Connections Testing</h5>
        </div>
        <div class="card-body">
            <div class="row" id="polarityTestingItemsContainer">
                @foreach($polarity_testing_items as $item)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="polarity_testing_items[]"
                                value="{{ $item->id }}"
                                class="form-check-input big-checkbox"
                                id="polarityItem{{ $item->id }}"
                                {{ isset($data) && $data->polarityTestingItems->contains($item->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="polarityItem{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>
            <div class="mt-3">
                <label>Add New Item</label>
                <div class="d-flex">
                    <input type="text" id="newPolarityItemName" class="form-control me-2" placeholder="Enter new item">
                    <button type="button" class="btn btn-primary" onclick="addNewPolarityItem()">Add</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Earth Continuity Testing --}}
    <div class="card card-warning shadow-4">
        <div class="card-header text-white">
            <h5 class="mb-0">Earth Continuity Testing</h5>
        </div>
        <div class="card-body">
            <div class="row" id="earthTestingItemsContainer">
                @foreach($earth_testing_items as $item)
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox"
                                name="earth_testing_items[]"
                                value="{{ $item->id }}"
                                class="form-check-input big-checkbox"
                                id="earthItem{{ $item->id }}"
                                {{ isset($data) && $data->earthTestingItems->contains($item->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="earthItem{{ $item->id }}">
                                {{ $item->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr>
            <div class="mt-3">
                <label>Add New Item</label>
                <div class="d-flex">
                    <input type="text" id="newEarthItemName" class="form-control me-2" placeholder="Enter new item">
                    <button type="button" class="btn btn-primary" onclick="addNewEarthItem()">Add</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Images --}}
    <div class="card card-warning shadow-4">
        <div class="card-header text-white">
            <h5 class="mb-0">Report Images</h5>
        </div>

        <div class="card-body">
            <div id="image-wrapper">

                @if(isset($data) && $data->images->count())
                    {{-- Existing Images --}}
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
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail preview-img" style="height:300px;">
                        </div>

                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-danger remove-row mt-4">✕</button>
                        </div>

                    </div>
                    @endforeach

                @else
                    {{-- Default empty row for create --}}
                    <div class="row g-3 align-items-center image-row mb-3 p-4 border rounded">

                        <div class="col-md-4">
                            <label class="form-label">Image Title</label>
                            <input type="text" name="images[0][title]" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Choose Image</label>
                            <input type="file"
                                name="images[0][file]"
                                class="form-control image-input"
                                accept="image/*">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Preview</label>
                            <img src="" class="img-thumbnail preview-img" style="height:300px; display:none;">
                        </div>

                        <div class="col-md-1 text-end">
                            <button type="button" class="btn btn-danger remove-row mt-4">✕</button>
                        </div>

                    </div>
                @endif

            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between mt-3">
                <button type="button" id="add-more" class="btn btn-secondary">
                    + Add More Images
                </button>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center gap-2">
        <button type="submit" class="btn btn-primary mr-2 mb-5">Save</button>
        <a href="{{ route('safetycheckreport.index') }}" class="btn btn-secondary mb-5">Back</a>
    </div>

</form>
@endsection


















@section('js') <!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    // add new fault row
    $(document).on('click', '.addRow', function() {
        let table = $('#faultTable tbody');
        let firstRowInput = table.find('tr:first input[name*="[fault_name]"]');

        // Check if first input is empty
        if (firstRowInput.val().trim() === '') {
            alert('Please fill the first Fault before adding a new row.');
            firstRowInput.focus();
            return; // Stop adding new row
        }
        
        let row = table.find('tr:first').clone();

        // get new index
        let index = table.find('tr').length;

        // update names + clear values
        row.find('input, select').each(function () {
            let name = $(this).attr('name');

            if (name) {
                // replace index inside faults[0] → faults[index]
                let newName = name.replace(/\d+/, index);
                $(this).attr('name', newName);
            }

            // clear values
            if ($(this).is('input')) {
                $(this).val('');
            } else if ($(this).is('select')) {
                $(this).prop('selectedIndex', 0);
            }
        });

        table.append(row);
    });

    // Remove fault row
    $(document).on('click', '.removeRow', function() {
        if ($('#faultTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
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
                <img src="" class="img-thumbnail preview-img" style="height:300px; display:none;">
            </div>

            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-danger remove-row">✕</button>
            </div>

        </div>`;

        $('#image-wrapper').append(html);
        index++;
    });


    /* Image - REMOVE ROW */
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('.image-row').remove();
        }
    });

</script>

@endsection