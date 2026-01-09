async function fetchEntries(filter = {}) {
    const res = await fetch('/settlement/entries');
    const entries = await res.json();

    const table = $('.data-table').DataTable();

    table.clear();

    let totalQtySum = 0;
    let grossAmountSum = 0;
    let totalDiscountSum = 0;

    entries.forEach(entry => {
        const soldQty = parseFloat(entry.sold_qty.replace(/,/g, ''));
        const before = parseFloat(entry.before_discount.replace(/,/g, ''));
        const discountPercent = parseFloat(entry.discount_value);

        const discountAmount = before * (discountPercent / 100);
        const netAmount = before - discountAmount;

        totalQtySum += soldQty;
        totalDiscountSum += discountAmount;
        grossAmountSum += netAmount;

        table.row.add([
            entry.code,
            `<strong>${entry.products}</strong>`,
            `<span class="badge badge-outline-primary badge-compact">${entry.pump}</span>`,
            entry.start_meter,
            entry.close_meter,
            entry.price,
            entry.sold_qty,
            `<strong>${entry.total_price}</strong>`,
            `
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view-details"
                    data-id="${entry.id}"
                    data-code="${entry.code}"
                    data-products="${entry.products}"
                    data-pump="${entry.pump}"
                    data-start="${entry.start_meter}"
                    data-close="${entry.close_meter}"
                    data-sold="${entry.sold_qty}"
                    data-price="${entry.price}"
                    data-total="${entry.total_price}"
                    data-discount="${entry.discount_value}"
                    data-before="${entry.before_discount}"
                    data-after="${netAmount.toFixed(2)}"
                    data-discount-type="${entry.discount_type}"
                    data-bs-toggle="modal"
                    data-bs-target="#viewDetailsModal">
                    <i class="mdi mdi-eye-arrow-right-outline"></i>
                </button>
                <button class="btn btn-sm btn-outline-primary btn-gradient-primary btn-icon edit" data-id="${entry.id}"
                data-bs-toggle="modal" data-bs-target="#editEntryModal">
                    <i class="mdi mdi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger btn-gradient-danger btn-icon delete" data-id="${entry.id}">
                    <i class="mdi mdi-delete"></i>
                </button>
            </div>
            `
        ]);
    });
    table.draw(false);

    document.getElementById('totalQty').innerText =
        totalQtySum.toLocaleString(undefined, { minimumFractionDigits: 2 });

    document.getElementById('grossAmount').innerText =
        grossAmountSum.toLocaleString(undefined, { minimumFractionDigits: 2 });

    document.getElementById('totalDiscount').innerText =
        totalDiscountSum.toLocaleString(undefined, { minimumFractionDigits: 2 });

    document.getElementById('netWorth').innerText =
        (grossAmountSum - totalDiscountSum).toLocaleString(undefined, { minimumFractionDigits: 2 });
}

function addDataLabels() {
    const table = document.querySelector('.data-table');
    if (!table) return;

    const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());

    table.querySelectorAll('tbody tr').forEach(row => {
        row.querySelectorAll('td').forEach((td, index) => {
            if (headers[index]) {
                td.setAttribute('data-label', headers[index]);
            }
        });
    });
}

function initCollapseWatcher() {
    const collapseDiv = document.getElementById('metaFilterBodyEntry');
    const resetBtn = document.getElementById('resetEntryFilterBtn');

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

document.addEventListener('click', function (e) {
    const viewBtn = e.target.closest('.view-details');
    if (viewBtn) {
        document.getElementById('modalCode').innerText = viewBtn.dataset.code;
        document.getElementById('modalProducts').innerText = viewBtn.dataset.products;
        document.getElementById('modalPump').innerText = viewBtn.dataset.pump;

        document.getElementById('modalStart').innerText = viewBtn.dataset.start;
        document.getElementById('modalClose').innerText = viewBtn.dataset.close;
        document.getElementById('modalSold').innerText = viewBtn.dataset.sold;

        document.getElementById('modalPrice').innerText = viewBtn.dataset.price;
        document.getElementById('modalTotal').innerText = viewBtn.dataset.total;

        document.getElementById('modalDiscount').innerText = viewBtn.dataset.discount + '%';
        document.getElementById('modalBefore').innerText = viewBtn.dataset.before;
        document.getElementById('modalAfter').innerText =
            parseFloat(viewBtn.dataset.after).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    const editBtn = e.target.closest('.edit');
    if (editBtn) {
        const num = v => v ? v.replace(/,/g, '') : '';
        const row = editBtn.closest('tr');
        const viewBtnInRow = row.querySelector('.view-details');
        if (!viewBtnInRow) return;
        document.getElementById('editCode').value = viewBtnInRow.dataset.code;
        document.getElementById('editProduct').value = viewBtnInRow.dataset.products;
        document.getElementById('editPump').value = viewBtnInRow.dataset.pump;

        document.getElementById('editStart').value = num(viewBtnInRow.dataset.start);
        document.getElementById('editClose').value = num(viewBtnInRow.dataset.close);
        document.getElementById('editSold').value = num(viewBtnInRow.dataset.sold);

        document.getElementById('editPrice').value = num(viewBtnInRow.dataset.price);
        document.getElementById('editTotal').value = num(viewBtnInRow.dataset.total);

        document.getElementById('editDiscountType').value = viewBtnInRow.dataset.discountType || '';
        document.getElementById('editDiscount').value = num(viewBtnInRow.dataset.discount);
        document.getElementById('editBefore').value = num(viewBtnInRow.dataset.before);
        document.getElementById('editAfter').value = num(viewBtnInRow.dataset.after);
    }
});

function initTomSelect() {
    document.querySelectorAll('.tom-select').forEach(el => {
        new TomSelect(el, {
            sortField: {
                field: "text",
                direction: "asc"
            },
            plugins: {
                'clear_button': {
                    'title': 'Remove all selected options',
                }
            },
            persist: false,
        })
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchEntries().then(() => {
        addDataLabels();
        initCollapseWatcher();
        initTomSelect()

        $('.data-table').on('draw.dt', function () {
            addDataLabels();
        });
    });
});