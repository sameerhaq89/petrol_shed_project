@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card mx-auto">
            <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
                <div class="card-body">
                    <h4 class="card-title">User Details</h4>
                    <p class="card-description"> Fill in the information below to create a new system user. </p>

                    <form class="forms-sample" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Name --}}
                                <div class="form-group mb-3">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="John Doe" value="{{ old('name') }}"
                                        required>
                                    @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group mb-3">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="user@example.com"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="form-group mb-3">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="07xxxxxxxx"
                                        value="{{ old('phone') }}">
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
                                        id="role_id" name="role_id" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Station Selection (Hidden if Super Admin or Auto-assigned) --}}
                                @if(auth()->user()->role_id == 1)
                                <div class="form-group mb-3" id="station_div">
                                    <label for="station_id">Assign Station <span class="text-danger">*</span></label>
                                    <select class="form-control form-select @error('station_id') is-invalid @enderror"
                                        id="station_id" name="station_id">
                                        <option value="">-- Select Station --</option>
                                        @foreach ($stations as $station)
                                        <option value="{{ $station->id }}"
                                            {{ old('station_id') == $station->id ? 'selected' : '' }}>
                                            {{ $station->name }} ({{ $station->station_code }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('station_id')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                @else
                                <div class="form-group mb-3">
                                    <label>Assigned Station</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->station->name ?? 'N/A' }}" disabled>
                                    <input type="hidden" name="station_id" value="{{ auth()->user()->station_id }}">
                                </div>
                                @endif

                                {{-- Password --}}
                                <div class="form-group mb-3">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    @error('password')
                                    <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('users.index') }}" class="btn btn-gradient-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-gradient-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection