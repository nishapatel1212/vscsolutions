document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.toggle-edit-row');
        if (!btn) return;

        const id = btn.dataset.rowId;
        const viewRow = document.querySelector(`.view-row[data-row-id="${id}"]`);
        const editRow = document.querySelector(`.edit-row[data-row-id="${id}"]`);

        if (!viewRow || !editRow) return;

        const editing = editRow.style.display !== 'none';
        editRow.style.display = editing ? 'none' : '';
        viewRow.style.display = editing ? '' : 'none';
    });
});
