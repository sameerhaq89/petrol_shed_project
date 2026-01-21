@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Create New User </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Details</h4>
                    <p class="card-description"> Fill in the information below to create a new system user. </p>

                    <form class="forms-sample" action="{{ route('users.store') }}" method="POST">
                        @csrf

                        {{-- Name --}}
                        <div class="form-group mb-3">
                            <label for="name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-3">
                            <label for="email">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" placeholder="user@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="form-group mb-3">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" placeholder="07xxxxxxxx" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Role Selection --}}
                        <div class="form-group mb-3">
                            <label for="role_id">Assign Role <span class="text-danger">*</span></label>
                            <select class="form-control form-select @error('role_id') is-invalid @enderror" 
                                    id="role_id" name="role_id" required onchange="toggleStationField()">
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Station Selection (Hidden if Super Admin) --}}
                        <div class="form-group mb-3" id="station_div" style="display: none;">
                            <label for="station_id">Assign Station <span class="text-danger">*</span></label>
                            <select class="form-control form-select @error('station_id') is-invalid @enderror" 
                                    id="station_id" name="station_id">
                                <option value="">-- Select Station --</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ old('station_id') == $station->id ? 'selected' : '' }}>
                                        {{ $station->name }} ({{ $station->station_code }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Required for all roles except Super Admin.</small>
                            @error('station_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="form-group mb-3">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-gradient-primary me-2">Create User</button>
                            <a href="{{ route('users.index') }}" class="btn btn-light">Cancel</a>
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
        
        // Assuming Role ID 1 is "Super Admin" based on your database dump
        var selectedRole = roleSelect.options[roleSelect.selectedIndex].text;
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

    // Run on load in case of validation errors redirecting back
    window.onload = function() {
        toggleStationField();
    };
</script>
@endsection