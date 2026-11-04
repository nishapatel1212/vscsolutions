document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('customerSearch');
    const selectAll = document.getElementById('selectAllCustomers');
    const rows = document.querySelectorAll('.customer-row');

    if (search) {
        search.addEventListener('input', function () {
            const term = this.value.trim().toLowerCase();

            rows.forEach(function (row) {
                row.style.display = row.dataset.search.includes(term) ? '' : 'none';
            });
        });
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.customer-checkbox').forEach(function (checkbox) {
                const row = checkbox.closest('.customer-row');
                if (!row || row.style.display !== 'none') {
                    checkbox.checked = selectAll.checked;
                }
            });
        });
    }
});
