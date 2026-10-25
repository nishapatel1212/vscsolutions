document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    if (toggle && sidebar) {

        toggle.addEventListener('click', function () {

            sidebar.classList.toggle('show');

        });

    }

});

/**
 * Delegated delete-confirm handler.
 * Add data-confirm="Delete this record?" to any <form> instead of an inline onsubmit attribute.
 */
document.addEventListener('submit', function (e) {
    const form = e.target.closest('form[data-confirm]');

    if (form && !confirm(form.dataset.confirm)) {
        e.preventDefault();
    }
});

/**
 * Shared client-side DataTable initializer for the simple index-table pattern
 * used across customers/jobs/leads/quote (data already rendered server-side in the table).
 *
 * @param {string} selector - e.g. '#customersTable'
 * @param {object} options  - overrides merged over the defaults (order, pageLength, responsive, language, ...)
 */
function initDataTable(selector, options) {
    if (typeof $ === 'undefined' || !$.fn.DataTable) {
        return null;
    }

    const defaults = {
        order: [[0, 'asc']],
        pageLength: 25,
        responsive: true,
        language: {
            search: '',
            searchPlaceholder: 'Search...',
            emptyTable: 'No records yet.'
        }
    };

    return $(selector).DataTable($.extend(true, {}, defaults, options || {}));
}

/**
 * Shared server-side DataTable initializer (processing + serverSide + ajax).
 *
 * @param {string} selector - e.g. '#reportsTable'
 * @param {object} options  - must include at least `ajax` and `columns`
 */
function initServerDataTable(selector, options) {
    if (typeof $ === 'undefined' || !$.fn.DataTable) {
        return null;
    }

    const defaults = {
        processing: true,
        serverSide: true,
        responsive: true,
        pageLength: 10,
        language: {
            search: '',
            searchPlaceholder: 'Search...'
        }
    };

    return $(selector).DataTable($.extend(true, {}, defaults, options || {}));
}