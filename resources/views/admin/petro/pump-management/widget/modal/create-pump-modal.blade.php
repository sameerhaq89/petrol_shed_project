<div class="modal fade" id="createPumpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title"><i class="mdi mdi-plus-circle me-1"></i> Add New Pump</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pumps.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Pump Name & Number --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pump Number <span class="text-danger">*</span></label>
                            <input type="text" name="pump_number" class="form-control" placeholder="P-01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pump Name <span class="text-danger">*</span></label>
                            <input type="text" name="pump_name" class="form-control" placeholder="Pump 1" required>
                        </div>
                    </div>

                    {{-- Tank Assignment --}}
                    <div class="mb-3">
                        <label class="form-label">Assign Tank <span class="text-danger">*</span></label>
                        <select name="tank_id" class="form-select" required>
                            <option value="">-- Select Tank --</option>
                            @foreach($tanks as $tank)
                                <option value="{{ $tank->id }}">{{ $tank->tank_name }} ({{ $tank->fuelType->name ?? 'Unknown' }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Initial Meter Reading --}}
                    <div class="mb-3">
                        <label class="form-label">Initial Meter Reading</label>
                        <input type="number" step="0.01" name="last_meter_reading" class="form-control" value="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-primary">Save Pump</button>
                </div>
            </form>
        </div>
    </div>
</div>
