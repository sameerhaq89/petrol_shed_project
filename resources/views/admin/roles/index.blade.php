@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="card border-primary shadow-sm mt-2" style="border-top: 3px solid;">
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
                                <span class="badge badge-gradient-info">
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
