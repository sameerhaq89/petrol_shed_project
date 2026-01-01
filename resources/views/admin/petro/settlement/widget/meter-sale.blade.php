<div class="col-12">
    <div class="card mb-2">
        <div class="card-body py-2">

            <!-- Line 1 -->
            <div class="row">

                <!-- Pump No -->
                <div class="col-md-3">
                    <label class="text-muted small mb-1">Pump No</label>
                    <div class="position-relative">
                        <select class="form-control form-control-sm mb-2 pe-5">
                            <option selected disabled>Please Select</option>
                            <option>LP1</option>
                        </select>
                        <button type="button"
                            class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-1 px-2"
                            data-bs-toggle="modal" data-bs-target="#recordDipModal">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Product -->
                <div class="col-md-3">
                    <label class="text-muted small mb-1">Product</label>
                    <div class="position-relative">
                        <select class="form-control form-control-sm mb-2 pe-5">
                            <option selected disabled>Please Select</option>
                            <option>Petrol</option>
                        </select>
                        <button type="button"
                            class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-1 px-2">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="col-md-3">
                    <label class="text-muted small mb-1">Starting Meter</label>
                    <input class="form-control form-control-sm bg-light mb-2" readonly>
                </div>

                <div class="col-md-3">
                    <label class="text-muted small mb-1">Closing Meter</label>
                    <input class="form-control form-control-sm mb-2">
                </div>
            </div>

            <!-- Line 2 -->
            <div class="row align-items-end">
                <div class="col-md-3">
                    <label class="text-muted small mb-1">Sold Qty</label>
                    <input class="form-control form-control-sm bg-light">
                </div>

                <div class="col-md-3">
                    <label class="text-muted small mb-1">Unit Price</label>
                    <input class="form-control form-control-sm bg-light">
                </div>

                <div class="col-md-3">
                    <label class="text-muted small mb-1">Testing Qty</label>
                    <input class="form-control form-control-sm">
                </div>

                <div class="col-md-3 text-end">
                    <button class="btn btn-gradient-primary btn-sm w-100">
                        <i class="mdi mdi-plus"></i> Add
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
