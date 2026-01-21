<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title mb-0">Live Pumper Reconciliation</h4>
            <span class="badge badge-outline-primary">Shift: {{ $activeShift->shift_number ?? 'N/A' }}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Pumper</th>
                        <th class="text-end">Opening Cash</th> {{-- New Column --}}
                        <th class="text-end">Meter Sales (LKR)</th>
                        <th class="text-end">Expected Total</th> {{-- Renamed for clarity --}}
                        <th class="text-end">Cash Drops (LKR)</th>
                        <th class="text-center">Variance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pumperStats as $stat)
                        @php
                            // 1. Get Sales for this specific pumper in this shift
                            $sales = \App\Models\Sale::where('shift_id', $activeShift->id)
                                ->where('pump_id', $stat->pump_id)
                                ->where('created_by', $stat->pumper_id)
                                ->sum('amount');

                            // 2. Get TOTAL Cash Drops (Mid-shift + Final Handover)
                            $totalDrops = \App\Models\CashDrop::where('shift_id', $activeShift->id)
                                ->where('user_id', $stat->pumper_id)
                                ->sum('amount');
                            $assignmentModel = \App\Models\PumpOperatorAssignment::find($stat->assignment_id);
                            // 3. Opening Cash (The float/change money)
                            $openingCash = $assignmentModel->opening_cash ?? 0;

                            // 4. Expected Total = Sales + Opening Cash
                            $expectedTotal = $sales + $openingCash;

                            // 5. Variance = Received - Expected
                            $variance = $totalDrops - $expectedTotal;
                        @endphp
                        <tr>
                            <td>
                                <span class="font-weight-bold">{{ $stat->pumper_name }}</span><br>
                                <small class="text-muted">{{ $stat->pump_name }}</small>
                            </td>
                            {{-- Display Opening Cash --}}
                            <td class="text-end text-primary font-weight-bold">
                                {{ number_format($openingCash, 2) }}
                            </td>
                            <td class="text-end text-success font-weight-bold">
                                {{ number_format($sales, 2) }}
                            </td>
                            {{-- Total the pumper must account for --}}
                            <td class="text-end font-weight-bold text-dark">
                                {{ number_format($expectedTotal, 2) }}
                            </td>
                            <td class="text-end text-danger">
                                {{ number_format($totalDrops, 2) }}
                            </td>
                            <td class="text-center">
                                @if ($variance < 0)
                                    <span class="badge badge-danger px-3">Rs. {{ number_format($variance, 2) }}
                                        (Short)
                                    </span>
                                @elseif($variance > 0)
                                    <span class="badge badge-success px-3">Rs. {{ number_format($variance, 2) }}
                                        (Extra)</span>
                                @else
                                    <span class="badge badge-info px-3">Balanced</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
