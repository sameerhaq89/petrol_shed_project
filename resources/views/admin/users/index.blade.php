@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> User Management </h3>
        
        @can('users.create')
            <nav aria-label="breadcrumb">
                <a href="{{ route('users.create') }}" class="btn btn-gradient-primary btn-fw">
                    <i class="mdi mdi-plus"></i> Add New User
                </a>
            </nav>
        @endcan
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">System Users</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Station</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                {{ $user->name }} <br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td><span class="badge badge-info">{{ $user->role->name ?? 'No Role' }}</span></td>
                            <td>{{ $user->station->name ?? 'N/A' }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @can('users.update')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info btn-icon-text">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                @endcan

                                @can('users.delete')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-icon-text">
                                            <i class="mdi mdi-delete"></i> Delete
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection