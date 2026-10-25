$(document).ready(function () {

    const aiDraftUrl = $('#quoteForm').data('ai-draft-url');
    const checkPriceUrl = $('#quoteForm').data('check-price-url');

    $('#customerSelect').on('change', function () {
        let opt = $(this).find('option:selected');

        $('input[name="customer_name"]').val(opt.data('name') || '');
        $('input[name="customer_email"]').val(opt.data('email') || '');
        $('input[name="customer_phone"]').val(opt.data('phone') || '');
        $('textarea[name="customer_address"]').val(opt.data('address') || '');
    });

    // If staff edits the name after picking a customer, treat it as a different person
    $(document).on('input', 'input[name="customer_name"]', function () {
        let selected = $('#customerSelect').find('option:selected');
        if (selected.val() && $(this).val() !== selected.data('name')) {
            $('#customerSelect').val('');
        }
    });

    function runAiGenerate() {
        let desc = $('#jobDescInput').val().trim();
        if (!desc) {
            showAiAlert('warning', 'Describe the job first, then click Generate.');
            return;
        }

        let $btn = $('#aiGenerate').prop('disabled', true);
        $('#aiGenerateIcon').removeClass('fa-magic').addClass('fa-spinner fa-spin');
        $('#aiGenerateLabel').text('Generating...');

        $.post(aiDraftUrl, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            job_description: desc
        }, function (data) {

            if (!data.items || data.items.length === 0) {
                showAiAlert('warning', 'No matching services found for that description. Try different wording or add items manually.');
                return;
            }

            data.items.forEach(function (item) {
                let row = `
                    <tr class="quote-item-row">
                        <td><textarea name="description[]" class="form-control description" rows="3" required>${item.description}</textarea></td>
                        <td><input type="number" name="quantity[]" class="form-control quantity" value="${item.quantity}" min="1" step="1" required></td>
                        <td><div class="input-group"><span class="input-group-text">$</span><input type="number" name="amount[]" class="form-control amount" value="${item.amount}" min="0" step="0.01" required></div></td>
                        <td><div class="input-group"><span class="input-group-text">$</span><input type="text" class="form-control item-total item-total-input" value="0.00" readonly></div></td>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-outline-primary check-price-btn" title="Check AI Price">
                            <i class="fas fa-magnifying-glass-dollar"></i>
                        </button><button type="button" class="remove-item-btn remove-item"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                $('#quoteItems').append(row);
            });
            calculateTotals();
            showAiAlert('success', `${data.items.length} item(s) added from AI suggestion.`);
            $('#jobDescInput').val('');

        }).fail(function () {
            showAiAlert('danger', 'Something went wrong generating the quote. Please try again.');
        }).always(function () {
            $btn.prop('disabled', false);
            $('#aiGenerateIcon').removeClass('fa-spinner fa-spin').addClass('fa-magic');
            $('#aiGenerateLabel').text('Generate');
        });
    }

    $('#aiGenerate').on('click', runAiGenerate);

    $('#jobDescInput').on('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            runAiGenerate();
        }
    });

    function showAiAlert(type, message, sticky = false) {
        // type: 'success', 'danger', or 'warning'
        const icon = type === 'success' ? 'fa-check-circle'
                : type === 'danger' ? 'fa-exclamation-triangle'
                : 'fa-exclamation-circle';

        const alertHtml = `
            <div class="alert-soft alert-${type} mb-3 ai-alert">
                <i class="fas ${icon}"></i>
                ${message}
            </div>`;

        $('#aiAlertContainer').html(alertHtml);

        if (!sticky) {
            setTimeout(function () {
                $('.ai-alert').fadeOut(300, function () { $(this).remove(); });
            }, 4000);
        }
    }

    function calculateTotals() {
        let subtotal = 0;

        $('#quoteItems .quote-item-row').each(function () {
            let quantity = parseFloat($(this).find('.quantity').val()) || 0;
            let amount = parseFloat($(this).find('.amount').val()) || 0;
            let itemTotal = quantity * amount;

            $(this).find('.item-total').val(itemTotal.toFixed(2));
            subtotal += itemTotal;
        });

        let gst = 0;
        let grandTotal = subtotal + gst;

        $('#subtotal').val(subtotal.toFixed(2));
        $('#gst').val(gst.toFixed(2));
        $('#grandTotal').val(grandTotal.toFixed(2));
    }

    $('#addItem').on('click', function () {
        let newRow = `
            <tr class="quote-item-row">
                <td>
                    <textarea name="description[]" class="form-control description" rows="3"
                              placeholder="Enter activity description" required></textarea>
                </td>
                <td>
                    <input type="number" name="quantity[]" class="form-control quantity"
                           value="1" min="1" step="1" required>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="amount[]" class="form-control amount"
                               value="" min="0" step="0.01" placeholder="0.00" required>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control item-total item-total-input" value="0.00" readonly>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-primary check-price-btn" title="Check AI Price">
                        <i class="fas fa-magnifying-glass-dollar"></i>
                    </button>
                    <button type="button" class="remove-item-btn remove-item" title="Remove Item">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#quoteItems').append(newRow);
        calculateTotals();
    });

    $(document).on('click', '.remove-item', function () {
        let rows = $('#quoteItems .quote-item-row').length;

        if (rows > 1) {
            $(this).closest('.quote-item-row').remove();
            calculateTotals();
        } else {
            alert('At least one quote item is required.');
        }
    });

    $(document).on('input', '.quantity, .amount', function () {
        calculateTotals();
    });

    $(document).on('click', '.check-price-btn', function () {
        let row = $(this).closest('.quote-item-row');
        let description = row.find('.description').val();
        let quantity = row.find('.quantity').val();
        let amount = row.find('.amount').val();

        if (!description || !quantity || !amount) {
            showAiAlert('warning', 'Fill in description, quantity, and amount before checking the price.');
            return;
        }

        let $btn = $(this);
        $btn.prop('disabled', true).find('i').removeClass('fa-magnifying-glass-dollar').addClass('fa-spinner fa-spin');

        $.post(checkPriceUrl, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            description: description,
            quantity: quantity,
            amount: amount
        }, function (data) {
            if (data.flagged) {
                showAiAlert('warning',
                    `This price looks unusual for "${description}" — expected around $${data.predicted_amount}, you entered $${data.proposed_amount}.`);
            } else if (data.note) {
                showAiAlert('success', data.note);
            } else {
                showAiAlert('success', 'Price looks in line with past quotes.');
            }
        }).fail(function (xhr) {
            console.error('checkPrice failed:', xhr.status, xhr.responseText);
            showAiAlert('danger', 'Price check failed — please try again.');
        }).always(function () {
            $btn.prop('disabled', false).find('i').removeClass('fa-spinner fa-spin').addClass('fa-magnifying-glass-dollar');
        });
    });

    $('#quoteForm').on('submit', function (e) {
        if ($(this).data('priceConfirmed')) {
            return; // already confirmed, let it through
        }

        e.preventDefault();
        let $form = $(this);
        let checks = [];

        $('#quoteItems .quote-item-row').each(function () {
            let row = $(this);
            let description = row.find('.description').val();
            let quantity = row.find('.quantity').val();
            let amount = row.find('.amount').val();

            if (!description || !quantity || !amount) return;

            checks.push(
                $.post(checkPriceUrl, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    description: description,
                    quantity: quantity,
                    amount: amount
                }).then(function (data) {
                    return { description: description, result: data };
                })
            );
        });

        if (checks.length === 0) {
            $form.data('priceConfirmed', true).trigger('submit');
            return;
        }

        let $submitBtns = $form.find('button[type="submit"]').prop('disabled', true);

        $.when.apply($, checks).always(function () {
            let results = Array.from(arguments);
            let flagged = results.filter(r => r && r.result && r.result.flagged);

            $submitBtns.prop('disabled', false);

            if (flagged.length === 0) {
                $form.data('priceConfirmed', true).trigger('submit');
                return;
            }

            let lines = flagged.map(f =>
                `<li>"${f.description}" — expected ~$${f.result.predicted_amount}, entered $${f.result.proposed_amount} (${f.result.difference_pct}%)</li>`
            ).join('');

            showAiAlert('warning',
                `<strong>${flagged.length} item(s) have unusual pricing:</strong>
                <ul class="mb-2 mt-1 ps-3">${lines}</ul>
                <button type="button" class="btn btn-sm btn-outline-danger me-2" id="saveAnywayBtn">Save Anyway</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="reviewPricesBtn">Review Prices</button>`
            , true);
        });

        $(document).off('click', '#saveAnywayBtn').on('click', '#saveAnywayBtn', function () {
            $form.data('priceConfirmed', true).trigger('submit');
        });

        $(document).off('click', '#reviewPricesBtn').on('click', '#reviewPricesBtn', function () {
            $('.ai-alert').remove();
        });
    });

    calculateTotals();

});
