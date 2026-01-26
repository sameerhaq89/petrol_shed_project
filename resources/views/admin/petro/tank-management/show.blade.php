@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="row">
        {{-- Main Details Card --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                <div class="card-body">
                    <h4 class="card-title">{{ $tank->tank_name }}</h4>
                    <p class="card-description">Basic Configuration</p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($tank->status == 'active')
                                            <label class="badge badge-gradient-success">Active</label>
                                        @else
                                            <label class="badge badge-danger">{{ ucfirst($tank->status) }}</label>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fuel Type</th>
                                    <td>{{ $tank->fuelType->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Total Capacity</th>
                                    <td>{{ number_format($tank->capacity, 2) }} Liters</td>
                                </tr>
                                <tr>
                                    <th>Station</th>
                                    <td>{{ $tank->station->name ?? 'Default Station' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stock Details Card --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h4 class="card-title text-white">Current Stock Level</h4>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <h2 class="mb-0 font-weight-bold">{{ number_format($tank->current_stock, 2) }} L</h2>
                        <i class="mdi mdi-gas-station mdi-48px"></i>
                    </div>

                    <div class="progress progress-md mt-3">
                        @php
                            $percentage = ($tank->capacity > 0) ? ($tank->current_stock / $tank->capacity) * 100 : 0;
                            $color = $percentage < 20 ? 'bg-gradient-danger' : 'bg-gradient-success';
                        @endphp
                        <div class="progress-bar {{ $color }}" role="progressbar"
                             style="width: {{ $percentage }}%"
                             aria-valuenow="{{ $percentage }}"
                             aria-valuemin="0"
                             aria-valuemax="100"></div>
                    </div>
                    <p class="mt-2 mb-0">{{ number_format($percentage, 1) }}% Full</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        <a href="{{ route('tanks.index') }}" class="btn btn-gradient-secondary">Back to List</a>
        <a href="{{ route('tanks.edit', $tank->id) }}" class="btn btn-gradient-primary">Edit Tank</a>
    </div>

</div>
@endsection
