document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    if (toggle && sidebar) {

        toggle.addEventListener('click', function () {

            sidebar.classList.toggle('show');

        });

    }

});