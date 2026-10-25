$(document).ready(function () {
    const table = document.getElementById('reportsTable');
    if (!table) return;

    initServerDataTable('#reportsTable', {
        ajax: table.dataset.ajaxUrl,
        language: {
            search: '',
            searchPlaceholder: 'Search reports...'
        },
        columns: [
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
            { data: 'client_name', name: 'client_name' },
            { data: 'address', name: 'address' },
            { data: 'report_date', name: 'report_date' },
            { data: 'created_at', name: 'created_at' }
        ]
    });
});
