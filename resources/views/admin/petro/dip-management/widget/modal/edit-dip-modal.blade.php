<div class="modal fade" id="editDipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="mdi mdi-pencil me-1"></i> Edit Dip Reading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            {{-- Form Action URL is set by JS --}}
            <form id="editDipForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    {{-- Tank --}}
                    <div class="mb-3">
                        <label>Tank</label>
                        {{-- JS looks for id="edit_tank_id" --}}
                        <select name="tank_id" id="edit_tank_id" class="form-select" required>
                            @foreach($tanks as $tank)
                                <option value="{{ $tank->id }}">{{ $tank->tank_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date --}}
                    <div class="mb-3">
                        <label>Date</label>
                        {{-- JS looks for id="edit_reading_date" --}}
                        <input type="date" name="reading_date" id="edit_reading_date" class="form-control" required>
                    </div>

                    {{-- Level & Volume --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Dip Level (cm)</label>
                            {{-- JS looks for id="edit_dip_level" --}}
                            <input type="number" step="0.01" name="dip_level_cm" id="edit_dip_level" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Volume (Liters)</label>
                            {{-- JS looks for id="edit_volume" --}}
                            <input type="number" step="0.01" name="volume_liters" id="edit_volume" class="form-control" required>
                        </div>
                    </div>

                    {{-- Temp --}}
                    <div class="mb-3">
                        <label>Temperature</label>
                        {{-- JS looks for id="edit_temperature" --}}
                        <input type="number" step="0.1" name="temperature" id="edit_temperature" class="form-control">
                    </div>

                    {{-- Notes --}}
                    <div class="mb-3">
                        <label>Notes</label>
                        {{-- JS looks for id="edit_notes" --}}
                        <textarea name="notes" id="edit_notes" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>