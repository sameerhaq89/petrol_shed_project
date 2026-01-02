<form id="dipForm" class="dip-management-form">
    <div class="row g-2">
        <div class="col-md-3">
            <label class="form-label">Reference No:</label>
            <input type="text" class="form-control form-control-sm" name="reference" value="{{ $reference ?? '' }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Date & Time:</label>
            <input type="datetime-local" class="form-control form-control-sm" name="datetime"
                value="{{ now()->format('Y-m-d\TH:i') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Daily Report Date:</label>
            <input type="date" class="form-control form-control-sm" name="report_date"
                value="{{ now()->toDateString() }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Location:</label>
            <select class="form-select form-select-sm" style="padding-bottom:12px;" name="location">
                <option>S.H.M Jafris Lanka Filling Station</option>
            </select>
        </div>
    </div>

    {{-- <hr class="my-3"> --}}

    <div class="row g-2 align-items-end mt-3">
        <div class="col-md-3">
            <label class="form-label">Tanks:</label>
            <select class="form-select form-select-sm" style="padding-top:12px;" id="tankSelect">
                <option value="LP92-1">LP92-1</option>
                <option value="LP92-2">LP92-2</option>
                <option value="LAD-1">LAD-1</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Dip Reading:</label>
            <input type="number" class="form-control form-control-sm" id="dipReading" placeholder="e.g. 1290">
        </div>
        <div class="col-md-3">
            <label class="form-label">Dip Value (L):</label>
            <input type="number" class="form-control form-control-sm" id="dipValue" placeholder="Litres">
        </div>
        <div class="col-md-2 d-flex flex-column">
            <label class="form-label">Current Qty:</label>
            <input type="text" class="form-control form-control-sm" id="currentQty" readonly value="0.00">
        </div>
        <div class="col-md-1 d-flex align-items-center justify-content-end">
            <div>
                <button type="button" class="btn btn-sm btn-gradient-primary" style="padding-top:12px;" id="addDipRow" title="Add">
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
