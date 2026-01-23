<style>
    .fs-sm1 { font-size: 0.875rem; }
    #viewOperatorDetailsModal .card { transition: all 0.2s ease; }
    #viewOperatorDetailsModal .card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .custom-modal-width { max-width: 750px; }
</style>

<div class="modal fade" id="viewOperatorDetailsModal" tabindex="-1" aria-labelledby="viewOperatorDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="viewOperatorDetailsModalLabel">
                    <i class="mdi mdi-account-hard-hat me-2"></i>Pump Operator Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Basic Information -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-primary mb-3"><i class="mdi mdi-account-circle"></i> Operator Information</h6>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted small">Operator ID:</div>
                                    <div class="col-7 fs-sm1 fw-medium" id="modalOperatorId">-</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted small">Operator Name:</div>
                                    <div class="col-7 fs-sm1 fw-medium" id="modalPumpOperator">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-muted small">Location:</div>
                                    <div class="col-7 fs-sm1 fw-medium" id="modalLocation">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Information -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-success mb-3"><i class="mdi mdi-chart-bar"></i> Sales Performance</h6>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted small">Sold Fuel:</div>
                                    <div class="col-7 fs-sm1" id="modalSoldFuel">- lb</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-muted small">Sale Amount:</div>
                                    <div class="col-7 fs-sm1 fw-medium text-success" id="modalSaleAmount">LKR 0.00</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Commission Information -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-warning mb-3"><i class="mdi mdi-percent"></i> Commission Details</h6>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted small">Type:</div>
                                    <div class="col-7 fs-sm1" id="modalCommissionType">-</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted small">Rate:</div>
                                    <div class="col-7 fs-sm1" id="modalCommissionRate">0%</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-muted small">Amount:</div>
                                    <div class="col-7 fs-sm1 fw-medium text-warning" id="modalCommissionAmount">LKR 0.00</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Balance Information -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-info mb-3"><i class="mdi mdi-scale-balance"></i> Balance Summary</h6>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted small">Excess Amount:</div>
                                    <div class="col-7 fs-sm1" id="modalExcessAmount">LKR 0.00</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5 text-muted small">Short Amount:</div>
                                    <div class="col-7 fs-sm1" id="modalShortAmount">LKR 0.00</div>
                                </div>
                                <div class="row">
                                    <div class="col-5 text-muted small">Current Balance:</div>
                                    <div class="col-7">
                                        <span class="badge" id="modalCurrentBalanceBadge">0.0 LKR</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light d-flex justify-content-end">
                <button type="button" class="btn btn-gradient-secondary btn-sm me-1" data-bs-dismiss="modal">
                    <i class="mdi mdi-close"></i> Close
                </button>
                <button type="button" class="btn btn-gradient-primary btn-sm" id="printOperatorBtn">
                    <i class="mdi mdi-printer"></i> Print Report
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal details population - Update to match your data attributes
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.view-operator-details');
        if (!btn) return;

        // Set basic information
        const setText = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.innerText = val ?? '-';
        };

        // Get balance for badge styling
        const currentBalance = parseFloat(btn.dataset.currentBalance) || 0;
        const balanceBadge = document.getElementById('modalCurrentBalanceBadge');

        // Apply badge class based on balance
        if (currentBalance > 20) {
            balanceBadge.className = 'badge bg-success';
        } else if (currentBalance > 10) {
            balanceBadge.className = 'badge bg-info';
        } else if (currentBalance > 0) {
            balanceBadge.className = 'badge bg-warning';
        } else {
            balanceBadge.className = 'badge bg-danger';
        }

        // Set all modal fields
        setText('modalOperatorId', btn.dataset.operatorId);
        setText('modalPumpOperator', btn.dataset.pumpOperator);
        setText('modalLocation', btn.dataset.location);
        setText('modalSoldFuel', `${btn.dataset.soldFuel} lb`);

        const saleAmount = Number(btn.dataset.saleAmount || 0);
        setText('modalSaleAmount', `LKR ${saleAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);

        setText('modalCommissionType', btn.dataset.commissionType);
        setText('modalCommissionRate', `${btn.dataset.commissionRate}%`);

        const commissionAmount = Number(btn.dataset.commissionAmount || 0);
        setText('modalCommissionAmount', `LKR ${commissionAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);

        const excessAmount = Number(btn.dataset.excessAmount || 0);
        setText('modalExcessAmount', `LKR ${excessAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);

        const shortAmount = Number(btn.dataset.shortAmount || 0);
        setText('modalShortAmount', `LKR ${shortAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);


        document.getElementById('printOperatorBtn').dataset.operatorId = btn.dataset.operatorId;
    });



    // Print button handler
    document.getElementById('printOperatorBtn').addEventListener('click', function() {
        const operatorId = this.dataset.operatorId;
        // Implement print functionality here
        window.print();
    });
});
</script>
