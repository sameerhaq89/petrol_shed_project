<div class="card shadow-sm border-0">
    <div class="card-body">
        <h4 class="card-title mb-4">Current Duty Assignments</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Pumper Name</th>
                        <th>Assigned Pump</th>
                        <th>Opening Reading</th>
                        <th class="text-end">Pending Amount</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pumperStats as $stat)
                        @php
    // 1. Fetch the Assignment Model
    $assignmentModel = \App\Models\PumpOperatorAssignment::find($stat->assignment_id);

    // 2. Calculate Sales for this specific session
    // FIX: Filter by assignment time range to prevent overlap with next assignment
    $pSales = \App\Models\Sale::where('shift_id', $activeShift->id)
                ->where('pump_id', $stat->pump_id)
                ->where('created_by', $stat->pumper_id)
                ->where('start_reading', '>=', $stat->opening_reading)
                ->when($assignmentModel->end_time, function($q) use ($assignmentModel) {
                     return $q->where('created_at', '<=', $assignmentModel->end_time); 
                })
                ->sum('amount');

    // 3. Opening Cash Logic
    $pOpening = $assignmentModel->opening_cash ?? 0;
    $pExpected = $pSales + $pOpening;

    // 4. Calculate Drops
    // FIX: Filter by assignment time range to ensure we don't count drops from next session
    $pDrops = \App\Models\CashDrop::where('shift_id', $activeShift->id)
                ->where('user_id', $stat->pumper_id)
                ->where('created_at', '>=', $assignmentModel->start_time)
                ->when($assignmentModel->end_time, function($q) use ($assignmentModel) {
                     return $q->where('created_at', '<=', $assignmentModel->end_time); 
                })
                ->where(function($q) {
                    $q->whereNull('notes')
                      ->orWhere('notes', 'NOT LIKE', '%Final Settlement%');
                })
                ->sum('amount');

    // 5. Settlement Drops (Post-shift)
    $settlementDrops = \App\Models\CashDrop::where('shift_id', $activeShift->id)
                ->where('user_id', $stat->pumper_id)
                ->where('notes', 'LIKE', '%Shortage Settlement%')
                ->where('created_at', '>=', $assignmentModel->start_time)
                ->sum('amount');

    $finalHandover = $assignmentModel->closing_cash_received ?? 0;
    $totalCollected = $pDrops + $finalHandover + $settlementDrops;

    $pendingAmount = $pExpected - $totalCollected;
@endphp
                        <tr>
                            <td class="font-weight-bold">
                                <a href="{{ route('pumper.ledger', $stat->pumper_id) }}" class="text-dark">
                                    {{ $stat->pumper_name }}
                                </a>
                                @php
                                    $userRole = \App\Models\User::find($stat->pumper_id)->role_id;
                                @endphp
                                @if($userRole != 4)
                                    <span class="badge badge-warning ml-2" style="font-size: 0.7rem;">Manager</span>
                                @endif
                            </td>
                            <td><span class="badge badge-outline-primary">{{ $stat->pump_name }}</span></td>
                            <td>{{ number_format($stat->opening_reading, 2) }}</td>

                            {{-- Correctly displays shortage in red --}}
                            <td
                                class="text-end font-weight-bold {{ $pendingAmount > 0 ? 'text-danger' : 'text-success' }}">
                                {{ $pendingAmount > 0 ? 'Rs. ' . number_format($pendingAmount, 2) : '0.00' }}
                            </td>

                            <td class="text-center">
                                @if ($stat->status == 'active')
                                    <label class="badge badge-success">On Duty</label>
                                @elseif($stat->status == 'pending_settlement')
                                    @if($pendingAmount <= 0)
                                        <span class="badge badge-info shadow-sm">Duty Closed</span>
                                    @else
                                        <span class="badge badge-danger shadow-sm">Settlement Pending</span>
                                    @endif
                                @else
                                    <span class="badge badge-info shadow-sm">Duty Closed</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- ACTION 1: CLOSE DUTY (Only if Active) --}}
                                    @if ($stat->status == 'active')
                                        <a href="{{ route('pumper.close.form', $stat->assignment_id) }}"
                                            class="btn btn-danger btn-sm shadow-sm d-flex align-items-center">
                                            <i class="fas fa-door-closed me-1"></i> Close Duty
                                        </a>

                                        {{-- ACTION 2: SETTLE (Only if Pending AND Amount > 0) --}}
                                    @elseif($stat->status == 'pending_settlement' && $pendingAmount > 0)
                                        <button type="button"
                                            class="btn btn-warning btn-sm d-flex align-items-center shadow-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#settle-modal{{ $stat->assignment_id }}">
                                            <i class="fas fa-coins me-1"></i> Settle
                                        </button>

                                        {{-- Include the Modal partial --}}
                                        @include('admin.petro.pumper-management.modals.settle-modal', [
                                            'stat' => $stat,
                                            'pending' => $pendingAmount,
                                        ])
                                    @endif

                                    {{-- ACTION 3: REPORT (Available for any Closed or Pending Duty) --}}
                                    @if ($stat->status != 'active')
                                        <a href="{{ route('pumper.report', $stat->assignment_id) }}"
                                            class="btn btn-primary btn-sm d-flex align-items-center shadow-sm">
                                            <i class="fas fa-file-invoice me-1"></i> Report
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No pumpers assigned to this shift.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
