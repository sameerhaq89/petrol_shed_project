@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">

    @include('admin.command.widgets.page-header', $pageHeader)

    {{-- Top: Inline Add Dip Form (first content) --}}
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Add New Dip</h5>
                    @include('admin.petro.dip-management.widget.dip-form')
                </div>
            </div>
        </div>
    </div>

    {{-- Second content: Recent Dip Entries (DataTable) --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Recent Dip Entries</h5>
                    @include('admin.petro.dip-management.widget.dip-list')
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/dip-management.css') }}">
    {{-- DataTables CSS (CDN) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@endsection

@section('scripts')
    {{-- jQuery + DataTables (CDN) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets/js/dip-management.js') }}"></script>
@endsection
