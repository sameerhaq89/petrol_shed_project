@if($currentShift)
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-primary shadow-sm" style="border-left: 5px solid #b66dff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="card-title text-primary mb-0">
                            <i class="mdi mdi-pulse me-2"></i>Live Active Shift
                        </h4>
                        <small class="text-muted">Currently running since {{ \Carbon\Carbon::parse($currentShift->start_time)->format('h:i A') }}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge badge-gradient-success px-3 py-2">OPEN</span>

                        {{-- Manage Readings Button --}}
                        <a href="{{ route('settlement.entry', $currentShift->id) }}" class="btn btn-sm btn-gradient-primary ms-2">
    <i class="mdi mdi-pencil me-1"></i> Manage Readings
</a>

                        {{-- NEW: End Shift Button --}}
                        <button type="button" class="btn btn-sm btn-gradient-danger ms-2" data-bs-toggle="modal" data-bs-target="#closeShiftModal">
    <i class="mdi mdi-stop-circle me-1"></i> End Shift
</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 border-end">
                        <p class="text-muted mb-1">Shift Number</p>
                        <h5 class="font-weight-bold">{{ $currentShift->shift_number }}</h5>
                    </div>
                    <div class="col-md-3 border-end">
                        <p class="text-muted mb-1">Live Sales Total</p>
                        <h5 class="font-weight-bold text-success">Rs. {{ number_format($currentShift->sales->sum('amount'), 2) }}</h5>
                    </div>
                    <div class="col-md-3 border-end">
                        <p class="text-muted mb-1">Cash Drops Collected</p>
                        <h5 class="font-weight-bold text-warning">Rs. {{ number_format($currentShift->cashDrops->sum('amount'), 2) }}</h5>
                    </div>
                    <div class="col-md-3">
                        <p class="text-muted mb-1">Fuel Sold</p>
                        <h5 class="font-weight-bold text-info">{{ number_format($currentShift->sales->sum('quantity'), 2) }} L</h5>
                    </div>
                </div>
                <div class="mt-3">
    <p class="small text-muted mb-2">Breakdown by Pumper:</p>
    @foreach($currentShift->cashDrops->groupBy('user_id') as $pumperId => $drops)
        <div class="d-flex justify-content-between border-bottom py-1">
            <span>{{ $drops->first()->user->name ?? 'Unknown' }}</span>
            <span class="font-weight-bold text-dark">Rs. {{ number_format($drops->sum('amount'), 2) }}</span>
        </div>
    @endforeach
</div>
            </div>
        </div>
    </div>
</div>


@else
<div class="alert alert-warning border-0 shadow-sm mb-4">
    <i class="mdi mdi-alert-circle me-2"></i> There is currently <strong>no active shift</strong>. Use the "Start New Shift" button to begin.
</div>
@endif
