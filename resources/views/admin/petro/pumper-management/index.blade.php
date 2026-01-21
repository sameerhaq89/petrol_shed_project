@extends('admin.layouts.app')
<link rel="stylesheet" href="{{ asset('assets/css/data-table.css') }}">
<style>
    .pumper-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 7px;
        margin-bottom: 20px;
    }
    .pumper-card {
        height: 50px;
        border: 1.5px solid #c77dff;
        background: #f8f4fa;
        color: #c77dff;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .pumper-card:hover { background: #efe6ff; }
    .pumper-card.active { background: #c77dff; color: #000; border-color: #c77dff; }
    
    /* Tab Logic */
    .content-section { display: none; }
    .content-section.active { display: block; animation: fadeIn 0.3s; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>

@section('content')
    <div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
        
        {{-- HEADER & ASSIGN BUTTON --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
             @include('admin.command.widgets.page-header', $pageHeader)
             @include('admin.petro.pumper-management.modals.assign-pumper')
             {{-- ONLY SHOW IF SHIFT IS OPEN --}}
             @if(isset($activeShift))
                 <button class="btn btn-gradient-primary btn-lg font-weight-bold shadow" 
                         data-bs-toggle="modal" 
                         data-bs-target="#assignPumperModal">
                    <i class="mdi mdi-account-plus me-2"></i> Open Shift for Pumper
                 </button>
             @else
                 <div class="modal fade" id="assignPumperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        ...
        <form action="{{ route('pumper.assign') }}" method="POST">
            @csrf
            ...
        </form>
    </div>
</div>
             @endif
        </div>

        <div class="pumper-grid" id="pumperNav">
            <button class="pumper-card active" data-target="pump-operators">
                <i class="mdi mdi-account"></i> <span>Pump Operators</span>
            </button>
            <button class="pumper-card" data-target="excess-shortage">
                <i class="mdi mdi-scale-balance"></i> <span>Excess & Shortage</span>
            </button>
            <button class="pumper-card" data-target="day-entries">
                <i class="mdi mdi-calendar-clock"></i> <span>Day Entries</span>
            </button>
            <button class="pumper-card" data-target="shift-summary">
                <i class="mdi mdi-clipboard-text-clock"></i> <span>Shift Summary</span>
            </button>
            <button class="pumper-card" data-target="close-shift">
                <i class="mdi mdi-lock-check"></i> <span>Close Shift</span>
            </button>
        </div>

        <div class="content-sections">
            <div id="pump-operators" class="content-section active">
                 @include('admin.petro.pumper-management.widgets.pump-oparaters-table', ['pumperStats' => $pumperStats])
            </div>

            <div id="excess-shortage" class="content-section">
                @include('admin.petro.pumper-management.widgets.shortage-table')
            </div>

            <div id="day-entries" class="content-section">
                <div class="card"><div class="card-body text-muted text-center">Daily entries log will appear here.</div></div>
            </div>

            </div>
    </div>

   
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.pumper-card');
        const sections = document.querySelectorAll('.content-section');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                // 1. Reset all
                buttons.forEach(b => b.classList.remove('active'));
                sections.forEach(s => s.classList.remove('active'));

                // 2. Activate clicked
                btn.classList.add('active');

                // 3. Show target
                const targetId = btn.getAttribute('data-target');
                const targetSection = document.getElementById(targetId);
                if(targetSection) {
                    targetSection.classList.add('active');
                }
            });
        });
    });
</script>
@endpush