let table;

function initTable() {
    if (table) {
        table.destroy();
    }

    table = new DataTable('#entryTable', {
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
        },
        columnDefs: [
            { responsivePriority: 1, targets: -1 }, 
            { responsivePriority: 2, targets: 0 },  
            { responsivePriority: 3, targets: 2 }
        ]
    });
}

async function fetchEntries(filter = {}) {
    let url = '/settlement/entries';
    // if (filter.status) url += ?status=${filter.status};

    const res = await fetch(url);
    const entries = await res.json();

    const tbody = document.querySelector('#entryTable tbody');
    tbody.innerHTML = '';

    const totalQty = document.getElementById('totalQty');
    const grossAmount = document.getElementById('grossAmount');
    const totalDiscount = document.getElementById('totalDiscount');
    const netWorth = document.getElementById('netWorth');

    totalQty.innerHTML = '';
    grossAmount.innerHTML = '';
    totalDiscount.innerHTML = '';
    netWorth.innerHTML = '';

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

        const row = document.createElement('tr');
        row.innerHTML = `
            <td data-label="Code">${entry.code}</td>
            <td data-label="Products"><strong>${entry.products}</strong></td>
            <td data-label="Pump"><span class="badge badge-outline-primary badge-compact">${entry.pump}</span></td>
            <td data-label="Start Meter">${entry.start_meter}</td>
            <td data-label="Close Meter">${entry.close_meter}</td>
            <td data-label="Price">${entry.price}</td>
            <td data-label="Sold Qty">${entry.sold_qty}</td>
            <td data-label="Total Price" class="font-weight-bold">${entry.total_price}</td>
            <td data-label="Action" class=" text-center">
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
                    <button class="btn btn-sm btn-outline-primary btn-gradient-primary btn-icon edit" data-id="${entry.id}"><i class="mdi mdi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger btn-gradient-danger btn-icon delete" data-id="${entry.id}"><i class="mdi mdi-delete"></i></button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });

    const netWorthSum = grossAmountSum - totalDiscountSum;

    totalQty.innerHTML = totalQtySum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    grossAmount.innerHTML = grossAmountSum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    totalDiscount.innerHTML = totalDiscountSum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    netWorth.innerHTML = netWorthSum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    initTable();
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
    fetchEntries();
});