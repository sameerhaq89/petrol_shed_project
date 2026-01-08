let tables = [];

document.addEventListener('DOMContentLoaded', () => {
    initDataTables();
    attachExportHandlers();
});

function initDataTables() {
    tables.forEach(t => t.destroy());
    tables = [];

    document.querySelectorAll('.data-table').forEach(tableEl => {
        const tableName = tableEl.closest('.card, .container, [class*="wrapper"]')?.querySelector('.table-name')?.textContent ||
            tableEl.parentElement?.querySelector('.table-name')?.textContent ||
            document.querySelector('.table-name')?.textContent || '';
        const dt = new DataTable(tableEl, {
            responsive: true,
            pageLength: 10,
            // dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copy',
                    text: 'Copy',
                    title: tableName,
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    title: tableName,
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    title: tableName,
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    title: tableName,
                    exportOptions: { columns: ':visible' }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    title: tableName,
                    exportOptions: { columns: ':visible' }
                }
            ],
            pagingType: 'simple_numbers',
            language: {
                search: '',
                searchPlaceholder: 'Search...',
                paginate: { previous: '‹', next: '›' }
            }
        });

        setTimeout(() => {
            const buttonsContainer = dt.buttons().container();
            if (buttonsContainer) {
                buttonsContainer.style.display = 'none';
            }
        }, 100);

        tables.push(dt);
    });
}

function attachExportHandlers() {
    document.addEventListener('click', function (e) {
        const exportLink = e.target.closest('[data-export]');
        if (!exportLink) return;

        e.preventDefault();

        let tableEl = null;
        let currentElement = exportLink;

        while (currentElement && !tableEl) {
            currentElement = currentElement.parentElement;
            if (currentElement) {
                const wrapper = currentElement.closest('.dataTables_wrapper');
                if (wrapper) {
                    tableEl = wrapper.querySelector('.data-table');
                }
            }
        }

        if (!tableEl) {
            const tableContainer = exportLink.closest('.table-responsive, .card-body, .container, .row');
            if (tableContainer) {
                tableEl = tableContainer.querySelector('.data-table');
            }
        }

        if (!tableEl) {
            console.error('Could not find DataTable');
            return;
        }

        const dt = DataTable.api ? DataTable.api(tableEl) : $(tableEl).DataTable();

        if (!dt) {
            console.error('DataTable instance not found');
            return;
        }

        const exportType = exportLink.getAttribute('data-export');

        try {
            switch (exportType) {
                case 'copy':
                    dt.button('.buttons-copy').trigger();
                    break;
                case 'csv':
                    dt.button('.buttons-csv').trigger();
                    break;
                case 'excel':
                    dt.button('.buttons-excel').trigger();
                    break;
                case 'pdf':
                    dt.button('.buttons-pdf').trigger();
                    break;
                case 'print':
                    dt.button('.buttons-print').trigger();
                    break;
                default:
                    console.error('Unknown export type:', exportType);
            }
        } catch (error) {
            console.error('Error triggering export:', error);

            try {
                if (dt.buttons) {
                    const buttons = dt.buttons();
                    switch (exportType) {
                        case 'copy':
                            if (buttons[0]) buttons[0].trigger();
                            break;
                        case 'csv':
                            if (buttons[1]) buttons[1].trigger();
                            break;
                        case 'excel':
                            if (buttons[2]) buttons[2].trigger();
                            break;
                        case 'pdf':
                            if (buttons[3]) buttons[3].trigger();
                            break;
                        case 'print':
                            if (buttons[4]) buttons[4].trigger();
                            break;
                    }
                }
            } catch (fallbackError) {
                console.error('Fallback also failed:', fallbackError);
            }
        }
    });
}
