@extends('admin.layouts.app')

@section('content')
    <style>
        .payment-method-card {
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
        }

        .payment-method-card:hover {
            border-color: #b8daff;
            background-color: #f8f9fa;
        }

        .payment-method-card input[type="radio"]:checked+.payment-content {
            color: #007bff;
        }

        .payment-method-card:has(input[type="radio"]:checked) {
            border-color: #007bff;
            background-color: #e7f3ff;
        }
    </style>
    <div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
        {{-- <div class="row" style="--bs-gutter-x: 20px !important;">
            <div class="col-md-6">
                <button class="btn btn-gradient-success btn-block w-100" data-bs-toggle="modal"
                    data-bs-target="#dropCashModal">
                    <i class="mdi mdi-cash-multiple"></i> DROP CASH
                </button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-gradient-danger btn-block w-100" data-bs-toggle="modal"
                    data-bs-target="#closeDutyModal">
                    <i class="mdi mdi-logout"></i> CLOSE DUTY
                </button>
            </div>
        </div> --}}

        <div class="row" style="--bs-gutter-x: 20px !important;margin-top: 0.2rem;">
            <!-- Left Column: Duty Card -->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                    <div class="card-body">
                        <h4 class="card-title">Current Session Duty</h4>
                        <div class="card bg-gradient-success card-img-holder text-white mb-3">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                    alt="circle-image" />
                                <h4 class="font-weight-normal mb-3"><i class="mdi mdi-gas-station mdi-24px float-left"></i>
                                    ON DUTY <span class="badge badge-gradient-primary"><strong>{{ Auth::user()->name }}
                                            👋</strong></span></h4>
                                <div class="mb-2">
                                    <strong>Assigned Pump:</strong> {{ $assignment->pump->pump_name ?? 'Unknown Pump' }}
                                </div>
                                <div class="mb-3">
                                    <strong>Opening Float:</strong> Rs. {{ number_format($assignment->opening_cash, 2) }}
                                </div>
                                <p class="mb-0 opacity-75">Started: {{ $assignment->created_at->format('h:i A') }} | Start
                                    Meter: {{ number_format($assignment->opening_reading, 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Finance Card -->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                    <div class="card-body">
                        <h4 class="card-title">Current Session Finance</h4>
                        <div class="card bg-gradient-info card-img-holder text-white mt-3">
                            <div class="card-body text-center">
                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                    alt="circle-image" />
                                <p class="font-weight-normal mb-2">ESTIMATED CASH IN HAND:</p>
                                <h2 class="mb-4">Rs. {{ number_format($cashInHand, 2) }}</h2>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="border-right pr-2">
                                            <p class="mb-1 font-weight-normal">My Sales:</p>
                                            <h4 class="mb-0">Rs. {{ number_format($totalSales, 2) }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="pl-2">
                                            <p class="mb-1 font-weight-normal">Total Dropped:</p>
                                            <h4 class="mb-0">Rs. {{ number_format($totalDropped, 2) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="--bs-gutter-x: 20px !important;margin-top: -1.3rem;">
            <!-- Today's Drops -->
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                    <div class="card-body">
                        <h4 class="card-title">Today's Drops</h4>
                        <div class="table-responsive mt-3">
                            <table class="table table-borderless">
                                <tbody>
                                    @forelse($recentDrops as $drop)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="font-weight-bold">Rs.
                                                        {{ number_format($drop->amount, 2) }}</span>
                                                    <span
                                                        class="text-muted small">{{ $drop->created_at->format('h:i A') }}</span>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <label
                                                    class="badge badge-{{ $drop->status == 'verified' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($drop->status) }}
                                                </label>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No drops yet today.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->

    <!-- Drop Cash Modal -->
    <div class="modal fade" id="dropCashModal" tabindex="-1" role="dialog" aria-labelledby="dropCashModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-success text-white">
                    <h5 class="modal-title" id="dropCashModalLabel"><i class="mdi mdi-cash-multiple"></i> Drop Cash</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Meter Reading</label>
                            <input type="number" name="current-meter" class="form-control" placeholder="Enter meter"
                                required min="1" step="100,550">
                        </div>
                        <div class="form-group">
                            <label>Volume Sold (Liters)</label>
                            <input type="number" name="liter" class="form-control" placeholder="Enter liters sold" required
                                min="1" step="100.00">
                        </div>
                        <div class="form-group">
                            <label>Amount to Drop (Rs.)</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter amount" required
                                min="1" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            <div class="row mt-2">
                                <div class="col-4">
                                    <label class="card payment-method-card p-3 text-center mb-0" style="cursor: pointer;">
                                        <input type="radio" name="payment_method" value="card" class="d-none" required>
                                        <div class="payment-content">
                                            <i class="mdi mdi-credit-card text-primary" style="font-size: 2rem;"></i>
                                            <div class="mt-2 font-weight-bold">Card</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class="card payment-method-card p-3 text-center mb-0" style="cursor: pointer;">
                                        <input type="radio" name="payment_method" value="cash" class="d-none" required>
                                        <div class="payment-content">
                                            <i class="mdi mdi-cash text-success" style="font-size: 2rem;"></i>
                                            <div class="mt-2 font-weight-bold">Cash</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class="card payment-method-card p-3 text-center mb-0" style="cursor: pointer;">
                                        <input type="radio" name="payment_method" value="qr" class="d-none" required>
                                        <div class="payment-content">
                                            <i class="mdi mdi-qrcode-scan text-warning" style="font-size: 2rem;"></i>
                                            <div class="mt-2 font-weight-bold">QR</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Close Duty Modal -->
    <div class="modal fade" id="closeDutyModal" tabindex="-1" role="dialog" aria-labelledby="closeDutyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-danger text-white">
                    <h5 class="modal-title" id="closeDutyModalLabel"><i class="mdi mdi-logout"></i> Close Duty</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>End Meter Reading</label>
                            <input type="number" name="end_meter" class="form-control" placeholder="Enter meter reading"
                                required min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Closing Cash in Hand (Rs.)</label>
                            <input type="number" name="closing_cash" class="form-control" placeholder="Enter cash amount"
                                required min="0" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Remarks (Optional)</label>
                            <textarea name="remarks" class="form-control" rows="3"
                                placeholder="Any remarks about the shift..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-danger">Close Duty</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
