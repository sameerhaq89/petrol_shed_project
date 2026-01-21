<div style="position:fixed; bottom:20px; right:20px; z-index:9999;">
    <button class="btn btn-gradient-primary btn-lg shadow-lg qms-btn" 
            data-bs-toggle="collapse" 
            data-bs-target="#quickMeterSalePanel" 
            style="border-radius: 50%; width: 60px; height: 60px; padding: 0; display: flex; align-items: center; justify-content: center;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 30px; height: 30px; fill: white;">
            <path d="M19,5.5H16.5V3.5A2,2 0 0,0 14.5,1.5H6.5A2,2 0 0,0 4.5,3.5V20.5A2,2 0 0,0 6.5,22.5H14.5A2,2 0 0,0 16.5,20.5V18.5H19.5A1.5,1.5 0 0,0 21,17V7A1.5,1.5 0 0,0 19,5.5M13,12.5H8V5.5H13V12.5M19,10H17V7H19V10Z" />
        </svg>
    </button>
</div>

<div class="collapse qms-panel" id="quickMeterSalePanel"
     style="position:fixed; bottom:90px; right:20px; z-index:9998; width: 400px; max-width: calc(100vw - 40px);">
    
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 small">Quick Meter Sale</h6>
            <button type="button" class="btn-close btn-close-white" data-bs-toggle="collapse" data-bs-target="#quickMeterSalePanel"></button>
        </div>
        
        <div class="card-body p-3">
            {{-- CHECK IF SHIFT IS OPEN --}}
            @if(isset($activeShift) && $activeShift)
                
                <form action="{{ route('settlement.save-reading') }}" method="POST">
                    @csrf
                    <input type="hidden" name="shift_id" value="{{ $activeShift->id }}">
                    
                    {{-- PUMP SELECT --}}
                    <div class="mb-2">
                        <label class="small text-muted">Select Pump</label>
                        <select name="pump_id" class="form-control form-control-sm" required>
                            <option value="">-- Select --</option>
                            @foreach($quickPumps ?? [] as $pump)
                                <option value="{{ $pump->id }}">
                                    {{ $pump->pump_name ?? $pump->pump_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- CLOSING READING --}}
                    <div class="mb-2">
                        <label class="small text-muted">Closing Reading</label>
                        <input type="number" step="0.01" name="end_reading" class="form-control form-control-sm" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100">Save</button>
                </form>

            @else
                {{-- ERROR MESSAGE IF NO SHIFT --}}
                <div class="text-center py-4">
                    <i class="mdi mdi-alert-circle-outline text-danger" style="font-size: 40px;"></i>
                    <p class="mb-0 text-muted">No Open Shift Found.</p>
                    <small>Please open a shift to add sales.</small>
                </div>
            @endif
        </div>
    </div>
</div>