@extends('admin.layouts.app')

@section('content')
    <div class="row layout-top-spacing justify-content-center">

        <div class="col-xl-6 col-lg-8 col-md-10 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-content-area br-6 p-4 shadow-sm" style="background: #fff; border-radius: 12px;">

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

                @if(session('success'))
                    <div class="alert alert-success mb-4" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mb-4" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('pumper.sales.store') }}" method="POST" id="salesForm">
                    @csrf
                    <input type="hidden" name="pump_id" value="{{ $pump->id }}">
                    <input type="hidden" name="price_id" value="{{ $currentPrice->id }}">

                    <div class="form-group mb-4">
                        <label for="amount" class="h5 text-dark">Enter Amount (Rs.)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 h2 text-primary font-weight-bold">Rs.</span>
                            </div>
                            <input type="number" name="amount" id="amount" class="form-control form-control-lg border-2"
                                placeholder="e.g. 5000" step="0.01" min="1" required autofocus
                                style="font-size: 2rem; height: 80px; font-weight: bold; color: #333;">
                        </div>
                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="volume" class="h6 text-muted">Calculated Volume (Liters)</label>
                        <input type="text" id="volume" class="form-control form-control-lg bg-light" value="0.00" readonly
                            style="font-size: 1.5rem; height: 60px; font-weight: bold; color: #555;">
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-block btn-lg py-3 font-weight-bold shadow"
                            style="font-size: 1.2rem; border-radius: 8px;">
                            SAVE SALE
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const amountInput = document.getElementById('amount');
            const volumeInput = document.getElementById('volume');
            const price = {{ $currentPrice->selling_price }};

            amountInput.addEventListener('input', function () {
                const amount = parseFloat(this.value);
                if (!isNaN(amount) && amount > 0) {
                    const volume = amount / price;
                    volumeInput.value = volume.toFixed(2);
                } else {
                    volumeInput.value = '0.00';
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