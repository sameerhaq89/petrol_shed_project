<style>
    #quickMeterSaleBtn:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(103, 58, 183, 0.4) !important;
    }

    #quickMeterSaleBtn:focus {
        box-shadow: 0 8px 20px rgba(103, 58, 183, 0.6) !important;
    }

    #quickMeterSalePanel .card {
        animation: slideUp 0.3s ease-out;
    }

    /* Force shrink all inputs in quick panel */
    #quickMeterSalePanel input.form-control,
    #quickMeterSalePanel select.form-control {
        height: 32px !important;
        min-height: 32px !important;
        padding: 0.25rem 0.5rem !important;
        font-size: 0.8125rem !important;
        line-height: 1.5 !important;
    }

    /* Shrink the + buttons */
    .quick-add-btn {
        padding: 0.15rem 0.4rem !important;
        font-size: 0.75rem !important;
        height: 24px !important;
        line-height: 1 !important;
    }

    .quick-add-btn .mdi {
        font-size: 14px !important;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 576px) {
        #quickMeterSalePanel {
            width: calc(100vw - 20px) !important;
            right: 10px !important;
            bottom: 80px !important;
        }

        #quickMeterSaleBtn {
            right: 10px !important;
            bottom: 10px !important;
        }
    }

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
        height: 32px !important;
        padding: 0.25rem 0.5rem !important;
        font-size: 0.8125rem !important;
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

    .pump-select-quick+button,
    .product-select-quick+button {
        position: absolute;
        z-index: 1050;
    }
</style>
<div style="position:fixed; bottom:20px; right:20px; z-index:9999;">
    <button class="btn btn-gradient-primary btn-lg shadow-lg" id="quickMeterSaleBtn" data-bs-toggle="collapse"
        data-bs-target="#quickMeterSalePanel" style="border-radius: 50%; width: 60px; height: 60px; 
                    padding: 0; display: flex; align-items: center; 
                    justify-content: center; transition: all 0.3s ease;">
        <i class="mdi mdi-gas-station" style="font-size: 28px; margin: 0;"></i>
    </button>
</div>

<!-- Quick Meter Sale Panel -->
<div class="collapse" id="quickMeterSalePanel"
    style="position:fixed; bottom:90px; right:20px; z-index:9998; width: 400px; max-width: calc(100vw - 40px);">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 small"><i class="mdi mdi-gas-station me-2"></i>Quick Meter Sale</h6>
            <button type="button" class="btn-close btn-close-white" data-bs-toggle="collapse"
                data-bs-target="#quickMeterSalePanel"></button>
        </div>
        <div class="card-body p-2">
            <!-- Product -->
            <div class="mb-1">
                <label class="text-muted small mb-1">Product</label>
                <div class="position-relative">
                    <select class="form-control form-control-sm pe-5 product-select-quick" autocomplete="off">
                        <option value="">Please Select</option>
                        <option value="1">Petrol</option>
                        <option value="2">Diesel</option>
                    </select>
                    <button type="button"
                        class="btn btn-light position-absolute top-50 end-0 translate-middle-y me-1 quick-add-btn">
                        <i class="mdi mdi-plus"></i>
                    </button>
                </div>
            </div>

            <!-- Pump No -->
            <div class="mb-1">
                <label class="text-muted small mb-1">Pump No</label>
                <div class="position-relative">
                    <select class="form-control form-control-sm pe-5 pump-select-quick" autocomplete="off">
                        <option value="">Select Pump</option>
                        <option value="1">LP1</option>
                        <option value="2">LP2</option>
                        <option value="3">LP3</option>
                    </select>
                    <button type="button"
                        class="btn btn-light position-absolute top-50 end-0 translate-middle-y me-1 quick-add-btn">
                        <i class="mdi mdi-plus"></i>
                    </button>
                </div>
            </div>

            <!-- Starting Meter -->
            <div class="mb-1">
                <label class="text-muted small mb-1">Starting Meter</label>
                <input type="text" class="form-control form-control-sm bg-light" readonly>
            </div>

            <!-- Closing Meter -->
            <div class="mb-1">
                <label class="text-muted small mb-1">Closing Meter</label>
                <input type="text" class="form-control form-control-sm">
            </div>

            <!-- Sold Qty -->
            <div class="mb-1">
                <label class="text-muted small mb-1">Sold Qty</label>
                <input type="text" class="form-control form-control-sm bg-light">
            </div>

            <!-- Unit Price -->
            <div class="mb-1">
                <label class="text-muted small mb-1">Unit Price</label>
                <input type="text" class="form-control form-control-sm bg-light">
            </div>

            <!-- Testing Qty -->
            <div class="mb-2">
                <label class="text-muted small mb-1">Testing Qty</label>
                <input type="text" class="form-control form-control-sm">
            </div>

            <!-- Action Button -->
            <button class="btn btn-gradient-primary btn-sm w-100">
                <i class="mdi mdi-plus"></i> Add Entry
            </button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quickMeterSalePanel = document.getElementById('quickMeterSalePanel');
        
        quickMeterSalePanel.addEventListener('shown.bs.collapse', function () {
            if (!document.querySelector('.pump-select-quick').tomselect) {
                new TomSelect(".pump-select-quick", {
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
            }
            
            if (!document.querySelector('.product-select-quick').tomselect) {
                new TomSelect(".product-select-quick", {
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
            }
        });
    });
</script>