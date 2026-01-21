<link rel="stylesheet" href="{{ asset('assets/css/tank-overview.css') }}">

<div class="col-xl-3 col-md-6 col-sm-6 mb-4">
    <div class="card tank-card h-100">
        <div class="card-body text-center position-relative">
            
            {{-- ACTION MENU (Added to your visual) --}}
            <div class="dropdown position-absolute" style="top: 10px; right: 10px; z-index: 10;">
                <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                    <i class="mdi mdi-dots-horizontal text-muted" style="font-size: 20px;"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('tanks.edit', $id) }}">
                        <i class="mdi mdi-pencil text-primary me-2"></i> Edit
                    </a>
                    <a class="dropdown-item" href="{{ route('tanks.show', $id) }}">
                        <i class="mdi mdi-eye text-info me-2"></i> Details
                    </a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#adjustStockModal{{ $id }}">
                        <i class="mdi mdi-water text-success me-2"></i> Dip / Refill
                    </a>
                </div>
            </div>

            {{-- Tank Visual Container --}}
            <div class="tank-container mb-3">
                <div class="tank-visual">
                    {{-- Note: Added data-color attribute for CSS coloring --}}
                    <div class="tank-liquid" style="height: {{ $percentage ?? 0 }}%;" data-color="{{ $color ?? 'blue' }}">
                        <div class="tank-wave"></div>
                        <div class="tank-wave wave-2"></div>
                    </div>
                    
                    {{-- Content floats above liquid --}}
                    <div class="position-absolute w-100" style="bottom: 10px; z-index: 5;">
                        <div class="percentage-display text-white" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                            {{ $percentage ?? 0 }}%
                        </div>
                        @if(isset($alertStatus) && $alertStatus == 'low-stock')
                            <div class="alert-text">ALERT: LOW STOCK</div>
                        @endif
                    </div>

                    <div class="tank-nozzle"></div>
                </div>
            </div>

            {{-- Tank Information --}}
            <div class="tank-info">
                <h5 class="tank-title mb-2 text-dark font-weight-bold">{{ $tankName ?? 'Unknown Tank' }}</h5>
                <p class="tank-capacity mb-1">
                    <small class="text-muted">Capacity: {{ $capacity ?? 'N/A' }}</small>
                </p>
                <p class="mb-1">
                    <small class="text-muted">Current: {{ $current ?? '0' }}</small>
                </p>
                @if(isset($lastDip))
                    <p class="tank-last-dip mb-0">
                        <small class="text-muted" style="font-size: 0.75rem;">Last Dip: {{ $lastDip }}</small>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- INCLUDE THE MODAL (This fixes the "View not found" error) --}}
@include('admin.petro.tank-management.widget.adjust-stock-modal')