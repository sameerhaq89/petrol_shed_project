let summaryTable = null;
let isInitialized = false;

async function fetchPumpOperators(filter = {}) {
    try {
        const res = await fetch('/pump-operator-data');
        const operators = await res.json();

        // Get the table element in the active pump-operators section
        const pumpSection = document.getElementById('pump-operators');
        if (!pumpSection) {
            console.log('Pump operators section not found');
            return;
        }
        
        const table = pumpSection.querySelector('.data-table');
        if (!table) {
            console.error('DataTable not found in pump operators section');
            return;
        }

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable(table)) {
            // If already initialized, just update the data
            if (summaryTable) {
                summaryTable.clear();
            } else {
                summaryTable = $(table).DataTable();
            }
        } else {
            // Initialize DataTable for the first time
            summaryTable = $(table).DataTable({
                dom: '<"top"<"d-flex justify-content-between align-items-center"lf>>rt<"bottom"ip><"clear">',
                pageLength: 25,
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [7] }, 
                    { 
                        type: 'num', 
                        targets: [2, 3, 4, 5, 6] 
                    },
                    {
                        targets: [3], 
                        render: function(data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                return data; 
                            }
                           
                            const num = parseFloat(data.replace(/[^\d.-]/g, ''));
                            return isNaN(num) ? 0 : num;
                        }
                    }
                ],
                initComplete: function () {
                    // Populate dropdown filters after table initialization
                    populateDropdownFilters();
                },
                drawCallback: function() {
                    addDataLabels();
                }
            });
            isInitialized = true;
        }

        // Clear existing data
        summaryTable.clear();

        let totalSalesSum = 0;
        let totalCommissionSum = 0;

        operators.forEach(op => {
            const saleAmount = parseFloat(String(op.sale_amount_fuel).replace(/,/g, '')) || 0;
            const commissionAmount = parseFloat(String(op.commission_amount).replace(/,/g, '')) || 0;

            totalSalesSum += saleAmount;
            totalCommissionSum += commissionAmount;

            summaryTable.row.add([
                op.pump_operator || '-',       // Column 0
                op.location || '-',            // Column 1  
                op.sold_fuel_qty_lb || '0',    // Column 2
                `<strong>${saleAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</strong>`, // Column 3
                op.short_amount || '0.00',     // Column 5
                `<strong>${op.current_balance || '0.00'}</strong>`, // Column 6
                `
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view-operator-details"
                            data-bs-toggle="modal"
                            data-bs-target="#viewOperatorDetailsModal"
                            data-operator-id="${op.id}"
                            data-pump-operator="${op.pump_operator}"
                            data-location="${op.location}"
                            data-sold-fuel="${op.sold_fuel_qty_lb}"
                            data-sale-amount="${saleAmount.toFixed(2)}"
                            data-commission-type="${op.commission_type}"
                            data-commission-rate="${op.commission_rate}"
                            data-commission-amount="${commissionAmount.toFixed(2)}"
                            data-excess-amount="${op.excess_amount}"
                            data-short-amount="${op.short_amount}"
                            data-current-balance="${op.current_balance}">
                            <i class="mdi mdi-eye-arrow-right-outline"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger btn-gradient-danger btn-icon delete-operator" data-id="${op.id}">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </div>
                ` // Column 7
            ]);
        });

        summaryTable.draw();

        // Update summary fields
        updateSummaryTotals(totalSalesSum, totalCommissionSum);

        // Re-populate dropdown filters with new data
        populateDropdownFilters();

    } catch (error) {
        console.error('Error fetching pump operators:', error);
    }
}

// Helper function to format balance display
function formatBalance(balance) {
    const bal = parseFloat(balance);
    if (bal > 0) return `${bal.toFixed(1)} LKR`;
    return '0.0 LKR';
}

function addDataLabels() {
    const table = document.querySelector('#pump-operators.active .data-table');
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

function populateDropdownFilters() {
    if (!summaryTable) return;

    const operators = new Set();
    const locations = new Set();

    // Get unique values from the DataTable data
    summaryTable.rows().every(function () {
        const rowData = this.data();
        if (rowData[0]) operators.add(rowData[0]); // Column 0: Pump Operator
        if (rowData[1]) locations.add(rowData[1]); // Column 1: Location
    });

    // Clear existing options except first
    const operatorSelect = document.getElementById('filterOperator');
    const locationSelect = document.getElementById('filterLocation');

    if (operatorSelect) {
        // Remove all options except first
        while (operatorSelect.options.length > 1) {
            operatorSelect.remove(1);
        }

        // Add new options
        Array.from(operators).sort().forEach(operator => {
            const option = document.createElement('option');
            option.value = operator;
            option.textContent = operator;
            operatorSelect.appendChild(option);
        });
    }

    if (locationSelect) {
        // Remove all options except first
        while (locationSelect.options.length > 1) {
            locationSelect.remove(1);
        }

        // Add new options
        Array.from(locations).sort().forEach(location => {
            const option = document.createElement('option');
            option.value = location;
            option.textContent = location;
            locationSelect.appendChild(option);
        });
    }
}

function applyDataTableFilters(filters) {
    if (!summaryTable) return;

    // Clear all previous searches
    summaryTable.columns().search('');

    // Apply text-based filters
    if (filters.operator) summaryTable.column(0).search(filters.operator, true, false); // Pump Operator column
    if (filters.location) summaryTable.column(1).search(filters.location, true, false); // Location column

    // Apply custom range filtering
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        // Get row
        const row = summaryTable.row(dataIndex);
        const rowNode = row.node();
        
        if (!rowNode) return true;
        
        // Get values from row data
        const fuelQty = parseFloat(data[2]) || 0; // Column 2: Sold Fuel Qty
        const saleAmountText = data[3] || '';
        const saleAmount = parseFloat(saleAmountText.replace(/[^\d.-]/g, '')) || 0; // Column 3: Sale Amount
        
        // Get commission type from the button's data attribute
        let commissionType = '';
        const viewBtn = rowNode.querySelector('.view-operator-details');
        if (viewBtn) {
            commissionType = viewBtn.dataset.commissionType || '';
        }

        // Parse filter values
        const fuelMin = parseFloat(filters.fuelMin) || 0;
        const fuelMax = parseFloat(filters.fuelMax) || Number.MAX_SAFE_INTEGER;
        const saleMin = parseFloat(filters.saleMin) || 0;
        const saleMax = parseFloat(filters.saleMax) || Number.MAX_SAFE_INTEGER;

        // Check all conditions
        const fuelPass = fuelQty >= fuelMin && fuelQty <= fuelMax;
        const salePass = saleAmount >= saleMin && saleAmount <= saleMax;
        const commissionPass = !filters.commissionType || commissionType === filters.commissionType;

        return fuelPass && salePass && commissionPass;
    });

    summaryTable.draw();

    // Remove the custom filter after drawing
    $.fn.dataTable.ext.search.pop();
}

function updateSummaryTotals(totalSales, totalCommission) {
    const totalSalesEl = document.getElementById('totalSalesAmount');
    if (totalSalesEl) {
        totalSalesEl.innerText = totalSales.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + ' LKR';
    }

    const totalCommissionEl = document.getElementById('totalCommissionAmount');
    if (totalCommissionEl) {
        totalCommissionEl.innerText = totalCommission.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + ' LKR';
    }
}

// Modal details population
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.view-operator-details');
    if (!btn) return;

    const setText = (id, val) => {
        const el = document.getElementById(id);
        if (el) el.innerText = val ?? '-';
    };

    setText('modalOperatorId', btn.dataset.operatorId);
    setText('modalPumpOperator', btn.dataset.pumpOperator);
    setText('modalLocation', btn.dataset.location);
    setText('modalSoldFuel', `${btn.dataset.soldFuel} lb`);
    setText('modalSaleAmount', `LKR ${Number(btn.dataset.saleAmount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
    setText('modalCommissionType', btn.dataset.commissionType);
    setText('modalCommissionRate', `${btn.dataset.commissionRate}%`);
    setText('modalCommissionAmount', `LKR ${Number(btn.dataset.commissionAmount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
    setText('modalExcessAmount', `LKR ${btn.dataset.excessAmount}`);
    setText('modalShortAmount', `LKR ${btn.dataset.shortAmount}`);
    setText('modalCurrentBalance', formatBalance(btn.dataset.currentBalance));
});

// Delete operator handler
document.addEventListener('click', function (e) {
    const deleteBtn = e.target.closest('.delete-operator');
    if (!deleteBtn) return;

    const operatorId = deleteBtn.dataset.id;
    if (confirm('Are you sure you want to delete this pump operator record?')) {
        fetch(`/delete-operator/${operatorId}`, {
            method: 'DELETE',
        })
            .then(response => {
                if (response.ok) {
                    fetchPumpOperators(); // Refresh the table
                }
            })
            .catch(error => console.error('Error deleting operator:', error));
    }
});

// Initialize filter functionality
function initializeFilters() {
    const resetFilterBtn = document.getElementById('resetFilterBtn');
    const filterInputs = document.querySelectorAll('#metaFilterBody input, #metaFilterBody select');

    if (!resetFilterBtn || !filterInputs.length) return;

    // Apply filters in real-time
    filterInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
        input.addEventListener('keyup', function (e) {
            if (e.target.type !== 'select-one') {
                applyFilters();
            }
        });
    });

    // Reset filter handler
    resetFilterBtn.addEventListener('click', function () {
        filterInputs.forEach(input => {
            input.value = '';
        });

        if (summaryTable) {
            summaryTable.search('').columns().search('').draw();
        }
    });
}

function applyFilters() {
    const filters = {
        operator: document.getElementById('filterOperator')?.value || '',
        location: document.getElementById('filterLocation')?.value || '',
        commissionType: document.getElementById('filterCommissionType')?.value || '',
        fuelMin: document.getElementById('filterFuelMin')?.value || '',
        fuelMax: document.getElementById('filterFuelMax')?.value || '',
        saleMin: document.getElementById('filterSaleMin')?.value || '',
        saleMax: document.getElementById('filterSaleMax')?.value || ''
    };

    applyDataTableFilters(filters);
}

// =============== TAB SYSTEM ===============
// Function to handle tab switching
function loadTabContent(tabId) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Show the selected tab's content
    const targetSection = document.getElementById(tabId);
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    // If switching to Pump Operators tab, load the table data
    if (tabId === 'pump-operators') {
        // Wait a bit for the section to become visible
        setTimeout(() => {
            fetchPumpOperators();
        }, 100);
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Initialize tab switching
    const cards = document.querySelectorAll('.pumper-card');
    const sections = document.querySelectorAll('.content-section');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            cards.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked card
            this.classList.add('active');
            
            // Get which tab was clicked
            const targetId = this.getAttribute('data-target');
            
            // Load content for this tab
            loadTabContent(targetId);
        });
    });
    
    // Initialize filters
    initializeFilters();
    
    // Load initial content (Pump Operators tab is active by default)
    loadTabContent('pump-operators');
});