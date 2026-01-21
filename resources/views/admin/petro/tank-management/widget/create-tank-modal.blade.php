<div class="modal fade" id="addTankModal" tabindex="-1" aria-labelledby="addTankModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTankModalLabel">
                    <i class="mdi mdi-gas-station me-1"></i> Add New Tank
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('tanks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Tank Number & Name --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tank_number" class="form-label">Tank Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tank_number" placeholder="T-01" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tank_name" class="form-label">Tank Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="tank_name" placeholder="Main Tank" required>
                        </div>
                    </div>

                    {{-- Fuel Type Dropdown --}}
                    <div class="mb-3">
                        <label for="fuel_type_id" class="form-label">Fuel Type <span class="text-danger">*</span></label>
                        <select class="form-select" name="fuel_type_id" required>
                            <option value="">-- Select Fuel Type --</option>
                            @if(isset($fuel_types) && count($fuel_types) > 0)
                                @foreach($fuel_types as $fuel)
                                    <option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>No fuel types found</option>
                            @endif
                        </select>
                    </div>

                    {{-- Capacity & Opening Stock --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="capacity" class="form-label">Capacity (Liters) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="capacity" placeholder="10000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="current_stock" class="form-label">Opening Stock</label>
                            <input type="number" step="0.01" class="form-control" name="current_stock" placeholder="0">
                            <small class="text-muted">Initial fuel level</small>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-primary">Save Tank</button>
                </div>
            </form>
        </div>
    </div>
</div>