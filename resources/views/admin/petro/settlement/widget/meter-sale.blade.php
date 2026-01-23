<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="card-title text-primary"><i class="mdi mdi-gas-station me-2"></i>Meter Sale Entry</h4>

        <form action="{{ route('settlement.save-reading') }}" method="POST">
            @csrf
            <input type="hidden" name="shift_id" value="{{ $shift->id ?? '' }}">

            <div class="row align-items-end">
                {{-- 1. SELECT PUMP (Searchable Dropdown) --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label font-weight-bold">Select Pump</label>
                    <select id="pumpSelect" name="pump_id" class="form-select form-control-sm" required>
                        <option value="" selected disabled>-- Search & Select Pump --</option>
                        @foreach($pumps as $pump)
                            <option value="{{ $pump->id }}"
                                    data-start="{{ $pump->current_reading }}"
                                    data-price="{{ $pump->fuelType->selling_price ?? 0 }}"
                                    data-fuel="{{ $pump->fuelType->name ?? 'Fuel' }}">
                                {{ $pump->pump_name ?? $pump->pump_number }}
                            </option>
                        @endforeach
                    </select>
                    <small id="fuelTypeDisplay" class="text-muted"></small>
                </div>

                {{-- 2. OPENING READING (Auto-Filled) --}}
                <div class="col-md-2 mb-3">
                    <label class="form-label text-muted">Opening</label>
                    <input type="number" step="0.01" id="startReading" name="start_reading" class="form-control form-control-sm bg-light" readonly>
                </div>

                {{-- 3. CLOSING READING (User Input) --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label font-weight-bold text-dark">Closing Reading</label>
                    <input type="number" step="0.01" id="endReading" name="end_reading" class="form-control form-control-sm" placeholder="Enter Value" required>
                </div>

                {{-- 4. VOLUME (Calculated) --}}
                <div class="col-md-2 mb-3">
                    <label class="form-label text-muted">Volume</label>
                    <input type="text" id="volumeDisplay" class="form-control form-control-sm bg-light font-weight-bold text-primary" readonly value="0.00">
                </div>

                {{-- 5. SUBMIT BUTTON --}}
                <div class="col-md-1 mb-3">
                    <button type="submit" class="btn btn-gradient-success btn-sm w-100 btn-icon-text" style="border-left: dashed;">
                        <i class="mdi mdi-plus"></i>
                        {{-- Add --}}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- JAVASCRIPT FOR AUTO-POPULATION --}}
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pumpSelect = document.getElementById('pumpSelect');
        const startInput = document.getElementById('startReading');
        const endInput = document.getElementById('endReading');
        const volDisplay = document.getElementById('volumeDisplay');
        const fuelDisplay = document.getElementById('fuelTypeDisplay');

        // 1. When Pump is Selected -> Populate Opening Reading
        pumpSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const startVal = selectedOption.getAttribute('data-start');
            const fuelName = selectedOption.getAttribute('data-fuel');

            startInput.value = startVal;
            fuelDisplay.textContent = "Fuel: " + fuelName;

            // Reset calculation fields
            endInput.value = '';
            volDisplay.value = '0.00';
            endInput.focus();
        });

        // 2. When Closing Reading is Typed -> Calculate Volume
        endInput.addEventListener('input', function() {
            const start = parseFloat(startInput.value) || 0;
            const end = parseFloat(this.value) || 0;

            let volume = 0;
            if (end > start) {
                volume = end - start;
            }

            volDisplay.value = volume.toFixed(2);
        });
    });
    // Initialize Searchable Dropdown
new TomSelect("#pumpSelect",{
    create: false,
    sortField: {
        field: "text",
        direction: "asc"
    }
});
</script>
@endpush
