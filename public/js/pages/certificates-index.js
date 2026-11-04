$(document).ready(function () {
    const table = document.getElementById('certificatesTable');
    if (!table) return;

    initServerDataTable('#certificatesTable', {
        ajax: table.dataset.ajaxUrl,
        language: {
            search: '',
            searchPlaceholder: 'Search certificates...'
        },
        columns: [
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
            { data: 'certificate_number', name: 'certificate_number' },
            { data: 'type', name: 'type' },
            { data: 'client_name', name: 'client_name' },
            { data: 'address', name: 'address' },
            { data: 'issued_date', name: 'issued_date' },
            { data: 'expiry_date', name: 'expiry_date' },
            { data: 'status', name: 'status' }
        ]
    });
});
