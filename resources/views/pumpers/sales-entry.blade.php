@extends('admin.layouts.app')

@section('content')
    <style>
        .payment-method-card {
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            cursor: pointer;
            border-radius: 10px;
        }

        .payment-method-card:hover {
            border-color: #b8daff;
            background-color: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .payment-method-card input[type="radio"]:checked+.payment-content {
            color: #007bff;
        }

        .payment-method-card:has(input[type="radio"]:checked) {
            border-color: #007bff;
            background-color: #e7f3ff;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
        }
    </style>
    <div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
        @include('admin.command.widgets.page-header', $pageHeader)

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card mx-auto">
                <div class="card border-primary shadow-sm mt-2" style="border-top: 3px solid;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h3 class="t-text text-primary font-weight-bold mb-0">Sales Entry</h3>
                                <p class="text-muted mb-0">Pump: <strong>{{ $pump->pump_name }}</strong></p>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-primary p-2" style="font-size: 1rem;">
                                    {{ $fuelType->name }}
                                </span>
                                <h4 class="mt-2 text-dark font-weight-bold">
                                    Rs. {{ number_format($currentPrice->selling_price, 2) }} <span
                                        style="font-size: 0.8rem; color: #888;">/
                                        L</span>
                                </h4>
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success mb-4" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger mb-4" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('pumper.sales.store') }}" method="POST" id="salesForm">
                            @csrf
                            <input type="hidden" name="pump_id" value="{{ $pump->id }}">
                            <input type="hidden" name="price_id" value="{{ $currentPrice->id }}">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label class="h6 text-dark font-weight-bold mb-3">
                                            Closing Meter Reading
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-right-0">
                                                    Start: {{ number_format($pump->current_reading, 2) }}
                                                </span>
                                            </div>
                                            <input type="number" name="meter_reading" id="meter_reading"
                                                class="form-control form-control-sm" placeholder="Auto-calculated"
                                                step="0.01" min="{{ $pump->current_reading }}" readonly>
                                        </div>
                                        <small class="text-muted">Opening: {{ $pump->current_reading }}</small>
                                        @error('meter_reading')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="volume" class="h6 text-dark font-weight-bold mb-3">
                                            Volume Sold (Liters)
                                        </label>
                                        <input type="text" id="volume" class="form-control form-control-sm bg-light"
                                            value="0.00" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-4">
                                        <label for="amount" class="h6 text-dark font-weight-bold mb-3">
                                            Amount to Drop (Rs.)
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-light border-2" style="color: #28a745;">
                                                    Rs.
                                                </span>
                                            </div>
                                            <input type="number" name="amount" id="amount"
                                                class="form-control form-control-sm border-2" placeholder="e.g. 5,000"
                                                step="0.01" min="1" required autofocus>
                                        </div>
                                        @error('amount')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="h6 text-dark font-weight-bold mb-3">
                                    Payment Method
                                </label>
                                <div class="row">
                                    <div class="col-4">
                                        <label class="card payment-method-card p-4 text-center mb-0 shadow-sm">
                                            <input type="radio" name="payment_method" value="card" class="d-none">
                                            <div class="payment-content">
                                                <i class="mdi mdi-credit-card text-primary" style="font-size: 3rem;"></i>
                                                <div class="mt-3 font-weight-bold" style="font-size: 1.1rem;">Card</div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="card payment-method-card p-4 text-center mb-0 shadow-sm">
                                            <input type="radio" name="payment_method" value="cash" class="d-none">
                                            <div class="payment-content">
                                                <i class="mdi mdi-cash text-success" style="font-size: 3rem;"></i>
                                                <div class="mt-3 font-weight-bold" style="font-size: 1.1rem;">Cash</div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="card payment-method-card p-4 text-center mb-0 shadow-sm">
                                            <input type="radio" name="payment_method" value="qr" class="d-none">
                                            <div class="payment-content">
                                                <i class="mdi mdi-qrcode-scan text-warning" style="font-size: 3rem;"></i>
                                                <div class="mt-3 font-weight-bold" style="font-size: 1.1rem;">QR</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12 d-flex justify-content-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-gradient-secondary">
                                        <i class="mdi mdi-close-circle"></i> CLOSE
                                    </a>
                                    <button type="submit" class="btn btn-gradient-primary me-2">
                                        <i class="mdi mdi-check-circle"></i> SAVE SALE
                                    </button>
                                </div>
                                {{-- <div class="col-6">
                                    <button type="submit"
                                        class="btn btn-primary btn-block btn-lg py-3 font-weight-bold shadow"
                                        style="font-size: 1.1rem; border-radius: 8px;">
                                        <i class="mdi mdi-check-circle"></i> SAVE SALE
                                    </button>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row layout-top-spacing justify-content-center">
            <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-content-area br-6 p-4 border-primary shadow-sm" style="border-top: 3px solid;">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="t-text text-primary font-weight-bold mb-0">Sales Entry</h3>
                            <p class="text-muted mb-0">Pump: <strong>{{ $pump->pump_name }}</strong></p>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-primary p-2" style="font-size: 1rem;">
                                {{ $fuelType->name }}
                            </span>
                            <h4 class="mt-2 text-dark font-weight-bold">
                                Rs. {{ number_format($currentPrice->selling_price, 2) }} <span
                                    style="font-size: 0.8rem; color: #888;">/
                                    L</span>
                            </h4>
                        </div>
                    </div>

                    @if (session('success'))
                    <div class="alert alert-success mb-4" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger mb-4" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('pumper.sales.store') }}" method="POST" id="salesForm">
                        @csrf
                        <input type="hidden" name="pump_id" value="{{ $pump->id }}">
                        <input type="hidden" name="price_id" value="{{ $currentPrice->id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="h6 text-dark font-weight-bold mb-3">
                                        <i class="mdi mdi-gauge text-primary"></i> Current Meter Reading
                                    </label>
                                    <input type="number" name="meter_reading" class="form-control form-control-lg"
                                        placeholder="e.g. 100,550" step="0.01" min="0"
                                        style="font-size: 1.3rem; height: 60px; border: 2px solid #e9ecef; border-radius: 8px;">
                                    @error('meter_reading')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="volume" class="h6 text-dark font-weight-bold mb-3">
                                        <i class="mdi mdi-gas-station text-info"></i> Volume Sold (Liters)
                                    </label>
                                    <input type="text" id="volume" class="form-control form-control-lg bg-light"
                                        value="0.00" readonly
                                        style="font-size: 1.3rem; height: 60px; font-weight: bold; color: #555; border: 2px solid #e9ecef; border-radius: 8px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="amount" class="h6 text-dark font-weight-bold mb-3">
                                <i class="mdi mdi-cash-multiple text-success"></i> Amount to Drop (Rs.)
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-2"
                                        style="font-size: 1.5rem; font-weight: bold; color: #28a745; border-radius: 8px 0 0 8px; height: 70px;">
                                        Rs.
                                    </span>
                                </div>
                                <input type="number" name="amount" id="amount" class="form-control form-control-lg border-2"
                                    placeholder="e.g. 5,000" step="0.01" min="1" required autofocus
                                    style="font-size: 1.8rem; height: 70px; font-weight: bold; color: #333; border-left: none; border-radius: 0 8px 8px 0;">
                            </div>
                            @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label class="h6 text-dark font-weight-bold mb-3">
                                <i class="mdi mdi-credit-card-outline"></i> Payment Method
                            </label>
                            <div class="row">
                                <div class="col-4">
                                    <label class="card payment-method-card p-4 text-center mb-0 shadow-sm">
                                        <input type="radio" name="payment_method" value="card" class="d-none">
                                        <div class="payment-content">
                                            <i class="mdi mdi-credit-card text-primary" style="font-size: 3rem;"></i>
                                            <div class="mt-3 font-weight-bold" style="font-size: 1.1rem;">Card</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class="card payment-method-card p-4 text-center mb-0 shadow-sm">
                                        <input type="radio" name="payment_method" value="cash" class="d-none">
                                        <div class="payment-content">
                                            <i class="mdi mdi-cash text-success" style="font-size: 3rem;"></i>
                                            <div class="mt-3 font-weight-bold" style="font-size: 1.1rem;">Cash</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label class="card payment-method-card p-4 text-center mb-0 shadow-sm">
                                        <input type="radio" name="payment_method" value="qr" class="d-none">
                                        <div class="payment-content">
                                            <i class="mdi mdi-qrcode-scan text-warning" style="font-size: 3rem;"></i>
                                            <div class="mt-3 font-weight-bold" style="font-size: 1.1rem;">QR</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-6">
                                <a href="{{ url()->previous() }}"
                                    class="btn btn-secondary btn-block btn-lg py-3 font-weight-bold shadow"
                                    style="font-size: 1.1rem; border-radius: 8px;">
                                    <i class="mdi mdi-close-circle"></i> CLOSE
                                </a>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary btn-block btn-lg py-3 font-weight-bold shadow"
                                    style="font-size: 1.1rem; border-radius: 8px;">
                                    <i class="mdi mdi-check-circle"></i> SAVE SALE
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const amountInput = document.getElementById('amount');
            const volumeInput = document.getElementById('volume');
            const meterInput = document.getElementById('meter_reading');

            const price = {{ $currentPrice->selling_price }};
            const openingMeter = {{ $pump->current_reading }};

            amountInput.addEventListener('input', function () {
                const amount = parseFloat(this.value);
                if (!isNaN(amount) && amount > 0) {
                    // Calculate Volume
                    const volume = amount / price;
                    volumeInput.value = volume.toFixed(2);

                    // Calculate Closing Meter
                    const closingMeter = openingMeter + volume;
                    meterInput.value = closingMeter.toFixed(2);
                } else {
                    volumeInput.value = '0.00';
                    meterInput.value = '';
                }
            });

            // Prevent double submission
            document.getElementById('salesForm').addEventListener('submit', function () {
                const btn = this.querySelector('button[type="submit"]');
                btn.disabled = true;
                btn.innerText = 'Processing...';
            });
        });
    </script>
@endsection