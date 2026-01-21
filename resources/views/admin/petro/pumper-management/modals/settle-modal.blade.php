<div class="modal fade" id="settle-modal{{ $stat->assignment_id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-white">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Settle Shortage: {{ $stat->pumper_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <form action="{{ route('pumper.settle', $stat->assignment_id) }}" method="POST">
                @csrf
                <div class="modal-body text-left">
                    <p class="text-muted">The pumper currently owes <strong>Rs.
                            {{ number_format($pending, 2) }}</strong>.</p>

                    <div class="form-group">
                        <label class="font-weight-bold">Amount Received (LKR)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rs.</span>
                            </div>
                            <input type="number" name="settle_amount" step="0.01"
                                class="form-control form-control-lg" value="{{ $pending }}"
                                max="{{ $pending }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning font-weight-bold">Confirm Settlement</button>
                </div>
            </form>
        </div>
    </div>
</div>
