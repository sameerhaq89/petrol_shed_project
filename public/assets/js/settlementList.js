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
        }
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
    let url = '/settlement-data';

    try {
        const res = await fetch(url);
        const settlements = await res.json();

        // Store all settlements for filter options
        allSettlementsData = settlements;

        // Populate filter dropdowns on first load
        populateFilterOptions(settlements);

        // Apply filters if provided
        let filteredSettlements = settlements;
        if (Object.keys(filter).length > 0 && Object.values(filter).some(v => v)) {
            filteredSettlements = settlements.filter(settlement => {
                if (filter.settlementId && !settlement.settlement_id.toLowerCase().includes(filter.settlementId.toLowerCase())) return false;
                if (filter.settlementDate && settlement.settlement_date !== filter.settlementDate) return false;
                if (filter.operator && settlement.pump_operator_name !== filter.operator) return false;
                if (filter.location && settlement.location !== filter.location) return false;
                if (filter.shift && settlement.shift !== filter.shift) return false;
                if (filter.status && settlement.status !== filter.status) return false;
                if (filter.addedUser && settlement.added_user !== filter.addedUser) return false;
                return true;
            });

            console.log('Total Records:', settlements.length);
            console.log('Filtered Records:', filteredSettlements.length);
        }

        const tbody = document.querySelector('#entryTable tbody');
        tbody.innerHTML = '';

        filteredSettlements.forEach(settlement => {
            const statusBadgeClass = settlement.status === 'Completed'
                ? 'badge-success'
                : 'badge-warning';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${settlement.settlement_id}</td>
                <td>${settlement.settlement_date}</td>
                <td><strong>${settlement.pump_operator_name}</strong></td>
                <td>${settlement.pumps}</td>
                <td>${settlement.location}</td>
                <td>${settlement.shift}</td>
                <td><strong>${settlement.total_amount}</strong></td>
                <td>${settlement.added_user}</td>
                <td>
                    <span class="badge ${statusBadgeClass}">${settlement.status}</span>
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view-settlement-details"
                            data-id="${settlement.id}"
                            data-status="${settlement.status}"
                            data-date="${settlement.settlement_date}"
                            data-settlement-id="${settlement.settlement_id}"
                            data-shift-id="${settlement.shift_id}"
                            data-operator="${settlement.pump_operator_name}"
                            data-pumps="${settlement.pumps}"
                            data-location="${settlement.location}"
                            data-shift="${settlement.shift}"
                            data-note="${settlement.note}"
                            data-amount="${settlement.total_amount}"
                            data-added-user="${settlement.added_user}"
                            data-bs-toggle="modal"
                            data-bs-target="#viewSettlementDetailsModal"
                            title="View Details">
                            <i class="mdi mdi-eye-arrow-right-outline"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-gradient-danger btn-icon delete-settlement"
                            data-id="${settlement.id}"
                            title="Delete Settlement">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });

        initSettlementTable();
    } catch (error) {
        console.error('Error fetching settlements:', error);
        alert('Error loading settlements. Please try again.');
    }
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