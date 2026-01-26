@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">

    @include('admin.command.widgets.page-header', $pageHeader)

    {{-- 1. Module Tabs --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="btn-group shadow-sm flex-wrap" role="group">
                <button type="button" class="btn btn-gradient-primary active">
                    <i class="mdi mdi-gas-station me-1"></i> Meter Sale
                </button>
                {{-- <button type="button" class="btn btn-outline-secondary">
                    <i class="mdi mdi-cube-outline me-1"></i> Other Sale
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="mdi mdi-bank-transfer me-1"></i> Other Income
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="mdi mdi-cash me-1"></i> Customer Payment
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="mdi mdi-wallet-giftcard me-1"></i> Expense
                </button> --}}
            </div>

        </div>
    </div>
    {{-- 2. Active Widget Inclusion --}}
    <div class="row">
        <div class="col-12 mb-3 stretch-card">
            <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                <div class="card-body">
                    @include('admin.petro.settlement.widget.meter-sale')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-4 stretch-card">
            <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                <div class="mt-4">
                    @include('admin.petro.settlement.widget.cash-drop')
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Table --}}
    @include('admin.petro.settlement.widget.entry-table')


    {{-- 4. Summary Widget --}}
    <div class="row">
        <div class="col-12 mb-4 stretch-card">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    @include('admin.petro.settlement.widget.summary')
                </div>
            </div>
        </div>
    </div>
    @include('admin.petro.settlement.widget.modals.create-pump-modal')
    @include('admin.petro.settlement.widget.modals.entry-view-details-modal')
    @include('admin.petro.settlement.widget.modals.edit-entry-modal')
</div>
@endsection
<script src="{{ asset('assets/js/settlement.js') }}">
@push('js')
<script>
    $(document).ready(function() {
        // Initialize DataTable on your specific ID
        $('#entryTable').DataTable({
            "order": [[ 0, "desc" ]], // Sort by first column (Code) descending
            "paging": true,
            "searching": true,
            "info": true,
            "lengthChange": true
        });
    });
</script>
@endpush</script>
