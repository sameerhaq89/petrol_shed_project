{{-- 1. Dynamic ID: Matches the button in your tank card --}}
<div class="modal fade" id="adjustStockModal{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">Dip / Refill: {{ $tankName ?? 'Tank' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- 2. Dynamic Action: Points to the specific adjustStock route --}}
            <form action="{{ route('tanks.adjustStock', $id) }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Operation Type --}}
                    <div class="mb-3">
                        <label class="form-label">Operation Type</label>
                        <select name="type" class="form-select" required>
                            <option value="dip">Dip Reading (Set Exact Level)</option>
                            <option value="refill">Refill (Add to Current)</option>
                            <option value="correction">Correction</option>
                        </select>
                    </div>

                    {{-- Quantity --}}
                    <div class="mb-3">
                        <label class="form-label">Liters</label>
                        <input type="number" step="0.01" name="quantity" class="form-control" required placeholder="e.g. 5000">
                    </div>

                    {{-- Reason/Notes --}}
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <input type="text" name="reason" class="form-control" placeholder="Optional notes">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-success">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
