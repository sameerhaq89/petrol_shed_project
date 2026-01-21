<div class="modal fade" id="assignPumperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-gradient-primary text-white py-3">
                <h5 class="modal-title"><i class="mdi mdi-gas-station me-2"></i>Start Pumper Duty</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pumper.assign') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info border-0 small mb-4">
                        <i class="mdi mdi-information-outline me-1"></i> 
                        Assigning a pumper will automatically record the current pump meter reading.
                    </div>

                    {{-- 1. Select Pumper --}}
                    <div class="form-group mb-3">
                        <label class="font-weight-bold mb-1">Select Pumper</label>
                        <select name="user_id" class="form-select border-primary" required>
                            <option value="">-- Select Employee --</option>
                            @foreach($pumpers as $pumper)
                                <option value="{{ $pumper->id }}">{{ $pumper->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2. Select Pump --}}
                    <div class="form-group mb-3">
                        <label class="font-weight-bold mb-1">Select Pump / Nozzle</label>
                        <select name="pump_id" class="form-select border-primary" required>
                            <option value="">-- Select Available Pump --</option>
                            @foreach($availablePumps as $pump)
                                <option value="{{ $pump->id }}">
                                    {{ $pump->pump_name }} (Current: {{ number_format($pump->current_reading, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 3. NEW: Opening Cash Field --}}
                    <div class="form-group mb-0">
                        <label class="font-weight-bold mb-1">Opening Cash (Float)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-primary">Rs.</span>
                            <input type="number" 
                                   name="opening_cash" 
                                   class="form-control border-primary" 
                                   placeholder="0.00" 
                                   min="0" 
                                   step="0.01" 
                                   value="0"> {{-- Default to 0 --}}
                        </div>
                        <small class="text-muted">Cash handed to pumper for change.</small>
                    </div>

                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-primary px-4 font-weight-bold">
                        <i class="mdi mdi-play-circle-outline me-1"></i> Start Duty
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>