<div class="modal fade" id="openShiftModal" tabindex="-1" aria-labelledby="openShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="openShiftModalLabel">Start New Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('shifts.open') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Default to station_id 1 if null, matching Controller logic --}}
                    <input type="hidden" name="station_id" value="{{ Auth::user()->station_id ?? 1 }}">

                    <div class="mb-3">
                        <label for="opening_cash" class="form-label">Opening Cash Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">Rs.</span>
                            <input type="number" class="form-control" id="opening_cash" name="opening_cash" step="0.01"
                                min="0" required value="0">
                        </div>
                        <small class="text-muted">Enter the cash amount currently in the drawer to start the
                            shift.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-primary">
                        <i class="mdi mdi-play-circle-outline me-1"></i> Start Shift
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>