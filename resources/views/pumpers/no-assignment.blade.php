@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center p-5">
                        <i class="mdi mdi-gas-station text-secondary mb-3" style="font-size: 4rem;"></i>
                        <h3 class="text-danger font-weight-bold mb-3">No Active Assignment</h3>
                        <p class="text-muted mb-4 h5">
                            You are not currently assigned to any pump.
                        </p>
                        <p class="text-secondary mb-4">
                            Please contact the Station Manager to assign you to a pump and open your shift.
                        </p>

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn btn-outline-danger">
                            <i class="mdi mdi-logout me-1"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection