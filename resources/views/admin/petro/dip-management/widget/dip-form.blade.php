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
<form action="{{ route('dip-management.store') }}" method="POST" class="dip-management-form">
    @csrf
    <div class="row">
        {{-- Tank Selection --}}
        <div class="col-md-3 mb-3">
            <label class="form-label">Tank <span class="text-danger">*</span></label>
            <select name="tank_id" class="form-select form-control" required>
                <option value="">-- Select Tank --</option>
                @foreach($tanks as $tank)
                    <option value="{{ $tank->id }}">
                        {{ $tank->tank_name }} ({{ $tank->fuelType->name ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Reading Date --}}
        <div class="col-md-3 mb-3">
            <label class="form-label">Reading Date <span class="text-danger">*</span></label>
            <input type="date" name="reading_date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        {{-- Dip Level --}}
        <div class="col-md-2 mb-3">
            <label class="form-label">Dip Level (cm) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="dip_level_cm" class="form-control" placeholder="0.00" required>
        </div>

        {{-- Volume --}}
        <div class="col-md-2 mb-3">
            <label class="form-label">Volume (Liters) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="volume_liters" class="form-control" placeholder="0.00" required>
        </div>

        {{-- Temperature (Optional) --}}
        <div class="col-md-2 mb-3">
            <label class="form-label">Temp (°C)</label>
            <input type="number" step="0.1" name="temperature" class="form-control" placeholder="Optional">
        </div>
    </div>

    <div class="row align-items-end">
        {{-- Notes --}}
        <div class="col-md-10 mb-3">
            <label class="form-label">Notes / Remarks</label>
            <input type="text" name="notes" class="form-control" placeholder="Enter any observations...">
        </div>

        {{-- Submit Button --}}
        <div class="col-md-2 mb-3">
            <button type="submit" class="btn btn-gradient-primary">
                {{-- <i class="mdi mdi-check-circle"></i> Save Dip --}}
                Save Dip
            </button>
        </div>
    </div>
</form>
@push('js')
<script>
    document.querySelectorAll('.tom-select').forEach(el => {
    new TomSelect(el, {
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
    })
</script>
@endpush
