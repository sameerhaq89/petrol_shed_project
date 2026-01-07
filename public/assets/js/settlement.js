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
                    data-bs-toggle="modal"
                    data-bs-target="#viewDetailsModal">
                    <i class="mdi mdi-eye-arrow-right-outline"></i>
                </button>
                <button class="btn btn-sm btn-outline-primary btn-gradient-primary btn-icon edit" data-id="${entry.id}">
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

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.view-details');
    if (!btn) return;

    document.getElementById('modalCode').innerText = btn.dataset.code;
    document.getElementById('modalProducts').innerText = btn.dataset.products;
    document.getElementById('modalPump').innerText = btn.dataset.pump;

    document.getElementById('modalStart').innerText = btn.dataset.start;
    document.getElementById('modalClose').innerText = btn.dataset.close;
    document.getElementById('modalSold').innerText = btn.dataset.sold;

    document.getElementById('modalPrice').innerText = btn.dataset.price;
    document.getElementById('modalTotal').innerText = btn.dataset.total;

    document.getElementById('modalDiscount').innerText = btn.dataset.discount + '%';
    document.getElementById('modalBefore').innerText = btn.dataset.before;
    document.getElementById('modalAfter').innerText =
        parseFloat(btn.dataset.after).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
});

document.addEventListener('DOMContentLoaded', () => {
    fetchEntries().then(() => {
        addDataLabels();

        $('.data-table').on('draw.dt', function () {
            addDataLabels();
        });
    });
});