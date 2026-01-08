<style>
    .fs-sm1 {
        font-size: 0.875rem;
    }
</style>
<!-- View Settlement Details Modal -->
<div class="modal fade " id="viewSettlementDetailsModal" tabindex="-1" aria-labelledby="viewSettlementDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="viewSettlementDetailsModalLabel">
                    <i class="mdi mdi-information-outline me-2"></i>
                    Settlement Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-primary mb-3"><i class="mdi mdi-file-document"></i> Basic Information
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Settlement ID:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalSettlementId">ST135</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Date:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalSettlementDate">31/01/2025</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">Status:</span></div>
                                    <div class="col-7"><span class="badge bg-success"
                                            id="modalSettlementStatus">Completed</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-info mb-3"><i class="mdi mdi-account"></i> Operator Details</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Operator:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalOperatorName">URA_UPG</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Shift ID:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalShiftId">1</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-warning mb-3"><i class="mdi mdi-gas-station"></i> Pump & Location</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Pumps:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalPumps">5 R.M Litres</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Location:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalLocation">Station</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">Shift:</span></div>
                                    <div class="col-7"><span class="badge bg-info" id="modalShift">Day Shift</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-success mb-3"><i class="mdi mdi-currency-usd"></i> Amount Information
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Total Amount:</span></div>
                                    <div class="col-7"><span class="fs-sm1 text-success"
                                            id="modalTotalAmount">850,759.67</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Added User:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalAddedUser">hadjl502</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">Note:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalNote">-</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="mdi mdi-close"></i> Close
                </button>
                <button type="button" class="btn btn-gradient-primary btn-sm">
                    <i class="mdi mdi-printer"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Optional: Smooth transitions for modal content */
    #viewSettlementDetailsModal .card {
        transition: all 0.2s ease;
    }

    #viewSettlementDetailsModal .card:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>
