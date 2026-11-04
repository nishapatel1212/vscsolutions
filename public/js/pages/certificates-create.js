$(document).ready(function () {
    $(document).on('click', '#addItemRow', function () {
        let table = $('#itemsTable tbody');
        let row = table.find('tr:first').clone();
        let index = table.find('tr').length;

        row.find('input, select').each(function () {
            let name = $(this).attr('name');

            if (name) {
                $(this).attr('name', name.replace(/\[\d+\]/, '[' + index + ']'));
            }

            if ($(this).is('input')) {
                $(this).val('');
            } else if ($(this).is('select')) {
                $(this).prop('selectedIndex', 0);
            }
        });

        table.append(row);
    });

    $(document).on('click', '.removeItemRow', function () {
        if ($('#itemsTable tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            $(this).closest('tr').find('input').val('');
        }
    });
});
