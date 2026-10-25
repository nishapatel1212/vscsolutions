$(document).ready(function () {

    const form = document.querySelector('[data-inspection-items-url]');
    const routes = form ? form.dataset : {};
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

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

    function addChecklistItem(nameInputId, storeUrl, containerSelector, fieldName, idPrefix) {
        const input = document.getElementById(nameInputId);
        const name = input.value.trim();

        if (!name) {
            alert('Enter item name');
            return;
        }

        fetch(storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ name })
        })
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector(containerSelector)
                ?? document.querySelector(`[name="${fieldName}[]"]`)?.closest('.row')
                ?? document.createElement('div');

            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
                <div class="form-check mb-2">
                    <input type="checkbox"
                        name="${fieldName}[]"
                        value="${data.id}"
                        class="form-check-input big-checkbox"
                        id="${idPrefix}${data.id}"
                        checked>
                    <label class="form-check-label" for="${idPrefix}${data.id}">
                        ${data.name}
                    </label>
                </div>`;

            container.appendChild(col);
            input.value = '';
        })
        .catch(err => console.error('Failed to add item:', err));
    }

    window.addNewItem = function () {
        addChecklistItem('newItemName', routes.inspectionItemsUrl, null, 'inspection_items', 'item');
    };

    window.addNewVisualItem = function () {
        addChecklistItem('newVisualItemName', routes.visualInspectionItemsUrl, null, 'visual_inspection_items', 'visualItem');
    };

    window.addNewPolarityItem = function () {
        addChecklistItem('newPolarityItemName', routes.polarityTestingItemsUrl, '#polarityTestingItemsContainer', 'polarity_testing_items', 'polarityItem');
    };

    window.addNewEarthItem = function () {
        addChecklistItem('newEarthItemName', routes.earthTestingItemsUrl, '#earthTestingItemsContainer', 'earth_testing_items', 'earthItem');
    };

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

    let index = parseInt(document.getElementById('image-wrapper')?.dataset.nextIndex || '1', 10);

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

});
