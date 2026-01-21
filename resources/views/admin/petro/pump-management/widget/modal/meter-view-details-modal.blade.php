<style>
    .fs-sm1 {
        font-size: 0.875rem;
    }
</style>
<!-- View Entry Details Modal -->
<div class="modal fade" id="meterViewDetailsModal" tabindex="-1" aria-labelledby="meterViewDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 780px;">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title d-flex align-items-center" id="meterViewDetailsModalLabel">
                    <i class="mdi mdi-information-outline me-2"></i>
                    Meter Readings Full Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Transaction Info Card -->
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body py-3">
                                <h6 class="text-primary mb-3"><i class="mdi mdi-calendar-clock"></i> Transaction Info
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Transaction Date:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalTransactionDate"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Settlement No:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalSettlementNo"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Location:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalLocation"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Operator:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalOperator"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info Card -->
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body py-3">
                                <h6 class="text-info mb-3"><i class="mdi mdi-gas-station"></i> Product Info</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Pump No:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalPumpNo"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Product:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalProduct"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Sold (Ltr):</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalSold"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Testing Qty:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalTestingQty"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meter Readings Card -->
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body py-3">
                                <h6 class="text-warning mb-3"><i class="mdi mdi-gauge"></i> Meter Readings</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Start Meter:</span></div>
                                    <div class="col-7"><span class="fs-sm1 fw-bold" id="modalStartMeter"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Close Meter:</span></div>
                                    <div class="col-7"><span class="fs-sm1 fw-bold" id="modalCloseMeter"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Info Card -->
                    <div class="col-12 col-md-6">
                        <div class="card h-100">
                            <div class="card-body py-3">
                                <h6 class="text-success mb-3"><i class="mdi mdi-cash-multiple"></i> Sales Info</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Sale Amount:</span></div>
                                    <div class="col-7"><span class="fs-sm1 fw-bold text-success"
                                            id="modalSaleAmount"></span></div>
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
    #viewDetailsModal .card {
        transition: all 0.2s ease;
    }

    #viewDetailsModal .card:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
</style>