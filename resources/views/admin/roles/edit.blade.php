@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
    @include('admin.command.widgets.page-header', $pageHeader)
    <div class="card border-primary shadow-sm mt-2" style="border-top: 3px solid;">

        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Loop through Modules (Users, Dashboard, Reports) --}}
                    @foreach($permissions as $module => $modulePermissions)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 text-capitalize">{{ $module }} Management</h5>
                            </div>
                            <div class="card-body">
                                @foreach($modulePermissions as $perm)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           name="permissions[]"
                                           value="{{ $perm->id }}"
                                           id="perm_{{ $perm->id }}"
                                           {{-- Check if role already has this permission --}}
                                           {{ $role->permissions->contains($perm->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_{{ $perm->id }}">
                                        {{ $perm->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-3 d-flex justify-content-end">
                    <a href="{{ route('roles.index') }}" class="btn btn-gradient-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-gradient-success">Save Permissions</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
