@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        @include('admin.command.widgets.page-header', $pageHeader)

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 print-card">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0 text-dark">Shift Settlement Summary</h4>
                                <p class="text-muted mb-0">Shift: {{ $assignment->shift->shift_number }}</p>
                            </div>
                            <div class="text-end">
                                <h5 class="mb-0 text-primary">{{ $assignment->pumper->name }}</h5>
                                <small>{{ \Carbon\Carbon::parse($assignment->created_at)->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- 1. Sales Details --}}
                        <h5 class="section-title"><i class="mdi mdi-gas-station me-1"></i> Sales Activity</h5>
                        <table class="table table-bordered mb-4">
                            <thead class="bg-light">
                                <tr>
                                    <th>Item</th>
                                    <th class="text-end">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Assigned Pump</td>
                                    <td class="text-end text-dark font-weight-bold">{{ $assignment->pump->pump_name }}</td>
                                </tr>
                                <tr>
                                    <td>Opening Reading</td>
                                    <td class="text-end">{{ number_format($assignment->opening_reading, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Closing Reading</td>
                                    <td class="text-end">{{ number_format($assignment->closing_reading, 2) }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <td><strong>Total Volume Sold</strong></td>
                                    <td class="text-end font-weight-bold">
                                        {{ number_format($assignment->closing_reading - $assignment->opening_reading, 2) }}
                                        L</td>
                                </tr>
                                <tr>
                                    <td>Price per Liter</td>
                                    <td class="text-end">{{ number_format($currentPrice, 2) }}</td>
                                </tr>
                                <tr class="bg-gradient-primary text-white">
                                    <td><strong>Total Expected Sales</strong></td>
                                    <td class="text-end font-weight-bold">Rs.
                                        {{ number_format(($assignment->closing_reading - $assignment->opening_reading) * $currentPrice, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- 2. Cash Reconciliation --}}
                        <h5 class="section-title mt-4"><i class="mdi mdi-cash-multiple me-1"></i> Cash Reconciliation</h5>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>(+) Opening Float</td>
                                    <td class="text-end text-muted">{{ number_format($assignment->opening_cash, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>(+) Sales Income</td>
                                    <td class="text-end">
                                        {{ number_format(($assignment->closing_reading - $assignment->opening_reading) * $currentPrice, 2) }}
                                    </td>
                                </tr>
                                <tr class="font-weight-bold">
                                    <td>(=) Total Accountability</td>
                                    <td class="text-end">Rs.
                                        {{ number_format((($assignment->closing_reading - $assignment->opening_reading) * $currentPrice) + $assignment->opening_cash, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2"></td>
                                </tr>

                                <tr>
                                    <td>(-) Cash Drops (Mid-shift)</td>
                                    <td class="text-end text-danger">{{ number_format($totalDrops, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>(-) Final Handover</td>
                                    <td class="text-end text-danger">
                                        {{ number_format($assignment->closing_cash_received, 2) }}</td>
                                </tr>

                                @php
                                    $accountable = (($assignment->closing_reading - $assignment->opening_reading) * $currentPrice) + $assignment->opening_cash;
                                    $received = $totalDrops + $assignment->closing_cash_received;
                                    $variance = $received - $accountable;
                                @endphp

                                <tr class="bg-light border-top">
                                    <td class="font-weight-bold">Net Variance</td>
                                    <td class="text-end font-weight-bold">
                                        @if($variance == 0)
                                            <span class="badge badge-success">Balanced</span>
                                        @elseif($variance > 0)
                                            <span class="text-success">+{{ number_format($variance, 2) }} (Excess)</span>
                                        @else
                                            <span class="text-danger">{{ number_format($variance, 2) }} (Short)</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if($variance < 0)
                            <div class="alert alert-danger mt-3">
                                <i class="mdi mdi-alert-circle"></i> Shortage of <strong>Rs.
                                    {{ number_format(abs($variance), 2) }}</strong> detected.
                                @if($assignment->status != 'completed')
                                    Please settle this amount.
                                @else
                                    This amount has been logged to the ledger.
                                @endif
                            </div>
                        @endif

                    </div>

                    <div class="card-footer bg-white text-end">
                        <button class="btn btn-secondary" onclick="window.history.back()">Back</button>
                        <button class="btn btn-primary" onclick="window.print()">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {

            .noprint,
            .navbar,
            .sidebar,
            .footer {
                display: none !important;
            }

            .content-wrapper {
                margin: 0;
                padding: 0;
            }

            .print-card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            .card-header,
            .card-footer {
                background: #fff !important;
            }
        }
    </style>
@endsection