@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper" style="padding: 1.5rem 2.25rem !important;">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            @include('admin.command.widgets.page-header', $pageHeader)
            <button onclick="window.print()" class="btn btn-inverse-primary btn-icon-text shadow-sm">
                <i class="mdi mdi-printer me-2"></i> Print Settlement
            </button>
        </div>

        <div class="row">
            {{-- LEFT COLUMN: STATUS CARD --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body text-center py-4">
                        <h5 class="text-muted mb-3">Net Variance</h5>
                        <h1 class="display-4 font-weight-bold {{ $variance < 0 ? 'text-danger' : 'text-success' }}">
                            Rs. {{ number_format($variance, 2) }}
                        </h1>
                        <div class="mt-3">
                            @if ($variance < 0)
                                <span class="badge badge-danger px-4 py-2 h5">SHORTAGE</span>
                            @elseif($variance > 0)
                                <span class="badge badge-success px-4 py-2 h5">EXCESS</span>
                            @else
                                <span class="badge badge-info px-4 py-2 h5">BALANCED</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white font-weight-bold">Assignment Info</div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <tr>
                                <td class="text-muted ps-4">Operator:</td>
                                <td class="text-end pe-4 font-weight-bold">{{ $assignment->pumper->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-4">Pump/Nozzle:</td>
                                <td class="text-end pe-4">{{ $assignment->pump->pump_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-4">Duty Started:</td>
                                <td class="text-end pe-4">
                                    {{ \Carbon\Carbon::parse($assignment->start_time)->format('M d, h:i A') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-4">Duty Ended:</td>
                                <td class="text-end pe-4">
                                    {{ \Carbon\Carbon::parse($assignment->end_time)->format('M d, h:i A') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: DETAILED AUDIT --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Settlement Reconciliation</h4>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Financial Description</th>
                                        <th class="text-end">Amount (LKR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>Total Meter Sales</strong><br>
                                            <small class="text-muted">Volume: {{ number_format($totalVolume, 2) }}
                                                Liters</small>
                                        </td>
                                        <td class="text-end text-success font-weight-bold">+
                                            {{ number_format($totalSalesAmount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Opening Cash (Change Provided)</strong></td>
                                        <td class="text-end text-success font-weight-bold">+
                                            {{ number_format($openingCash, 2) }}</td>
                                    </tr>
                                    <tr class="table-info">
                                        <td class="font-weight-bold">Total Expected from Pumper</td>
                                        <td class="text-end font-weight-bold h5 mb-0">Rs.
                                            {{ number_format($expectedTotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Cash Drops (During Shift)</td>
                                        <td class="text-end text-danger">- {{ number_format($midShiftDrops, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Final Cash Handover (At Closing)</td>
                                        <td class="text-end text-danger">-
                                            {{ number_format($assignment->closing_cash_received ?? 0, 2) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-light">
                                    @if ($settlementDrop)
                                        <tr>
                                            <td>
                                                <strong>Late Shortage Settlement</strong><br>
                                                <small class="text-muted">
                                                    Paid on:
                                                    {{ \Carbon\Carbon::parse($settlementDrop->dropped_at)->format('M d, Y h:i A') }}
                                                </small>
                                            </td>
                                            <td class="text-end text-success">+
                                                {{ number_format($settlementDrop->amount, 2) }}</td>
                                        </tr>
                                    @endif

                                    <tr class="h4">
                                        <td class="font-weight-bold">Final Variance</td>
                                        <td
                                            class="text-end font-weight-bold {{ $variance < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($variance, 2) }}
                                        </td>
                                    </tr>
                                    {{-- In your Reconciliation Table --}}

                                    {{-- Updated Variance Badge --}}
                                    <div class="alert {{ $variance == 0 ? 'alert-success' : 'alert-danger' }}">
                                        <h4 class="mb-0">
                                            Status: {{ $variance == 0 ? 'FULLY SETTLED' : 'PARTIALLY PAID' }}
                                        </h4>
                                    </div>
                                </tfoot>
                            </table>
                        </div>

                        <div class="alert alert-secondary mt-4 border-0 small">
                            <i class="mdi mdi-information-outline me-1"></i>
                            This report verifies that the physical cash collected matches the digital meter readings
                            recorded for this duty assignment.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
