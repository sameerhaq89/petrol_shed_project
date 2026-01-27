<style>
    .fs-sm1 { font-size: 0.875rem; }
    #viewSettlementDetailsModal .card { transition: all 0.2s ease; }
    #viewSettlementDetailsModal .card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .custom-modal-width { max-width: 700px; }
</style>

<div class="modal fade" id="viewSettlementDetailsModal" tabindex="-1" aria-labelledby="viewSettlementDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="viewSettlementDetailsModalLabel"><i class="mdi mdi-information-outline me-2"></i>Settlement Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-primary mb-3"><i class="mdi mdi-file-document"></i> Basic Information</h6>
                                <div class="row mb-2"><div class="col-5 text-muted small">Settlement ID:</div><div class="col-7 fs-sm1" id="modalSettlementId">2312321</div></div>
                                <div class="row mb-2"><div class="col-5 text-muted small">Date:</div><div class="col-7 fs-sm1" id="modalSettlementDate">31/01/2025</div></div>
                                <div class="row"><div class="col-5 text-muted small">Status:</div><div class="col-7"><span class="badge bg-success" id="modalSettlementStatus">Completed</span></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-info mb-3"><i class="mdi mdi-account"></i> Operator Details</h6>
                                <div class="row mb-2"><div class="col-5 text-muted small">Operator:</div><div class="col-7 fs-sm1" id="modalOperatorName">URA_UPG</div></div>
                                <div class="row"><div class="col-5 text-muted small">Shift ID:</div><div class="col-7 fs-sm1" id="modalShiftId">1</div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-warning mb-3"><i class="mdi mdi-gas-station"></i> Pump & Location</h6>
                                <div class="row mb-2"><div class="col-5 text-muted small">Pumps:</div><div class="col-7 fs-sm1" id="modalPumps">5 R.M Litres</div></div>
                                <div class="row mb-2"><div class="col-5 text-muted small">Location:</div><div class="col-7 fs-sm1" id="modalLocation">Station</div></div>
                                <div class="row"><div class="col-5 text-muted small">Shift:</div><div class="col-7"><span class="badge bg-info" id="modalShift">Day Shift</span></div></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-success mb-3"><i class="mdi mdi-currency-usd"></i> Amount Information</h6>
                                <div class="row mb-2"><div class="col-5 text-muted small">Total Amount:</div><div class="col-7 fs-sm1 text-success" id="modalTotalAmount">850,759.67</div></div>
                                <div class="row mb-2"><div class="col-5 text-muted small">Added User:</div><div class="col-7 fs-sm1" id="modalAddedUser">hadjl502</div></div>
                                <div class="row"><div class="col-5 text-muted small">Note:</div><div class="col-7 fs-sm1" id="modalNote">-</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal"><i class="mdi mdi-close"></i> Close</button>
                <button type="button" class="btn btn-gradient-primary btn-sm"><i class="mdi mdi-printer"></i> Print</button>
            </div>
        </div>
    </div>
</div>
