{{-- 
    FILE: resources/views/admin/common/quick-actions.blade.php 
    PURPOSE: Floating Action Button + Quick Entry Modals
--}}

<style>
    /* Floating Action Button (FAB) Styles */
    .fab-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        cursor: pointer;
    }

    .fab-icon-holder {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(to right, #da8cff, #9a55ff); /* Your Purple Theme */
        box-shadow: 0 6px 10px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .fab-icon-holder:hover {
        transform: scale(1.1) rotate(45deg);
    }

    .fab-icon-holder i {
        color: white;
        font-size: 30px;
    }

    .fab-options {
        list-style-type: none;
        position: absolute;
        bottom: 70px;
        right: 0;
        padding: 0;
        margin: 0;
        text-align: right;
        opacity: 0;
        transform: scale(0);
        transform-origin: bottom right;
        transition: all 0.3s ease;
    }

    .fab-container:hover .fab-options {
        opacity: 1;
        transform: scale(1);
    }

    .fab-options li {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 15px;
    }

    .fab-label {
        padding: 5px 10px;
        border-radius: 4px;
        background-color: rgba(0,0,0,0.8);
        color: white;
        margin-right: 10px;
        font-size: 14px;
        white-space: nowrap;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .fab-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        transition: transform 0.2s;
        border: none;
        outline: none;
    }

    .fab-btn:hover {
        transform: scale(1.1);
    }

    .btn-cash { background: #1bcfb4; } /* Green */
    .btn-pump { background: #198ae3; } /* Blue */
    .btn-dip  { background: #fe7c96; } /* Red/Orange */
</style>

{{-- === THE FLOATING BUTTONS === --}}
<div class="fab-container">
    <div class="fab-icon-holder">
        <i class="mdi mdi-plus"></i>
    </div>
    <ul class="fab-options">
        {{-- Option 1: Cash Drop --}}
        <li>
            <span class="fab-label">Quick Cash Drop</span>
            <button class="fab-btn btn-cash" data-bs-toggle="modal" data-bs-target="#quickCashDropModal">
                <i class="mdi mdi-cash-multiple mdi-24px"></i>
            </button>
        </li>
        {{-- Option 2: Dip Entry --}}
        <li>
            <span class="fab-label">Dip Reading</span>
            <button class="fab-btn btn-dip" data-bs-toggle="modal" data-bs-target="#quickDipModal">
                <i class="mdi mdi-ruler mdi-24px"></i>
            </button>
        </li>
        {{-- Option 3: Assign Pumper --}}
        <li>
            <span class="fab-label">Open Duty</span>
            <button class="fab-btn btn-pump" data-bs-toggle="modal" data-bs-target="#assignPumperModal">
                <i class="mdi mdi-account-plus mdi-24px"></i>
            </button>
        </li>
    </ul>
</div>

{{-- === MODAL 1: QUICK CASH DROP === --}}
<div class="modal fade" id="quickCashDropModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="mdi mdi-cash-multiple me-2"></i>Quick Cash Drop</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cash-drops.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Select Pumper</label>
                        {{-- We assume $activePumpers is shared globally or loaded via View Composer --}}
                        <select name="user_id" class="form-select" required>
                            <option value="">-- Who is dropping cash? --</option>
                            @php
                                $activePumpers = \App\Models\PumpOperatorAssignment::with('pumper')->where('status', 'active')->get();
                            @endphp
                            @foreach($activePumpers as $assign)
                                <option value="{{ $assign->user_id }}">{{ $assign->pumper->name }} ({{ $assign->pump->pump_name }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Amount (LKR)</label>
                        <input type="number" name="amount" class="form-control form-control-lg" required placeholder="5000.00">
                    </div>
                    <div class="form-group mb-0">
                        <label>Notes</label>
                        <input type="text" name="notes" class="form-control" placeholder="e.g. Mid-shift collection">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Drop</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="quickDipModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="mdi mdi-ruler me-2"></i>Dip Reading Entry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            {{-- 1. FIX: Use your existing route 'dip-management.store' --}}
            <form action="{{ route('dip-management.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    
                    {{-- 2. FIX: Add hidden date field required by your controller --}}
                    <input type="hidden" name="reading_date" value="{{ date('Y-m-d') }}">

                    <div class="form-group mb-3">
                        <label>Select Tank</label>
                        {{-- Ensure \App\Models\Tank is imported or use full path --}}
                        <select name="tank_id" class="form-select" required>
                            <option value="">-- Select Tank --</option>
                            @php $tanks = \App\Models\Tank::where('status','active')->get(); @endphp
                            @foreach($tanks as $tank)
                                <option value="{{ $tank->id }}">{{ $tank->tank_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 3. FIX: Match your controller's validation rules --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Dip Level (cm)</label>
                            <input type="number" step="0.01" name="dip_level_cm" class="form-control" required placeholder="CM">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Volume (Liters)</label>
                            <input type="number" step="0.01" name="volume_liters" class="form-control" required placeholder="Liters">
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label>Notes (Optional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Quick entry via Dashboard"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save Dip</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.petro.pumper-management.modals.assign-pumper')

{{-- === MODAL 3: ASSIGN PUMPER (Reuse your existing code) === --}}
{{-- 
    NOTE: Ensure your existing 'assignPumperModal' code is loaded on the page. 
    If not, you can paste the full modal code here again.
--}}