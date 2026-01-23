@extends('admin.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Edit Tank </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tanks.index') }}">Tanks</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-8 grid-margin stretch-card mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Tank Details: {{ $tank->tank_name }}</h4>
                        <p class="card-description"> Change tank capacity, fuel type, or name. </p>

                        <form class="forms-sample" action="{{ route('tanks.update', $tank->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Tank Number & Name --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tank_number">Tank Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tank_number') is-invalid @enderror"
                                        id="tank_number" name="tank_number"
                                        value="{{ old('tank_number', $tank->tank_number) }}" required>
                                    @error('tank_number')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tank_name">Tank Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tank_name') is-invalid @enderror"
                                        id="tank_name" name="tank_name" value="{{ old('tank_name', $tank->tank_name) }}"
                                        required>
                                    @error('tank_name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Fuel Type --}}
                            <div class="form-group mb-3">
                                <label for="fuel_type_id">Fuel Type <span class="text-danger">*</span></label>
                                <select class="form-control form-select @error('fuel_type_id') is-invalid @enderror"
                                    id="fuel_type_id" name="fuel_type_id" required>
                                    <option value="">-- Select Fuel Type --</option>
                                    {{-- We need to fetch all fuel types. If not passed from controller, use relations or
                                    injected service data --}}
                                    @foreach(\App\Models\FuelType::where('is_active', true)->get() as $fuel)
                                        <option value="{{ $fuel->id }}" {{ old('fuel_type_id', $tank->fuel_type_id) == $fuel->id ? 'selected' : '' }}>
                                            {{ $fuel->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fuel_type_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Capacity & Current Stock (Read Only recommended for stock) --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="capacity">Capacity (Liters) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('capacity') is-invalid @enderror" id="capacity"
                                        name="capacity" value="{{ old('capacity', $tank->capacity) }}" required>
                                    @error('capacity')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="current_stock">Current Stock (Read Only)</label>
                                    <input type="text" class="form-control"
                                        value="{{ number_format($tank->current_stock, 2) }}" disabled>
                                    <small class="text-muted">To change stock, use "Dip / Refill" on the dashboard.</small>
                                </div>
                            </div>

                            {{-- Thresholds (Low Stock Alerts) --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="minimum_level">Low Stock Alert Level</label>
                                    <input type="number" step="0.01" class="form-control" name="minimum_level"
                                        value="{{ old('minimum_level', $tank->minimum_level) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="reorder_level">Reorder Level</label>
                                    <input type="number" step="0.01" class="form-control" name="reorder_level"
                                        value="{{ old('reorder_level', $tank->reorder_level) }}">
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="form-group mb-3">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="active" {{ old('status', $tank->status) == 'active' ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="inactive" {{ old('status', $tank->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="maintenance" {{ old('status', $tank->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="offline" {{ old('status', $tank->status) == 'offline' ? 'selected' : '' }}>
                                        Offline</option>
                                </select>
                                @error('status')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-gradient-primary me-2">Update Tank</button>
                                <a href="{{ route('tanks.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection