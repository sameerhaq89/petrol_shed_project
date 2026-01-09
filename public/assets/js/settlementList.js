async function fetchSettlements(filter = {}) {
    const res = await fetch('/settlement-data');
    const settlements = await res.json();

    // Initialize DataTable
    const table = $('.data-table').DataTable();
    table.clear();

    let totalAmountSum = 0;

    settlements.forEach(s => {
        const totalAmount = parseFloat(String(s.total_amount).replace(/,/g, '')) || 0;
        totalAmountSum += totalAmount;

        table.row.add([
            s.settlement_id,
            s.settlement_date,
            `<strong>${s.pump_operator_name}</strong>`,
            s.location,
            s.shift,
            `<strong>${totalAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</strong>`,
            `<span class="badge ${s.status === 'Completed'
                ? 'badge-outline-success'
                : s.status === 'Pending'
                    ? 'badge-outline-danger'
                    : 'badge-outline-primary'
            }">
    ${s.status}
</span>`,
            `
    <div class="btn-group">
        <button class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view-settlement-details"
            data-bs-toggle="modal"
            data-bs-target="#viewSettlementDetailsModal"

            data-status="${s.status}"
            data-date="${s.settlement_date}"
            data-settlement-id="${s.settlement_id}"
            data-shift-id="${s.shift_id ?? '-'}"
            data-operator="${s.pump_operator_name}"
            data-pumps="${s.pumps ?? '-'}"
            data-location="${s.location}"
            data-shift="${s.shift}"
            data-note="${s.note ?? '-'}"
            data-amount="${totalAmount.toFixed(2)}"
            data-added-user="${s.added_user ?? '-'}">
            <i class="mdi mdi-eye-arrow-right-outline"></i>
        </button>
        <button class="btn btn-sm btn-outline-danger btn-gradient-danger btn-icon delete-settlement" data-id="${s.id}">
            <i class="mdi mdi-delete"></i>
        </button>
    </div>
    `
        ]);

    });

    table.draw(false);

    // Update summary field for total amount (add IDs in your html accordingly)
    const totalAmountEl = document.getElementById('totalAmount');
    if (totalAmountEl) {
        totalAmountEl.innerText = totalAmountSum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    addDataLabels();
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
    const btn = e.target.closest('.view-settlement-details');
    if (!btn) return;

    const setText = (id, val) => {
        const el = document.getElementById(id);
        if (el) el.innerText = val ?? '-';
    };

    setText('modalSettlementStatus', btn.dataset.status);
    setText('modalSettlementDate', btn.dataset.date);
    setText('modalSettlementId', btn.dataset.settlementId);
    setText('modalShiftId', btn.dataset.shiftId);
    setText('modalOperatorName', btn.dataset.operator);
    setText('modalPumps', btn.dataset.pumps);
    setText('modalLocation', btn.dataset.location);
    setText('modalShift', btn.dataset.shift);
    setText('modalNote', btn.dataset.note);
    setText('modalTotalAmount', Number(btn.dataset.amount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
    setText('modalAddedUser', btn.dataset.addedUser);
});

document.addEventListener('DOMContentLoaded', () => {
    fetchSettlements().then(() => {
        addDataLabels();

        $('.data-table').on('draw.dt', function () {
            addDataLabels();
        });
    });
});
