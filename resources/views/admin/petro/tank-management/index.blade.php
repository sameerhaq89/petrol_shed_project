@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    {{-- Fuel Tank Overview Section --}}
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-gas-station"></i>
            </span> Fuel Tank Overview
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <button class="btn btn-sm btn-gradient-primary" id="recordDipBtn">
                        <i class="mdi mdi-plus"></i> Record New Dip
                    </button>
                </li>
            </ul>
        </nav>
    </div>

    <div class="row">
        @if(isset($tanks) && count($tanks) > 0)
        @foreach($tanks as $tank)
        @include('admin.petro.tank-management.widget.tank_overview', $tank)
        @endforeach
        @else
        <div class="col-12">
            <div class="alert alert-info">
                <i class="mdi mdi-information"></i> No tank data available. Please add tanks to the system.
            </div>
        </div>
        @endif
    </div>

    {{-- Fuel Pump Distribution Section --}}
    <div class="page-header mt-5">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-success text-white me-2">
                <i class="mdi mdi-water-pump"></i>
            </span> Fuel Pump Distribution
        </h3>
    </div>

    <div class="row">
        @if(isset($pumps) && count($pumps) > 0)
        @foreach($pumps as $pump)
        @include('admin.petro.tank-management.widget.pump_distribution', $pump)
        @endforeach
        @else
        <div class="col-12">
            <div class="alert alert-info">
                <i class="mdi mdi-information"></i> No pump data available. Please add pumps to the system.
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Record New Dip Button Handler
    document.getElementById('recordDipBtn')?.addEventListener('click', function() {
        // TODO: Implement modal or redirect to dip recording page
        alert('Record New Dip functionality will be implemented here');
    });

    // Auto-refresh tank data every 5 minutes (optional)
    setInterval(function() {
        location.reload();
    }, 300000);
</script>
@endsection