@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
    @include('admin.command.widgets.page-header', $pageHeader)

    {{-- 1. Add Form --}}
    @include('admin.petro.dip-management.widget.dip-form')

    {{-- 2. List Table --}}
    @include('admin.petro.dip-management.widget.dip-list')

    {{-- 3. Edit Modal --}}
    @include('admin.petro.dip-management.widget.modal.edit-dip-modal')

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Dip Management Script Loaded"); // Debug 1

        const editButtons = document.querySelectorAll('.edit-dip-btn');
        const form = document.getElementById('editDipForm');

        if (!form) {
            console.error("CRITICAL ERROR: Could not find form with id 'editDipForm'. Check your modal file!");
            return;
        }

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                console.log("Edit button clicked"); // Debug 2

                // 1. Get Data
                const id = this.getAttribute('data-id');
                const tankId = this.getAttribute('data-tank');
                const volume = this.getAttribute('data-volume');
                const level = this.getAttribute('data-level');
                const date = this.getAttribute('data-date');
                const temp = this.getAttribute('data-temp');
                const notes = this.getAttribute('data-notes');

                console.log("Data retrieved:", { id, tankId, volume, level }); // Debug 3

                // 2. Set Action
                form.action = `/dip-management/${id}`;

                // 3. Fill Inputs (With safety checks)
                try {
                    if(document.getElementById('edit_tank_id')) 
                        document.getElementById('edit_tank_id').value = tankId;
                    else console.error("Missing input: edit_tank_id");

                    if(document.getElementById('edit_reading_date')) 
                        document.getElementById('edit_reading_date').value = date;
                    
                    if(document.getElementById('edit_dip_level')) 
                        document.getElementById('edit_dip_level').value = level;
                    
                    if(document.getElementById('edit_volume')) 
                        document.getElementById('edit_volume').value = volume;

                    if(document.getElementById('edit_temperature')) 
                        document.getElementById('edit_temperature').value = temp;

                    if(document.getElementById('edit_notes')) 
                        document.getElementById('edit_notes').value = notes;
                        
                } catch (e) {
                    console.error("Error filling form:", e);
                }
            });
        });
    });
</script>
@endsection