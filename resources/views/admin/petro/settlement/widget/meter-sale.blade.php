<style>
    .ts-dropdown .option:hover,
    .ts-dropdown .active {
        background-color: #7367f0 !important;
        color: white !important;
    }

    .ts-dropdown .option.active {
        background-color: #7367f0 !important;
    }

    .ts-dropdown .option:hover {
        background-color: #f3f2f7 !important;
        color: #5e5873 !important;
    }

    .ts-dropdown .option.selected {
        background-color: #e7e7ff !important;
        color: #7367f0 !important;
    }

    .ts-control {
        min-height: 31px !important;
        height: 40px !important;
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
        line-height: 1.5;
        box-shadow: none !important;
    }

    .ts-control>input,
    .ts-control>.item {
        line-height: 1.5 !important;
    }

    .ts-wrapper.single .ts-control:after {
        top: 50%;
        transform: translateY(-50%);
    }
</style>

<div class="col-12">
    <div class="card mb-2">
        <div class="card-body py-2">
            <!-- Line 1 -->
            <div class="row">
                <!-- Product -->
                <div class="col-md-3">
                    <label class="text-muted small mb-1">Product</label>
                    <div class="position-relative">
                        <select class="form-control form-control-sm mb-2 pe-5 product-select" autocomplete="off">
                            <option value="">Please Select</option>
                            <option value="1">Petrol</option>
                            <option value="2">Diesel</option>
                        </select>
                        <button type="button"
                            class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-1 px-2">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Pump No -->
                <div class="col-md-3">
                    <label class="text-muted small mb-1">Pump No</label>
                    <div class="position-relative">
                        <select class="form-control form-control-sm mb-3 pe-5 pump-select " autocomplete="off">
                            <option value="">Select Pump</option>
                            <option value="1">LP1</option>
                            <option value="2">LP2</option>
                            <option value="3">LP3</option>
                        </select>
                        <button type="button"
                            class="btn btn-sm btn-light position-absolute top-50 end-0 translate-middle-y me-1 px-2"
                            data-bs-toggle="modal" data-bs-target="#recordDipModal">
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
@push('js')
    <script>
        new TomSelect(".pump-select", {
            sortField: {
                field: "text",
                direction: "asc"
            },
            plugins: {
                'clear_button': {
                    'title': 'Remove all selected options',
                }
            },
            persist: false,
        });
        new TomSelect(".product-select", {
            sortField: {
                field: "text",
                direction: "asc"
            },
            plugins: {
                'clear_button': {
                    'title': 'Remove all selected options',
                }
            },
            persist: false,
        });
    </script>
@endpush
