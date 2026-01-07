let settlementTable;
let allSettlementsData = [];

function initSettlementTable() {
    if (settlementTable) {
        settlementTable.destroy();
    }

    settlementTable = new DataTable('#entryTable', {
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
            { responsivePriority: 1, targets: -1 }, // Action column
            { responsivePriority: 2, targets: 0 },  // Settlement ID
            { responsivePriority: 3, targets: 2 }   // Pump Operator
        ]
    });
}

// Populate filter options from settlement data
function populateFilterOptions(settlements) {
    const operators = new Set();
    const locations = new Set();
    const shifts = new Set();
    const users = new Set();

    settlements.forEach(settlement => {
        if (settlement.pump_operator_name) operators.add(settlement.pump_operator_name);
        if (settlement.location) locations.add(settlement.location);
        if (settlement.shift) shifts.add(settlement.shift);
        if (settlement.added_user) users.add(settlement.added_user);
    });

    // Populate Operator dropdown
    const operatorSelect = document.getElementById('filterOperator');
    if (operatorSelect && operatorSelect.children.length === 1) {
        operators.forEach(operator => {
            const option = document.createElement('option');
            option.value = operator;
            option.textContent = operator;
            operatorSelect.appendChild(option);
        });
    }

    // Populate Location dropdown
    const locationSelect = document.getElementById('filterLocation');
    if (locationSelect && locationSelect.children.length === 1) {
        locations.forEach(location => {
            const option = document.createElement('option');
            option.value = location;
            option.textContent = location;
            locationSelect.appendChild(option);
        });
    }

    // Populate Shift dropdown
    const shiftSelect = document.getElementById('filterShift');
    if (shiftSelect && shiftSelect.children.length === 1) {
        shifts.forEach(shift => {
            const option = document.createElement('option');
            option.value = shift;
            option.textContent = shift;
            shiftSelect.appendChild(option);
        });
    }

    // Populate User dropdown
    const userSelect = document.getElementById('filterAddedUser');
    if (userSelect && userSelect.children.length === 1) {
        users.forEach(user => {
            const option = document.createElement('option');
            option.value = user;
            option.textContent = user;
            userSelect.appendChild(option);
        });
    }

    // Reinitialize Select2 if available
    if (typeof reinitializeSelect2 === 'function') {
        reinitializeSelect2();
    }
}

async function fetchSettlements(filter = {}) {
    const res = await fetch('/settlement-data');
    const settlements = await res.json();

    const table = $('.data-table').DataTable();
    table.clear();

    settlements.forEach(settlement => {
        table.row.add([
            settlement.settlement_id,
            settlement.settlement_date,
            `<strong>${settlement.pump_operator_name}</strong>`,
            settlement.pumps,
            settlement.location,
            settlement.shift,
            `<strong>${settlement.total_amount}</strong>`,
            settlement.added_user,
            `<span class="badge badge-${settlement.status === 'Completed' ? 'success' : 'warning'}">
                ${settlement.status}
            </span>`,
            `
            <div class="btn-group">
                <button class="btn btn-sm btn-outline-success btn-icon view-settlement-details"
                    data-id="${settlement.id}"
                    data-bs-toggle="modal"
                    data-bs-target="#viewSettlementDetailsModal">
                    <i class="mdi mdi-eye-arrow-right-outline"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger btn-icon delete-settlement"
                    data-id="${settlement.id}">
                    <i class="mdi mdi-delete"></i>
                </button>
            </div>
            `
        ]);
    });

    table.draw(false);
}



// View settlement details handler
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.view-settlement-details');
    if (!btn) return;

    const modalStatus = document.getElementById('modalSettlementStatus');
    const modalDate = document.getElementById('modalSettlementDate');
    const modalSettlementId = document.getElementById('modalSettlementId');
    const modalShiftId = document.getElementById('modalShiftId');
    const modalOperatorName = document.getElementById('modalOperatorName');
    const modalPumps = document.getElementById('modalPumps');
    const modalLocation = document.getElementById('modalLocation');
    const modalShift = document.getElementById('modalShift');
    const modalNote = document.getElementById('modalNote');
    const modalTotalAmount = document.getElementById('modalTotalAmount');
    const modalAddedUser = document.getElementById('modalAddedUser');

    if (modalStatus) modalStatus.innerText = btn.dataset.status;
    if (modalDate) modalDate.innerText = btn.dataset.date;
    if (modalSettlementId) modalSettlementId.innerText = btn.dataset.settlementId;
    if (modalShiftId) modalShiftId.innerText = btn.dataset.shiftId;
    if (modalOperatorName) modalOperatorName.innerText = btn.dataset.operator;
    if (modalPumps) modalPumps.innerText = btn.dataset.pumps;
    if (modalLocation) modalLocation.innerText = btn.dataset.location;
    if (modalShift) modalShift.innerText = btn.dataset.shift;
    if (modalNote) modalNote.innerText = btn.dataset.note;
    if (modalTotalAmount) modalTotalAmount.innerText = btn.dataset.amount;
    if (modalAddedUser) modalAddedUser.innerText = btn.dataset.addedUser;
});



// Delete settlement handler
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.delete-settlement');
    if (!btn) return;

    const settlementId = btn.dataset.id;

    if (confirm('Are you sure you want to delete this settlement?')) {
        deleteSettlement(settlementId);
    }
});

async function deleteSettlement(id) {
    try {
        const res = await fetch(`/settlement-list/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        const data = await res.json();

        if (res.ok) {
            alert('Settlement deleted successfully');
            fetchSettlements(); // Refresh the table
        } else {
            alert('Error deleting settlement: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error deleting settlement:', error);
        alert('Error deleting settlement');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    fetchSettlements();
});