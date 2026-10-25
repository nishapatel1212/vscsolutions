$(document).ready(function () {

    function recalc() {
        let subtotal = 0;

        $('.item-row').each(function () {
            let qty = parseFloat($(this).find('.quantity').val()) || 0;
            let amt = parseFloat($(this).find('.amount').val()) || 0;
            let total = qty * amt;

            $(this).find('.item-total-display').text('$' + total.toFixed(2));
            subtotal += total;
        });

        $('#subtotalDisplay').text('$' + subtotal.toFixed(2));
        $('#grandTotalDisplay').text('$' + subtotal.toFixed(2));
    }

    $('#addItem').on('click', function () {
        let row = `
            <tr class="item-row">
                <td><textarea name="description[]" class="doc-input" rows="2" required></textarea></td>
                <td><input type="number" name="quantity[]" class="doc-input quantity text-center" value="1" min="1" required></td>
                <td><input type="number" name="amount[]" class="doc-input amount text-end" value="0" step="0.01" min="0" required></td>
                <td><div class="item-total-display text-end">$0.00</div></td>
                <td class="text-center"><button type="button" class="remove-item-btn remove-item"><i class="fas fa-trash"></i></button></td>
            </tr>`;
        $('#itemsBody').append(row);
        recalc();
    });

    $(document).on('click', '.remove-item', function () {
        if ($('.item-row').length > 1) {
            $(this).closest('.item-row').remove();
            recalc();
        } else {
            alert('At least one item is required.');
        }
    });

    $(document).on('input', '.quantity, .amount', recalc);

    recalc();
});
