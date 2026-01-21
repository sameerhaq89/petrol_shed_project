@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Fuel Products Configuration</h4>
                        <button class="btn btn-gradient-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFuelTypeModal">
                            <i class="mdi mdi-plus"></i> Add New Fuel Type
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Color</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Unit</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fuelTypes as $type)
                                <tr>
                                    <td>
                                        <div style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $type->color_code ?? '#ccc' }}; border: 1px solid #ddd;"></div>
                                    </td>
                                    <td>{{ $type->name }}</td>
                                    <td><span class="badge badge-inverse-info">{{ $type->code }}</span></td>
                                    <td>{{ $type->unit }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary btn-icon edit-type-btn"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editFuelTypeModal"
                                            data-id="{{ $type->id }}"
                                            data-name="{{ $type->name }}"
                                            data-code="{{ $type->code }}"
                                            data-unit="{{ $type->unit }}"
                                            data-color="{{ $type->color_code }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        
                                        <form action="{{ route('fuel-types.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this fuel type?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-icon">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Add New --}}
<div class="modal fade" id="addFuelTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Fuel Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('fuel-types.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Super Diesel">
                    </div>
                    <div class="mb-3">
                        <label>Code</label>
                        <input type="text" name="code" class="form-control" required placeholder="e.g. LSD-95">
                    </div>
                    <div class="mb-3">
                        <label>Unit</label>
                        <input type="text" name="unit" class="form-control" value="Liters" required>
                    </div>
                    <div class="mb-3">
                        <label>Color Code (Hex)</label>
                        <input type="color" name="color_code" class="form-control form-control-color" value="#563d7c">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL: Edit --}}
<div class="modal fade" id="editFuelTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Fuel Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editFuelTypeForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Code</label>
                        <input type="text" name="code" id="edit_code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Unit</label>
                        <input type="text" name="unit" id="edit_unit" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-type-btn');
        const form = document.getElementById('editFuelTypeForm');

        editButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                form.action = `/fuel-types/${id}`;
                
                document.getElementById('edit_name').value = this.getAttribute('data-name');
                document.getElementById('edit_code').value = this.getAttribute('data-code');
                document.getElementById('edit_unit').value = this.getAttribute('data-unit');
            });
        });
    });
</script>
@endsection