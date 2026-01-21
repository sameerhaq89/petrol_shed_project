<div class="modal fade" id="editPumpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="mdi mdi-pencil me-1"></i> Edit Pump</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            {{-- Form Action is updated via JS --}}
            <form id="editPumpForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_pump_id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pump Number</label>
                            <input type="text" name="pump_number" id="edit_pump_number" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pump Name</label>
                            <input type="text" name="pump_name" id="edit_pump_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Tank</label>
                        <select name="tank_id" id="edit_tank_id" class="form-select" required>
                            @foreach($tanks as $tank)
                                <option value="{{ $tank->id }}">{{ $tank->tank_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Current Meter Reading (Read Only)</label>
                        <input type="text" id="edit_meter_reading" class="form-control" disabled>
                        <small class="text-muted">To adjust meter, use the Testing/Calibration feature.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-select">
                            <option value="active">Active</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Pump</button>
                </div>
            </form>
        </div>
    </div>
</div>