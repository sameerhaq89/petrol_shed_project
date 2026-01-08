<style>
    .dip-management-form .ts-dropdown .option:hover,
    .dip-management-form .ts-dropdown .active {
        background-color: #7367f0 !important;
        color: white !important;
    }

    .dip-management-form .ts-dropdown .option.active {
        background-color: #7367f0 !important;
    }

    .dip-management-form .ts-dropdown .option:hover {
        background-color: #f3f2f7 !important;
        color: #5e5873 !important;
    }

    .dip-management-form .ts-dropdown .option.selected {
        background-color: #e7e7ff !important;
        color: #7367f0 !important;
    }

    .dip-management-form .ts-control {
        min-height: 31px !important;
        height: 40px !important;
        padding: 0.25rem 0.5rem !important;
        font-size: 0.875rem !important;
        line-height: 1.5;
        box-shadow: none !important;
    }

    .dip-management-form .ts-control>input,
    .dip-management-form .ts-control>.item {
        line-height: 1.5 !important;
    }
</style>
<form id="dipForm" class="dip-management-form">
    <div class="row g-2">
        <div class="col-md-3">
            <label class="text-muted small mb-1">Reference No:</label>
            <input type="text" class="form-control form-control-sm" name="reference" value="{{ $reference ?? '' }}">
        </div>
        <div class="col-md-3">
            <label class="text-muted small mb-1">Date & Time:</label>
            <input type="datetime-local" class="form-control form-control-sm" name="datetime"
                value="{{ now()->format('Y-m-d\TH:i') }}">
        </div>
        <div class="col-md-3">
            <label class="text-muted small mb-1">Daily Report Date:</label>
            <input type="date" class="form-control form-control-sm" name="report_date"
                value="{{ now()->toDateString() }}">
        </div>
        <div class="col-md-3">
            <label class="text-muted small mb-1">Location:</label>
            <select class="form-control form-control-sm" style="padding-bottom:12px;" name="location">
                <option>S.H.M Jafris Lanka Filling Station</option>
            </select>
        </div>
    </div>

    {{--
    <hr class="my-3"> --}}

    <div class="row g-2 align-items-end mt-3">
        <div class="col-md-3">
            <label class="text-muted small mb-1">Tanks:</label>
            <select class="form-control form-control-sm tank-select" style="padding-top:12px;" id="tankSelect"
                autocomplete="off">
                <option value="">Select Tank</option>
                <option value="LP92-1">LP92-1</option>
                <option value="LP92-2">LP92-2</option>
                <option value="LAD-1">LAD-1</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="text-muted small mb-1">Dip Reading:</label>
            <input type="number" class="form-control form-control-sm" id="dipReading" placeholder="e.g. 1290">
        </div>
        <div class="col-md-3">
            <label class="text-muted small mb-1">Dip Value (L):</label>
            <input type="number" class="form-control form-control-sm" id="dipValue" placeholder="Litres">
        </div>
        <div class="col-md-2 d-flex flex-column">
            <label class="text-muted small mb-1">Current Qty:</label>
            <input type="text" class="form-control form-control-sm" id="currentQty" readonly value="0.00">
        </div>
        <div class="col-md-1 d-flex align-items-center justify-content-end">
            <div>
                <button type="button" class="btn btn-sm btn-gradient-primary" style="padding-top:12px;" id="addDipRow"
                    title="Add">
                    <i class="mdi mdi-plus" style="font-size:18px"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{-- <div class="table-responsive">
            <table class="table table-sm table-hover" id="dipEntriesTable">
                <thead>
                    <tr>
                        <th>Tank</th>
                        <th>Dip Reading</th>
                        <th>Dip Value (L)</th>
                        <th>Current Qty</th>
                        <th>Note</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div> --}}
        <div class="d-flex justify-content-end mt-2">
            <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="resetFormBtn">Reset</button>
            <button type="button" class="btn btn-sm btn-gradient-primary" id="saveAllBtn">Save All</button>
        </div>
    </div>
</form>
@push('js')
<script>
    new TomSelect(".tank-select", {
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