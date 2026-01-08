@extends('admin.layouts.app')
<style>
    .pumper-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 7px;
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

    .pumper-card i {
        font-size: 1.2rem;
    }

    .pumper-card:hover {
        background: #efe6ff;
    }

    .pumper-card.active {
        background: #c77dff;
        color: #000;
        border-color: #c77dff;
    }
</style>
@section('content')
    <div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
        @include('admin.command.widgets.page-header', $pageHeader)
        <div class="pumper-grid">
            <button class="pumper-card active">
                <i class="mdi mdi-account"></i>
                <span>Pump Operators</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-scale-balance"></i>
                <span>Excess & Shortage</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-calendar-clock"></i>
                <span>Day Entries</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-clipboard-text-clock"></i>
                <span>Shift Summary</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-cash-multiple"></i>
                <span>Payment Summary</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-gauge"></i>
                <span>Meter + Payment</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-fuel"></i>
                <span>Daily Status</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-lock-check"></i>
                <span>Close Shift</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-speedometer"></i>
                <span>Current Meter</span>
            </button>

            <button class="pumper-card">
                <i class="mdi mdi-truck-delivery-outline"></i>
                <span>Unload Stock</span>
            </button>
        </div>


    </div>
@endsection
