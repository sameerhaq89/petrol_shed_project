// assets/js/data-tables.js
let tables = []; // store all DataTable instances

document.addEventListener('DOMContentLoaded', () => {
    initDataTables();
});

function initDataTables() {
    // destroy existing tables if they exist
    tables.forEach(t => t.destroy());
    tables = []; // reset array

    // initialize all tables with class .data-table
    document.querySelectorAll('.data-table').forEach(tableEl => {
        const dt = new DataTable(tableEl, {
            responsive: true,
            pageLength: 10,
            pagingType: 'simple_numbers',
            language: {
                search: '',
                searchPlaceholder: 'Search…',
                paginate: {
                    previous: '‹',
                    next: '›'
                }
            }
        });

        tables.push(dt); // keep track of this instance
    });
}
