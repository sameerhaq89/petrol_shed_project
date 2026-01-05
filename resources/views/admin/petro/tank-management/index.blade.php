@extends('admin.layouts.app')
@section('content')
<style>
    .command-row-gap {
        --bs-gutter-x: 12px !important;
    }
</style>
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">

    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="row mt-3 command-row-gap">
        @if(isset($tanks) && count($tanks) > 0)
        @foreach($tanks as $tank)
        @include('admin.petro.tank-management.widget.tank-overview', $tank)
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
    <div class="page-header mt-2">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-water-pump"></i>
            </span> Fuel Pump Distribution
        </h3>
    </div>

    <div class="row">
        @if(isset($pumps) && count($pumps) > 0)
        @foreach($pumps as $pump)
        @include('admin.petro.tank-management.widget.pump-distribution', $pump)
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
<x-add-meter-sale />
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
