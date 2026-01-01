<div class="modal fade" id="recordDipModal" tabindex="-1" aria-labelledby="recordDipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="recordDipModalLabel">
                    <i class="mdi mdi-gas-station me-2"></i>
                    Add New Pump
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="dipRecordForm">
                    {{-- Tank Selection --}}
                    <div class="card mb-3">
                        <div class="card-body py-3">
                            <h6 class="text-primary mb-3">
                                <i class="mdi mdi-information-outline"></i> Tank Information
                            </h6>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label class="text-muted small mb-1">Select Tank <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <select class="form-control form-control-sm pe-5" id="tankSelect" required>
                                            <option value="" selected disabled>Please Select Tank</option>
                                            <option value="1">Tank 1 - Petrol 92</option>
                                            <option value="2">Tank 2 - Petrol 95</option>
                                            <option value="3">Tank 3 - Diesel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small mb-1">Current Fuel Type</label>
                                    <input type="text" class="form-control form-control-sm bg-light" id="fuelType"
                                        readonly placeholder="Auto-filled">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="mdi mdi-close"></i> Cancel
                </button>
                <button type="button" class="btn btn-gradient-primary btn-sm" id="saveDipBtn">
                    <i class="mdi mdi-content-save"></i> Save Pump Record
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('tankSelect')?.addEventListener('change', function() {
            const selectedTank = this.options[this.selectedIndex].text;
            const fuelType = selectedTank.split(' - ')[1] || 'N/A';
            document.getElementById('fuelType').value = fuelType;
        });
    });
</script>
