$(document).ready(function () {

    $('#customerSelect').on('change', function () {
        let opt = $(this).find('option:selected');

        $('input[name="customer_name"]').val(opt.data('name') || '');
        $('input[name="customer_email"]').val(opt.data('email') || '');
        $('input[name="customer_phone"]').val(opt.data('phone') || '');
        $('textarea[name="customer_address"]').val(opt.data('address') || '');
    });

    $(document).on('input', 'input[name="customer_name"]', function () {
        let selected = $('#customerSelect').find('option:selected');
        if (selected.val() && $(this).val() !== selected.data('name')) {
            $('#customerSelect').val('');
        }
    });

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
                               value="0" min="0" step="0.01" required>
                    </div>
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control item-total item-total-input" value="0.00" readonly>
                    </div>
                </td>
                <td class="text-center">
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

    calculateTotals();

});
