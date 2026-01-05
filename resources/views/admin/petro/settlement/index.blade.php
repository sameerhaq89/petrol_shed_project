@extends('admin.layouts.app')
<link rel="stylesheet" href="{{ asset('assets/css/data-table.css') }}">
@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">

    @include('admin.command.widgets.page-header', $pageHeader)

    {{-- 1. Module Tabs --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="btn-group w-100 shadow-sm d-flex flex-wrap" role="group">
                <button type="button" class="btn btn-gradient-primary active">
                    <i class="mdi mdi-gas-station me-1"></i> Meter Sale
                </button>
                <button type="button" class="btn btn-outline-secondary">
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
                </button>
            </div>

        </div>
    </div>
    {{-- 2. Active Widget Inclusion --}}
    <div class="row">
        <div class="col-12 mb-4 stretch-card">
            <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                <div class="card-body">
                    @include('admin.petro.settlement.widget.meter-sale')
                </div>
            </div>
        </div>
    </div>
    {{-- 3. Table --}}
    <div class="row">
        <div class="col-12 mb-4 stretch-card">
            <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title text-muted mb-0">
                            <i class="mdi mdi-format-list-bulleted text-primary"></i> Summary Table
                        </h4>
                        <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary" type="button"
                            data-bs-toggle="collapse" data-bs-target="#metaFilterBody">
                            <i class="mdi mdi-filter"></i>
                            <span id="tableFilterBtnText">Show Filter</span>
                        </button>
                    </div>
                    <div class="mb-3">
                        @include('admin.petro.settlement.widget.filter')
                    </div>
                    <div class="table-responsive">
                        <table id="entryTable" class="table table-hover table-bordered w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Products</th>
                                    <th>Pump</th>
                                    <th>Start Meter</th>
                                    <th>Close Meter</th>
                                    <th>Price</th>
                                    <th>Sold Qty</th>
                                    <th>Total Price</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    @include('admin.petro.settlement.widget.modals.view-details-modal')
</div>
@endsection
<script src="{{ asset('assets/js/settlement.js') }}"></script>