<div class="collapse" id="metaFilterBody">
    <div class="d-flex flex-wrap align-items-end gap-2 py-1">
        
        <div>
            <label class="text-muted small mb-1">Settlement ID</label>
            <input type="text" class="form-control form-control-sm bg-light py-1" id="filterSettlementId" 
                placeholder="ST..." style="width: 100px;">
        </div>

        <div>
            <label class="text-muted small mb-1">Settlement Date</label>
            <input type="date" class="form-control form-control-sm py-1" id="filterSettlementDate" 
                style="width: 140px;">
        </div>

        <div>
            <label class="text-muted small mb-1">Pump Operator</label>
            <select class="form-control form-control-sm py-1" id="filterOperator" style="width: 150px;">
                <option value="">All Operators</option>
            </select>
        </div>

        <div>
            <label class="text-muted small mb-1">Location</label>
            <select class="form-control form-control-sm py-1" id="filterLocation" style="width: 150px;">
                <option value="">All Locations</option>
            </select>
        </div>

        <div>
            <label class="text-muted small mb-1">Shift</label>
            <select class="form-control form-control-sm py-1" id="filterShift" style="width: 120px;">
                <option value="">All Shifts</option>
            </select>
        </div>

        <div>
            <label class="text-muted small mb-1">Status</label>
            <select class="form-control form-control-sm py-1" id="filterStatus" style="width: 120px;">
                <option value="">All Status</option>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
            </select>
        </div>

        <div>
            <label class="text-muted small mb-1">Added User</label>
            <select class="form-control form-control-sm py-1" id="filterAddedUser" style="width: 120px;">
                <option value="">All Users</option>
            </select>
        </div>

        <button type="button" class="btn btn-sm btn-outline-secondary ms-auto" id="resetFilterBtn">
            <i class="mdi mdi-refresh"></i> Reset
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const resetFilterBtn = document.getElementById('resetFilterBtn');
    const filterInputs = document.querySelectorAll('#metaFilterBody input, #metaFilterBody select');

    // Apply filters in real-time on any change
    filterInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
        input.addEventListener('keyup', applyFilters);
    });

    // Apply filters function
    function applyFilters() {
        const filters = {
            settlementId: document.getElementById('filterSettlementId').value,
            settlementDate: document.getElementById('filterSettlementDate').value,
            operator: document.getElementById('filterOperator').value,
            location: document.getElementById('filterLocation').value,
            shift: document.getElementById('filterShift').value,
            status: document.getElementById('filterStatus').value,
            addedUser: document.getElementById('filterAddedUser').value
        };
        
        console.log('Filters Applied:', filters);
        applyDataTableFilters(filters);
    }

    // Reset filter handler
    resetFilterBtn.addEventListener('click', function() {
        filterInputs.forEach(input => {
            input.value = '';
        });
        
        console.log('Filters Reset');
        applyDataTableFilters({});
    });

    // Function to apply filters to DataTable
    function applyDataTableFilters(filters) {
        if (!settlementTable) return;

        // Clear existing filters
        settlementTable.column(0).search('');
        settlementTable.column(1).search('');
        settlementTable.column(2).search('');
        settlementTable.column(3).search('');
        settlementTable.column(4).search('');
        settlementTable.column(5).search('');
        settlementTable.column(7).search('');
        settlementTable.column(8).search('');

        // Apply new filters
        if (filters.settlementId) settlementTable.column(0).search(filters.settlementId, true, false);
        if (filters.settlementDate) settlementTable.column(1).search(filters.settlementDate, true, false);
        if (filters.operator) settlementTable.column(2).search(filters.operator, true, false);
        if (filters.location) settlementTable.column(4).search(filters.location, true, false);
        if (filters.shift) settlementTable.column(5).search(filters.shift, true, false);
        if (filters.status) settlementTable.column(8).search(filters.status, true, false);
        if (filters.addedUser) settlementTable.column(7).search(filters.addedUser, true, false);

        settlementTable.draw();
    }
});
</script>