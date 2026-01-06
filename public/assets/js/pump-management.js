document.addEventListener('DOMContentLoaded', () => {
    initButtonTabs();
});

function initButtonTabs() {
    const buttons = document.querySelectorAll('.btn-group [data-target]');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const btnGroup = btn.closest('.btn-group');

            btnGroup.querySelectorAll('button').forEach(b => {
                b.classList.remove('active', 'btn-gradient-primary');
                b.classList.add('btn-outline-primary');
            });

            btn.classList.add('active', 'btn-gradient-primary');
            btn.classList.remove('btn-outline-primary');

            document.querySelectorAll('[id$="Widget"]').forEach(widget => {
                widget.classList.add('d-none');
            });

            const targetWidget = document.querySelector(btn.dataset.target);
            if (targetWidget) {
                targetWidget.classList.remove('d-none');

                const tables = targetWidget.querySelectorAll('.data-table');
                tables.forEach(tbl => {
                    if ($.fn.DataTable.isDataTable(tbl)) {
                        $(tbl).DataTable().columns.adjust().responsive.recalc();
                    }
                });
            }
        });
    });
}
