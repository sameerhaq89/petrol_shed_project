<div class="row">
    {{-- LEFT COLUMN: ADD CASH DROP FORM --}}
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="card-title text-warning">
                    <i class="mdi mdi-cash-marker me-2"></i>Add Cash Drop
                </h4>
                <p class="card-description text-muted small">Record cash collected from pumpers.</p>

                {{-- FORM START --}}
                <form action="{{ route('cash-drop.store') }}" method="POST">
                    @csrf
                    {{-- Hidden Shift ID is handled by Controller using 'open' shift,
                    but we can keep this if your controller uses it --}}
                    <input type="hidden" name="shift_id" value="{{ $shift->id }}">

                    {{-- 1. SELECT PUMPER (NEW) --}}
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Select Pumper</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Select Pumper --</option>
                            {{-- Now $pumpers is guaranteed to be only pumpers --}}
                            @foreach($pumpers as $pumper)
                                <option value="{{ $pumper->id }}">{{ $pumper->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2. AMOUNT --}}
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">Amount (LKR)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-dark">Rs.</span>
                            <input type="number" step="0.01" name="amount"
                                class="form-control form-control-lg font-weight-bold text-success" placeholder="0.00"
                                required>
                        </div>
                    </div>

                    {{-- 3. NOTES --}}
                    <div class="form-group mb-4">
                        <label>Note (Optional)</label>
                        <textarea name="notes" class="form-control" rows="2"
                            placeholder="e.g. 5000 x 4 notes"></textarea>
                    </div>

                    <button type="submit" class="btn btn-gradient-warning w-100 btn-lg font-weight-bold">
                        <i class="mdi mdi-check-circle-outline me-2"></i> Save Drop
                    </button>
                </form>
                {{-- FORM END --}}
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN: DROP HISTORY TABLE --}}
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title text-primary">Drop History</h4>
                    <span class="badge badge-outline-success font-weight-bold" style="font-size: 14px;">
                        Total: {{ number_format($shift->cashDrops->sum('amount'), 2) }}
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Time</th>
                                <th>Pumper</th> {{-- Added Pumper Column --}}
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shift->cashDrops as $drop)
                                <tr>
                                    {{-- Time --}}
                                    <td class="text-muted">
                                        {{ \Carbon\Carbon::parse($drop->created_at)->format('h:i A') }}
                                    </td>

                                    {{-- Pumper Name (NEW) --}}
                                    <td class="font-weight-bold text-dark">
                                        {{ $drop->user->name ?? 'Unknown' }}
                                    </td>

                                    {{-- Amount --}}
                                    <td class="font-weight-bold text-success">
                                        {{ number_format($drop->amount, 2) }}
                                    </td>

                                    {{-- Note --}}
                                    <td>{{ $drop->notes ?? '-' }}</td>

                                    {{-- Action --}}
                                    <td>
                                        {{-- Use your existing delete route if you have one,
                                        otherwise we need to create it --}}
                                        <form action="{{ route('cash-drops.destroy', $drop->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this drop?');"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-danger btn-sm btn-icon"
                                                title="Delete Drop">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-cash-remove" style="font-size: 30px;"></i><br>
                                        No cash drops recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>