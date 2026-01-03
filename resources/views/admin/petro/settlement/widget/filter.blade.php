<!-- Card Header / Toggle -->
{{-- <div class="d-flex justify-content-between align-items-center py-1">
    <div class="d-flex align-items-center">
        <i class="mdi mdi-filter me-2"></i>
        <h6 class="mb-0 fw-bold">Filters</h6>
    </div>
    <button class="btn btn-sm btn-outline-secondary filter-toggle" type="button" data-bs-toggle="collapse"
        data-bs-target="#metaFilterBody" aria-expanded="false" aria-controls="metaFilterBody">
        <i class="mdi mdi-chevron-down"></i>
    </button>
</div> --}}

<!-- Collapse Body -->
<div class="collapse" id="metaFilterBody">
    <div class="d-flex flex-wrap align-items-end gap-2 py-1">
        <!-- Ref -->
        <div>
            <label class="text-muted small mb-1">Ref</label>
            <input type="text" class="form-control form-control-sm bg-light py-1" value="ST275" readonly
                style="width: 80px;">
        </div>

        <!-- Location -->
        <div>
            <label class="text-muted small mb-1">Location</label>
            <select class="form-control form-control-sm py-1" style="width: 200px;">
                <option>S.H.M Jafris Lanka (Pvt) Ltd</option>
            </select>
        </div>

        <!-- Operator -->
        <div>
            <label class="text-muted small mb-1">Operator</label>
            <select class="form-control form-control-sm py-1" style="width: 120px;">
                <option>Isuru</option>
            </select>
        </div>

        <!-- Date -->
        <div>
            <label class="text-muted small mb-1">Date</label>
            <input type="date" class="form-control form-control-sm py-1" value="2025-12-11" style="width: 140px;">
        </div>

        <!-- Shift -->
        <div>
            <label class="text-muted small mb-1">Shift</label>
            <select class="form-control form-control-sm py-1" style="width: 120px;">
                <option>Day Shift</option>
                <option>Night Shift</option>
            </select>
        </div>

        <!-- Shift No -->
        <div>
            <label class="text-muted small mb-1">Shift No</label>
            <input type="text" class="form-control form-control-sm py-1" placeholder="No" style="width: 80px;">
        </div>

        <!-- Note -->
        <div>
            <label class="text-muted small mb-1">Note</label>
            <input type="text" class="form-control form-control-sm py-1" placeholder="Enter note"
                style="width: 150px;">
        </div>
    </div>
</div>

{{-- <!-- JS for toggle icon -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.querySelector('.filter-toggle');
    const target = document.querySelector('#metaFilterBody');
    const icon = toggleBtn.querySelector('i');
    const cardHeader = document.querySelector('.card-body > .d-flex.justify-content-between');

    target.addEventListener('show.bs.collapse', () => {
        icon.classList.remove('mdi-chevron-down');
        icon.classList.add('mdi-chevron-up');
    });
    target.addEventListener('hide.bs.collapse', () => {
        icon.classList.remove('mdi-chevron-up');
        icon.classList.add('mdi-chevron-down');
    });

    cardHeader.addEventListener('click', (e) => {
        if (!toggleBtn.contains(e.target) && !target.classList.contains('show')) {
            new bootstrap.Collapse(target, { toggle: true });
        }
    });

    document.querySelectorAll('.filter-open-on-click').forEach(container => {
        container.addEventListener('click', (e) => {
            if (!toggleBtn.contains(e.target) && !target.classList.contains('show')) {
                new bootstrap.Collapse(target, { toggle: true });
            }
        });
    });
});
</script> --}}

