document.addEventListener('DOMContentLoaded', () => {
    initButtonTabs();
    initCollapseWatcher();
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
document.addEventListener('click', function (e) {
    const viewBtn = e.target.closest('.view-details');
    if (viewBtn) {
        // Populate all modal fields
        document.getElementById('modalTransactionDate').innerText = viewBtn.dataset.transactiondate || 'N/A';
        document.getElementById('modalSettlementNo').innerText = viewBtn.dataset.settlementno || 'N/A';
        document.getElementById('modalLocation').innerText = viewBtn.dataset.location || 'N/A';
        document.getElementById('modalPumpNo').innerText = viewBtn.dataset.pumpno || 'N/A';
        document.getElementById('modalProduct').innerText = viewBtn.dataset.product || 'N/A';
        document.getElementById('modalOperator').innerText = viewBtn.dataset.operator || 'N/A';
        document.getElementById('modalSold').innerText = viewBtn.dataset.sold || '0';
        document.getElementById('modalStartMeter').innerText = viewBtn.dataset.start || '0';
        document.getElementById('modalCloseMeter').innerText = viewBtn.dataset.close || '0';
        document.getElementById('modalTestingQty').innerText = viewBtn.dataset.testingqty || '0';
        document.getElementById('modalSaleAmount').innerText = parseFloat(viewBtn.dataset.saleamount || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    const editBtn = e.target.closest('.edit');
    if (editBtn) {
        const row = editBtn.closest('tr');
        const viewBtnInRow = row.querySelector('.view-details');
        if (!viewBtnInRow) return;

        document.getElementById('editStart').value = viewBtnInRow.dataset.start;
        document.getElementById('editClose').value = viewBtnInRow.dataset.close;
        document.getElementById('editTestingQty').value = viewBtnInRow.dataset.testingqty;
        document.getElementById('editSaleAmount').value = viewBtnInRow.dataset.saleamount;
    }
});

function initCollapseWatcher() {
    const collapseDiv = document.getElementById('meterReadingsFilterDiv');
    const resetBtn = document.getElementById('resetMeterFilterBtn');

    const updateButton = () => {
        if (collapseDiv.classList.contains('show')) {
            resetBtn.classList.remove('d-none');
        } else {
            resetBtn.classList.add('d-none');
        }
    };
    updateButton();
    collapseDiv.addEventListener('hidden.bs.collapse', updateButton);
    collapseDiv.addEventListener('shown.bs.collapse', updateButton);
}
