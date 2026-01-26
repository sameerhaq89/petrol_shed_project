@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="card border-primary shadow-sm mt-2" style="border-top: 3px solid;">
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
                            <td><span class="badge badge-gradient-info">{{ $user->role->name ?? 'No Role' }}</span></td>
                            <td>{{ $user->station->name ?? 'N/A' }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-gradient-success">Active</span>
                                @else
                                    <span class="badge badge-gradient-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @can('users.update')
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-gradient-info btn-sm btn-icon-text">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                @endcan

                                @can('users.delete')
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-gradient-danger btn-sm btn-icon-text">
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
