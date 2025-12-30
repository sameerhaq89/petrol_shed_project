<link rel="stylesheet" href="{{ asset('assets/css/tank-overview.css') }}">

{{-- Single Tank Overview Widget Card --}}
<div class="col-xl-3 col-md-6 col-sm-6 mb-4">
    <div class="card tank-card h-100">
        <div class="card-body text-center position-relative">
            {{-- Tank Visual Container --}}
            <div class="tank-container mb-3">
                <div class="tank-visual">
                    <div class="tank-liquid" style="height: {{ $percentage ?? 0 }}%;" data-color="{{ $color ?? 'blue' }}">
                        <div class="tank-wave"></div>
                        <div class="tank-wave wave-2"></div>
                        <div class="liquid-content">
                            <div class="percentage-display">{{ $percentage ?? 0 }}%</div>
                            @if(isset($alertStatus) && $alertStatus == 'low-stock')
                            <div class="alert-text">ALERT: LOW STOCK</div>
                            @endif
                        </div>
                    </div>
                    <div class="tank-nozzle"></div>
                </div>
            </div>

            {{-- Tank Information --}}
            <div class="tank-info">
                <h5 class="tank-title mb-2">{{ $tankName ?? 'Unknown Tank' }}</h5>
                <p class="tank-capacity mb-1">
                    <small class="text-muted">Capacity: {{ $capacity ?? 'N/A' }}</small>
                </p>
                @if(isset($lastDip))
                <p class="tank-last-dip mb-0">
                    <small class="text-muted">Last Dip: {{ $lastDip }}</small>
                </p>
                @else
                <p class="tank-capacity mb-1">
                    <small class="text-danger">{{ isset($alertStatus) && $alertStatus == 'low-stock' ? 'ALERT: LOW STOCK' : '' }}</small>
                </p>
                @endif
            </div>
        </div>
    </div>
</div>