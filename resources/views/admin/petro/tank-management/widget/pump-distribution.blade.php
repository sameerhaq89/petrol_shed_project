<link rel="stylesheet" href="{{ asset('assets/css/pump-distribution.css') }}">

{{-- Single Pump Distribution Card --}}
<div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-4 px-3">
    <div class="card pump-card h-100">
        <div class="card-body p-3">
            {{-- Pump Icon & Status --}}
            <div class="pump-header d-flex mb-3">
                <div class="pump-icon-wrapper">
                    <i class="mdi mdi-gas-station pump-icon"></i>
                    @if(isset($statusIcon))
                    <span class="status-badge status-{{ $statusIcon }}">
                        @if($statusIcon == 'error')
                        <i class="mdi mdi-close-circle"></i>
                        @elseif($statusIcon == 'warning')
                        <i class="mdi mdi-alert-circle"></i>
                        @elseif($statusIcon == 'maintenance')
                        <i class="mdi mdi-wrench"></i>
                        @endif
                    </span>
                    @endif
                </div>
            </div>

            {{-- Pump Name & Number --}}
            <div class="pump-info mb-3">
                <h6 class="pump-number d-flex align-items-center mb-2">
                    {{ $pumpName ?? 'Pump 01' }}
                    @if(isset($isActive) && $isActive)
                    <span class="status-dot ms-2"></span>
                    <i class="mdi mdi-chevron-right ms-1 text-muted"></i>
                    @endif
                </h6>
                <p class="pump-type mb-2">{{ $pumpType ?? 'Tump 01 (Petrol 95)' }}</p>
                <p class="pump-status mb-2">
                    <small class="text-muted">{{ $linkStatus ?? 'Linked Active' }}</small>
                </p>
                <p class="pump-meter mb-3">
                    <small class="text-muted">Currmter: <strong>{{ $currentMeter ?? '128450.20 L' }}</strong></small>
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="pump-actions">
                @if(isset($actionButton))
                @if($actionButton['type'] == 'primary')
                <button class="btn btn-sm btn-primary w-100">
                    <i class="mdi mdi-{{ $actionButton['icon'] ?? 'pencil' }}"></i>
                    {{ $actionButton['label'] }}
                </button>
                @else
                <button class="btn btn-sm btn-outline-secondary w-100">
                    <i class="mdi mdi-{{ $actionButton['icon'] ?? 'file-document' }}"></i>
                    {{ $actionButton['label'] }}
                </button>
                @endif
                @else
                <button class="btn btn-sm btn-outline-secondary w-100">
                    <i class="mdi mdi-file-document"></i>
                    Update Expenses
                </button>
                @endif
            </div>
        </div>
    </div>
</div>
