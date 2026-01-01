<link rel="stylesheet" href="{{ asset('assets/css/settlement-summary.css') }}">
<div class="row g-2">
    <!-- Total Qty -->
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm summary-card text-dark" style="background-color: #f3e5f5; min-height:110px;">
            <div class="d-flex align-items-center justify-content-between h-100 px-4 py-3">
                <div>
                    <p class="mb-1 fw-bold small" >Total Qty</p>
                    <h4 class="mb-0 fw-bold" id="totalQty"></h4>
                </div>
                <i class="mdi mdi-counter mdi-36px text-primary"></i>
            </div>
        </div>
    </div>

    <!-- Gross Amount -->
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm summary-card text-dark" style="background-color: #e8f5e9; min-height:110px;">
            <div class="d-flex align-items-center justify-content-between h-100 px-4 py-3">
                <div>
                    <p class="mb-1 fw-bold small">Gross Amount</p>
                    <h4 class="mb-0 fw-bold" id="grossAmount"></h4>
                </div>
                <i class="mdi mdi-cash-multiple mdi-36px text-success"></i>
            </div>
        </div>
    </div>

    <!-- Total Discount -->
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm summary-card text-dark" style="background-color: #fff3e0; min-height:110px;">
            <div class="d-flex align-items-center justify-content-between h-100 px-4 py-3">
                <div>
                    <p class="mb-1 fw-bold small">Total Discount</p>
                    <h4 class="mb-0 fw-bold" id="totalDiscount"></h4>
                </div>
                <i class="mdi mdi-percent mdi-36px text-warning"></i>
            </div>
        </div>
    </div>

    <!-- Net Worth -->
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm summary-card text-dark" style="background-color: #e1f5fe; min-height:110px;">
            <div class="d-flex align-items-center justify-content-between h-100 px-4 py-3">
                <div>
                    <p class="mb-1 fw-bold small">Net Worth</p>
                    <h4 class="mb-0 fw-bold" id="netWorth"></h4>
                </div>
                <i class="mdi mdi-wallet mdi-36px text-info"></i>
            </div>
        </div>
    </div>
</div>
