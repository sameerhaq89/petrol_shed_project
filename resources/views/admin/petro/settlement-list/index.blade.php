@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">

    @include('admin.command.widgets.page-header', $pageHeader)

    @include('admin.petro.settlement-list.widget.settlement-list-table')
</div>

<!-- View Details Modal -->
@include('admin.petro.settlement-list.widget.models.view-details')
@include('admin.petro.settlement-list.widget.models.import')
@endsection

<script src="{{ asset('assets/js/settlementList.js') }}"></script>