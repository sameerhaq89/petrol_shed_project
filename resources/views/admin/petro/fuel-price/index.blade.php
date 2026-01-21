@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    @include('admin.command.widgets.page-header', $pageHeader)

    {{-- SECTION 1: Current Price Cards --}}
    <div class="row mb-4">
        @foreach($currentPrices as $price)
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-{{ $loop->index % 2 == 0 ? 'primary' : 'success' }} card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">{{ $price->fuelType->name }} <i class="mdi mdi-gas-station mdi-24px float-right"></i></h4>
                    <h2 class="mb-2">LKR {{ number_format($price->selling_price, 2) }}</h2>
                    <h6 class="card-text">Effective: {{ \Carbon\Carbon::parse($price->effective_from)->format('d M Y') }}</h6>
                </div>
            </div>
        </div>
        @endforeach
        
        {{-- Add New Price Button --}}
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-light text-center d-flex align-items-center justify-content-center" 
                 style="cursor: pointer; border: 2px dashed #ccc;"
                 data-bs-toggle="modal" 
                 data-bs-target="#addPriceModal">
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <i class="mdi mdi-plus-circle-outline text-primary" style="font-size: 40px;"></i>
                    <h5 class="mt-2 text-primary">Update Fuel Price</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 2: Price History Table --}}
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Price History</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> Date </th>
                                    <th> Fuel Type </th>
                                    <th> Purchase Price </th>
                                    <th> Selling Price </th>
                                    <th> Margin </th>
                                    <th> Status </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $record)
                                <tr>
                                    <td> {{ \Carbon\Carbon::parse($record->effective_from)->format('Y-m-d') }} </td>
                                    <td>
                                        <span class="badge badge-outline-primary">{{ $record->fuelType->name }}</span>
                                    </td>
                                    <td> {{ number_format($record->purchase_price, 2) }} </td>
                                    <td class="font-weight-bold"> {{ number_format($record->selling_price, 2) }} </td>
                                    <td class="text-success"> {{ number_format($record->margin, 2) }} </td>
                                    <td>
                                        @if($record->effective_to == null)
                                            <label class="badge badge-success">Active</label>
                                        @else
                                            <label class="badge badge-secondary">History</label>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('fuel-prices.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Add New Price --}}
<div class="modal fade" id="addPriceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set New Fuel Price</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fuel-prices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Fuel Type <span class="text-danger">*</span></label>
                        <select name="fuel_type_id" class="form-select" required>
                            @foreach($fuelTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Purchase Price <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="purchase_price" class="form-control" required placeholder="Cost">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Selling Price <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="selling_price" class="form-control" required placeholder="Retail">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Effective From <span class="text-danger">*</span></label>
                        <input type="date" name="effective_from" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Price</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection