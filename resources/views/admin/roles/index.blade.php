@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Role Management </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Roles</li>
            </ol>
        </nav>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">System Roles</h4>
            <p class="card-description"> Manage permissions for each role below. </p>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Description</th>
                            <th>Permissions Count</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>
                                <span class="fw-bold">{{ $role->name }}</span>
                                @if($role->is_system_role)
                                    <i class="mdi mdi-lock text-muted" title="System Role"></i>
                                @endif
                            </td>
                            <td>{{ $role->description ?? 'No description' }}</td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $role->permissions->count() }} Permissions
                                </span>
                            </td>
                            <td class="text-center">
                                @can('roles.update')
                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-gradient-primary btn-icon-text">
                                        <i class="mdi mdi-shield-account"></i> Manage Permissions
                                    </a>
                                @else
                                    <small class="text-muted">Read Only</small>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($roles->isEmpty())
                <div class="alert alert-info mt-4">
                    No roles found (excluding Super Admin).
                </div>
            @endif
        </div>
    </div>
</div>
@endsection