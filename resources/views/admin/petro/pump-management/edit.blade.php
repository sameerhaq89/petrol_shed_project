@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Edit Pump </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('pumps.index') }}">Pumps</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pumps.update', $pump->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Pump Name</label>
                        <input type="text" name="pump_name" class="form-control form-controle-sm" value="{{ $pump->pump_name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Pump Number</label>
                        <input type="text" name="pump_number" class="form-control form-controle-sm" value="{{ $pump->pump_number }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Assign Tank</label>
                        <select name="tank_id" class="form-control form-controle-sm" required>
                            @foreach($tanks as $tank)
                                <option value="{{ $tank->id }}" {{ $pump->tank_id == $tank->id ? 'selected' : '' }}>
                                    {{ $tank->tank_name }} ({{ $tank->fuel_type_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $pump->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="maintenance" {{ $pump->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="offline" {{ $pump->status == 'offline' ? 'selected' : '' }}>Offline</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-gradient-primary">Update Pump</button>
                <a href="{{ route('pumps.index') }}" class="btn btn-gradient-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
