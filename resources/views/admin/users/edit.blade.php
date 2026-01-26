@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mx-auto">
            <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                <div class="card-body">
                    <h4 class="card-title">Edit Details: {{ $user->name }}</h4>
                    <p class="card-description"> Update user information and permissions. </p>

                    <form class="forms-sample" action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                        {{-- Name --}}
                        <div class="form-group mb-3">
                            <label for="name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-3">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="form-group mb-3">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{-- Role Selection --}}
                        <div class="form-group mb-3">
                            <label for="role_id">Assign Role <span class="text-danger">*</span></label>
                            <select class="form-control form-select @error('role_id') is-invalid @enderror"
                                    id="role_id" name="role_id" required onchange="toggleStationField()">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Station Selection --}}
                        <div class="form-group mb-3" id="station_div" style="display: none;">
                            <label for="station_id">Assign Station <span class="text-danger">*</span></label>
                            <select class="form-control form-select @error('station_id') is-invalid @enderror"
                                    id="station_id" name="station_id">
                                <option value="">-- Select Station --</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}"
                                        {{ old('station_id', $user->station_id) == $station->id ? 'selected' : '' }}>
                                        {{ $station->name }} ({{ $station->station_code }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Required for all roles except Super Admin.</small>
                            @error('station_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password (Optional) --}}
                        <div class="form-group mb-3">
                            <label for="password">New Password <small class="text-muted">(Leave blank to keep current)</small></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" autocomplete="new-password">
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-gradient-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-gradient-info">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleStationField() {
        var roleSelect = document.getElementById('role_id');
        var stationDiv = document.getElementById('station_div');
        var stationInput = document.getElementById('station_id');

        // Assuming Role ID 1 is "Super Admin" based on your DB
        var selectedValue = roleSelect.value;

        // Logic: If role is Super Admin (ID 1), hide station. Else show it.
        if (selectedValue == '1') {
            stationDiv.style.display = 'none';
            stationInput.required = false;
        } else {
            stationDiv.style.display = 'block';
            stationInput.required = true;
        }
    }

    // Run on load to set correct state based on current user data
    window.onload = function() {
        toggleStationField();
    };
</script>
@endsection
