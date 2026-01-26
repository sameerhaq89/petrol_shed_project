@extends('admin.layouts.app')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/data-table.css') }}">
@endpush

@section('content')
{{-- <div class="d-flex justify-content-between align-items-center mb-4"> --}}
    {{-- <h3 class="page-title">Settlement List</h3> --}}

    {{-- START SHIFT BUTTON --}}
    {{-- <form action="{{ route('settlement.start') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-gradient-success btn-lg shadow">
            <i class="mdi mdi-play-circle-outline me-2"></i> Start New Shift
        </button>
    </form> --}}
{{-- </div> --}}
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
    @include('admin.command.widgets.page-header', $pageHeader)
    @include('admin.petro.settlement-list.widget.current-live-shift')
    @if($currentShift)
        @include('admin.petro.settlement-list.widget.models.close-shift')
    @endif
    {{-- The table widget below will now have access to $settlements --}}
    @include('admin.petro.settlement-list.widget.settlement-list-table')
</div>

{{-- Ensure these paths exist or create empty files to avoid errors --}}
@include('admin.petro.settlement-list.widget.models.view-details')
@include('admin.petro.settlement-list.widget.models.import')

@endsection

@push('js')
<script src="{{ asset('assets/js/settlementList.js') }}"></script>
@endpush
