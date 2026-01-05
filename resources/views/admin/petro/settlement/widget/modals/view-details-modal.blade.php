<style>
    .fs-sm1 {
        font-size: 0.875rem;
    }
</style>
<!-- View Entry Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title d-flex align-items-center" id="viewDetailsModalLabel">
                    <i class="mdi mdi-information-outline me-2"></i>
                    Full Details
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
                                    <div class="col-5"><span class="text-muted small">Code:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalCode">A0023L99</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Product:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalProducts">Lanka Petrol 92</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">Pump:</span></div>
                                    <div class="col-7"><span class="badge bg-primary" id="modalPump">LP1</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-warning mb-3"><i class="mdi mdi-currency-usd"></i> Pricing Details</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Unit Price:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalPrice"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Total Price:</span></div>
                                    <div class="col-7"><span class="fs-sm1 text-warning" id="modalTotal"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-success mb-3"><i class="mdi mdi-gauge"></i> Meter Readings</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Start Meter:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalStart"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Close Meter:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalClose"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">Sold Qty:</span></div>
                                    <div class="col-7"><span class="fs-sm1 text-success" id="modalSold"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-danger mb-3"><i class="mdi mdi-tag-outline"></i> Discount Information
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Discount Type:</span></div>
                                    <div class="col-7"><span class="fs-sm1">Percentage</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Discount Value:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalDiscount"></span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Before Discount</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalBefore"></span></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">After Discount</span></div>
                                    <div class="col-7"><span class="fs-sm1 text-success" id="modalAfter"></span></div>
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