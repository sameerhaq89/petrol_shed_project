<style>
    @media (max-width: 768px) {
        #metaFilterBodyEntry .d-flex.flex-nowrap {
            flex-wrap: wrap !important;
        }

        #metaFilterBodyEntry .overflow-auto {
            overflow: visible !important;
        }

        #metaFilterBodyEntry>.d-flex>div {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            margin-bottom: 0.5rem;
        }

        #metaFilterBodyEntry>.d-flex>div:nth-child(5),
        #metaFilterBodyEntry>.d-flex>div:nth-child(6) {
            width: calc(50% - 4px) !important;
            max-width: calc(50% - 4px) !important;
            min-width: calc(50% - 4px) !important;
        }

        #metaFilterBodyEntry>.d-flex>div:nth-child(5) {
            margin-right: 8px;
        }
    }
</style>
<div class="collapse" id="metaFilterBodyEntry">
    <div class="d-flex flex-nowrap align-items-end gap-2 py-1" >
        <div class="d-flex flex-column flex-shrink-0" style="width: 80px;">
            <label class="text-muted small mb-1">Ref</label>
            <input type="text" class="form-control form-control-sm bg-light py-1" value="ST275" readonly>
        </div>
        <div class="d-flex flex-column flex-grow-1" style="min-width: 210px; max-width: 330px;">
            <label class="text-muted small mb-1">Location</label>
            <select class="form-control form-control-sm py-1 tom-select">
                <option value="">Select location</option>
                <option>S.H.M Jafris Lanka (Pvt) Ltd</option>
            </select>
        </div>
        <div class="d-flex flex-column flex-shrink-0" style="width: 120px;">
            <label class="text-muted small mb-1">Operator</label>
            <select class="form-control form-control-sm py-1 tom-select" autocomplete="off">
                <option value="">Select Operator</option>
                <option>Isuru</option>
            </select>
        </div>
        <div class="d-flex flex-column flex-shrink-0" style="width: 140px;">
            <label class="text-muted small mb-1">Date</label>
            <input type="date" class="form-control form-control-sm py-1" value="2025-12-11">
        </div>
        <div class="d-flex flex-column flex-shrink-0" style="width: 100px;">
            <label class="text-muted small mb-1">Shift</label>
            <select class="form-control form-control-sm py-1">
                <option>Day</option>
                <option>Night</option>
            </select>
        </div>
        <div class="d-flex flex-column flex-shrink-0" style="width: 80px;">
            <label class="text-muted small mb-1">Shift No</label>
            <input type="text" class="form-control form-control-sm py-1" placeholder="No">
        </div>
        <div class="d-flex flex-column flex-grow-1" style="min-width: 140px; max-width: 300px;">
            <label class="text-muted small mb-1">Note</label>
            <input type="text" class="form-control form-control-sm py-1" placeholder="Enter note">
        </div>
    </div>
</div>