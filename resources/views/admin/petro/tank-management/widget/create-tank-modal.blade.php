<div class="modal fade" id="addTankModal" tabindex="-1" aria-labelledby="addTankModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="addTankModalLabel">
                    <i class="mdi mdi-gas-station me-1"></i> Add New Tank
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('tanks.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Tank Number & Name & Fuel Type --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tank_number" class="form-label">Tank Number <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="tank_number" placeholder="T-01" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tank_name" class="form-label">Tank Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="tank_name" placeholder="Main Tank" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="fuel_type_id" class="form-label">Fuel Type <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-control-sm" name="fuel_type_id" required>
                                <option value="">-- Select Fuel --</option>
                                @if(isset($fuel_types) && count($fuel_types) > 0)
                                    @foreach($fuel_types as $fuel)
                                        <option value="{{ $fuel->id }}">{{ $fuel->name }}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No fuel types found</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <hr class="my-2">
                    <h6 class="text-muted mb-3"><i class="mdi mdi-chart-line"></i> Capacity & Stock Control</h6>

                    {{-- Capacity & Stock Levels --}}
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="capacity" class="form-label">Capacity (L) <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="capacity" placeholder="20000"
                                required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="current_stock" class="form-label">Opening Stock (L)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="current_stock" placeholder="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="reorder_level" class="form-label">Reorder Level (L)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="reorder_level"
                                placeholder="5000">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="maximum_level" class="form-label">Max Level (L)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="maximum_level"
                                placeholder="19500">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="minimum_level" class="form-label">Min Level (L)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" name="minimum_level"
                                placeholder="1000">
                        </div>
                    </div>

                    <hr class="my-2">
                    <h6 class="text-muted mb-3"><i class="mdi mdi-cogs"></i> Technical Details</h6>

                    {{-- Technical Details --}}
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="tank_type" class="form-label">Tank Type</label>
                            <select class="form-select form-control-sm" name="tank_type">
                                <option value="underground">Underground</option>
                                <option value="aboveground">Aboveground</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="manufacturer" class="form-label">Manufacturer</label>
                            <input type="text" class="form-control form-control-sm" name="manufacturer" placeholder="Tank Maker Inc.">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="material" class="form-label">Material</label>
                            <input type="text" class="form-control form-control-sm" name="material" placeholder="Steel / Fiberglass">
                        </div>
                    </div>

                    {{-- Dates --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="installation_date" class="form-label">Installation Date</label>
                            <input type="date" class="form-control form-control-sm" name="installation_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_cleaned_date" class="form-label">Last Cleaned Date</label>
                            <input type="date" class="form-control form-control-sm" name="last_cleaned_date">
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control form-control-sm" name="notes" rows="2"
                            placeholder="Additional details..."></textarea>
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
