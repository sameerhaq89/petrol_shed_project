@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div class="page-header d-flex justify-content-between align-items-center">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-gas-station"></i>
            </span> Fuel Management
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fuel Management</li>
            </ul>
        </nav>
    </div>

    {{-- TABS NAVIGATION --}}
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-pills nav-fill mb-4 bg-white p-2 rounded shadow-sm" id="fuelTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active font-weight-bold" id="prices-tab" data-bs-toggle="tab" data-bs-target="#prices" type="button" role="tab" aria-selected="true">
                        <i class="mdi mdi-currency-usd me-1"></i> Fuel Prices
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link font-weight-bold" id="types-tab" data-bs-toggle="tab" data-bs-target="#types" type="button" role="tab" aria-selected="false">
                        <i class="mdi mdi-format-list-bulleted me-1"></i> Fuel Types (Products)
                    </button>
                </li>
            </ul>
        </div>
    </div>

    {{-- TAB CONTENT AREA --}}
    <div class="tab-content" id="fuelTabContent">
        
        {{-- ================= TAB 1: FUEL PRICES ================= --}}
        <div class="tab-pane fade show active" id="prices" role="tabpanel" aria-labelledby="prices-tab">
            
            {{-- Current Price Cards --}}
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
                
                {{-- Add New Price Button Card --}}
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

            {{-- Price History Table --}}
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="card-title text-primary"><i class="mdi mdi-history"></i> Price History Log</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
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
                                                <span class="badge badge-outline-dark">{{ $record->fuelType->name }}</span>
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
                                                    <button type="submit" class="btn btn-sm btn-inverse-danger btn-icon">
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

        {{-- ================= TAB 2: FUEL TYPES (PRODUCTS) ================= --}}
        <div class="tab-pane fade" id="types" role="tabpanel" aria-labelledby="types-tab">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="card-title text-primary"><i class="mdi mdi-settings"></i> Product Configuration</h4>
                                <button class="btn btn-gradient-info btn-sm" data-bs-toggle="modal" data-bs-target="#addFuelTypeModal">
                                    <i class="mdi mdi-plus"></i> Add New Fuel Type
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Color</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Unit</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($fuelTypes as $type)
                                        <tr>
                                            <td>
                                                <div style="width: 25px; height: 25px; border-radius: 50%; background-color: {{ $type->color_code ?? '#ccc' }}; border: 1px solid #ddd; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"></div>
                                            </td>
                                            <td class="font-weight-bold">{{ $type->name }}</td>
                                            <td><span class="badge badge-inverse-info">{{ $type->code }}</span></td>
                                            <td>{{ $type->unit }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-inverse-primary btn-icon edit-type-btn"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editFuelTypeModal"
                                                    data-id="{{ $type->id }}"
                                                    data-name="{{ $type->name }}"
                                                    data-code="{{ $type->code }}"
                                                    data-unit="{{ $type->unit }}"
                                                    data-color="{{ $type->color_code }}">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                
                                                <form action="{{ route('fuel-types.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this fuel type? This might affect existing tanks/pumps.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-inverse-danger btn-icon">
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
    </div>
</div>

{{-- ================= MODALS ================= --}}

{{-- MODAL 1: Add New Price --}}
<div class="modal fade" id="addPriceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title"><i class="mdi mdi-currency-usd"></i> Set New Fuel Price</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fuel-prices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="font-weight-bold">Fuel Type <span class="text-danger">*</span></label>
                        <select name="fuel_type_id" class="form-select border-primary" required>
                            @foreach($fuelTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }} ({{ $type->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Purchase Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" step="0.01" name="purchase_price" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold">Selling Price</label>
                            <div class="input-group">
                                <span class="input-group-text bg-success text-white">Rs.</span>
                                <input type="number" step="0.01" name="selling_price" class="form-control border-success" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="font-weight-bold">Effective From</label>
                        <input type="date" name="effective_from" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-primary">Save Price</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL 2: Add New Fuel Type --}}
<div class="modal fade" id="addFuelTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info text-white">
                <h5 class="modal-title"><i class="mdi mdi-plus-circle"></i> Add New Product</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fuel-types.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Product Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Super Diesel">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Code (Short)</label>
                            <input type="text" name="code" class="form-control" required placeholder="e.g. LSD-95">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Unit</label>
                            <input type="text" name="unit" class="form-control" value="Liters" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Color Identifier</label>
                        <input type="color" name="color_code" class="form-control form-control-color w-100" value="#563d7c">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-info">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL 3: Edit Fuel Type --}}
<div class="modal fade" id="editFuelTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Edit Fuel Type</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editFuelTypeForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Code</label>
                            <input type="text" name="code" id="edit_code" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Unit</label>
                            <input type="text" name="unit" id="edit_unit" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JavaScript for Edit Modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-type-btn');
        const form = document.getElementById('editFuelTypeForm');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                // Ensure this route exists or adjust strictly to your URL structure
                form.action = "{{ url('fuel-types') }}/" + id;
                
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_code').value = this.getAttribute('data-code');
                document.getElementById('edit_unit').value = this.getAttribute('data-unit');
            });
        });
    });
</script>
@endsection