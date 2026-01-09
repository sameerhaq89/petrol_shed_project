@extends('admin.layouts.app')
<link rel="stylesheet" href="{{ asset('assets/css/data-table.css') }}">
@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
    @include('admin.command.widgets.page-header', $pageHeader)
    {{-- 1. Module Tabs --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="btn-group w-100 shadow-sm d-flex flex-wrap" role="group">
                <button type="button" class="btn btn-outline-primary active" data-target="#pumpWidget">
                    <i class="mdi mdi-pump me-1"></i> Pumps
                </button>
                <button type="button" class="btn btn-outline-primary" data-target="#testingWidget">
                    <i class="mdi mdi-filter me-1"></i> Testing Details
                </button>
                <button type="button" class="btn btn-outline-primary" data-target="#meterReadingWidget">
                    <i class="mdi mdi-thermometer me-1"></i> Meter
                </button>
                <button type="button" class="btn btn-outline-primary">
                    <i class="mdi mdi-gauge-full me-1"></i> Opening Meters
                </button>
                <button type="button" class="btn btn-outline-primary">
                    <i class="mdi mdi-gauge me-1"></i> Pumper Opening Meters
                </button>
            </div>
        </div>
    </div>
    @include('admin.petro.pump-management.widget.pump-table')
    @include('admin.petro.pump-management.widget.testing-details-table')
    @include('admin.petro.pump-management.widget.meter-readings-table')
    @include('admin.petro.settlement.widget.modals.create-pump-modal')

    {{-- Modals --}}
    @include('admin.petro.pump-management.widget.modal.pump-view-details-modal')
    @include('admin.petro.pump-management.widget.modal.test-view-details-modal')
    @include('admin.petro.pump-management.widget.modal.meter-view-details-modal')
</div>
@endsection
<script src="{{ asset('assets/js/pump-management.js') }}"></script>