@extends('super-admin.layouts.master')

@section('title', 'Add New Station')

@section('content')
<div class="dashboard-container">
    <div class="page-header">
        <h1 class="page-title">Add New Station</h1>
        <a href="{{ route('super-admin.stations.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('super-admin.stations.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Station Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="location" class="form-label">Location/City <span class="text-danger">*</span></label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Full Address</label>
                    <textarea name="address" id="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="contact_number" class="form-label">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ old('contact_number') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-footer mt-4">
                    <button type="submit" class="btn btn-primary">Create Station</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 24px;
    }

    .form-control {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 12px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
    }
</style>
@endsection