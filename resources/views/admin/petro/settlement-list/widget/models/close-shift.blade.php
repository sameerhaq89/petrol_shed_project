{{-- resources/views/admin/petro/settlement-list/widget/models/close-shift.blade.php --}}
<div class="modal fade" id="closeShiftModal" tabindex="-1" aria-labelledby="closeShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('settlement.close') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="closeShiftModalLabel">End Shift & Settle: {{ $currentShift->shift_number }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2">
                    <small>
                        <i class="mdi mdi-information-outline me-1"></i> 
                        System expects approximately <strong>Rs. {{ number_format(($currentShift->opening_cash + $currentShift->sales->sum('amount')), 2) }}</strong>.
                    </small>
                </div>
                
                <div class="form-group mb-3">
                    <label class="font-weight-bold">Actual Physical Cash Count (LKR)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rs.</span>
                        <input type="number" step="0.01" name="closing_cash" class="form-control form-control-lg text-primary font-weight-bold" placeholder="0.00" required>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Closing Notes / Observations</label>
                    <textarea name="closing_notes" class="form-control" rows="3" placeholder="Enter any notes here..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-lg px-4">
                    <i class="mdi mdi-check-all me-1"></i> Finalize Settlement
                </button>
            </div>
        </form>
    </div>
</div>