<style>
    .fs-sm1 {
        font-size: 0.875rem;
    }
</style>
<!-- View Entry Details Modal -->
<div class="modal fade" id="testViewDetailsModal" tabindex="-1" aria-labelledby="testViewDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title d-flex align-items-center" id="testViewDetailsModal">
                    <i class="mdi mdi-information-outline me-2"></i>
                    Full Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-3">
                                <h6 class="text-primary mb-3"><i class="mdi mdi-file-document"></i> Basic Information
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Transaction Date:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalCode">A0023L99</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Location:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalProducts">Lanka Petrol 92</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Settlement:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalCode">A0023L99</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Pump No:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalCode">A0023L99</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Product:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalCode">A0023L99</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Operator:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalCode">A0023L99</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Leter:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalCode">A0023L99</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Sale Value:</span></div>
                                    <div class="col-7"><span class="fs-sm1" id="modalCode">A0023L99</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-gradient-secondary btn-sm" data-bs-dismiss="modal">
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
