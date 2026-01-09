<style>
    .fs-sm1 {
        font-size: 0.875rem;
    }
</style>
<!-- View Entry Details Modal -->
<div class="modal fade" id="editEntryModal" tabindex="-1" aria-labelledby="editEntryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 780px;">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="editEntryModalLabel">
                    <i class="mdi mdi-pencil-outline me-2"></i>
                    Edit Entry
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Basic Information -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-2">
                                <h6 class="text-primary mb-3"><i class="mdi mdi-file-document"></i> Basic Information
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Code:</span></div>
                                    <div class="col-7"><input type="text" class="form-control form-control-sm"
                                            id="editCode"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Product:</span></div>
                                    <div class="col-7"><input type="text" class="form-control form-control-sm"
                                            id="editProduct"></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">Pump:</span></div>
                                    <div class="col-7"><input type="text" class="form-control form-control-sm"
                                            id="editPump"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Details -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-2">
                                <h6 class="text-warning mb-3"><i class="mdi mdi-currency-usd"></i> Pricing Details</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Unit Price:</span></div>
                                    <div class="col-7"><input type="number" step="0.01"
                                            class="form-control form-control-sm" id="editPrice"></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">Total Price:</span></div>
                                    <div class="col-7"><input type="number" step="0.01"
                                            class="form-control form-control-sm" id="editTotal"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meter Readings -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-2">
                                <h6 class="text-success mb-3"><i class="mdi mdi-gauge"></i> Meter Readings</h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Start Meter:</span></div>
                                    <div class="col-7"><input type="number" step="0.01"
                                            class="form-control form-control-sm" id="editStart"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Close Meter:</span></div>
                                    <div class="col-7"><input type="number" step="0.01"
                                            class="form-control form-control-sm" id="editClose"></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">Sold Qty:</span></div>
                                    <div class="col-7"><input type="number" step="0.01"
                                            class="form-control form-control-sm" id="editSold"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Information -->
                    <div class="col-12 col-md-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body py-2">
                                <h6 class="text-danger mb-3"><i class="mdi mdi-tag-outline"></i> Discount Information
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Discount Type:</span></div>
                                    <div class="col-7">
                                        <select class="form-select form-select-sm" id="editDiscountType">
                                            <option value="">Select Type</option>
                                            <option value="percentage">Percentage</option>
                                            <option value="amount">Amount</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Discount Value:</span></div>
                                    <div class="col-7"><input type="number" step="0.01"
                                            class="form-control form-control-sm" id="editDiscount"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><span class="text-muted small">Before Discount:</span></div>
                                    <div class="col-7"><input type="number" step="0.01"
                                            class="form-control form-control-sm" id="editBefore"></div>
                                </div>
                                <div class="row">
                                    <div class="col-5"><span class="text-muted small">After Discount:</span></div>
                                    <div class="col-7"><input type="number" step="0.01"
                                            class="form-control form-control-sm" id="editAfter"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light" style="max-height: 60px">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="mdi mdi-close"></i> Close
                </button>
                <button type="button" class="btn btn-gradient-primary btn-sm">
                    <i class="mdi mdi-content-save"></i> Save Changes
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