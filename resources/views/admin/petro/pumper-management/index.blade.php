@extends('admin.layouts.app')
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

    .content-section {
        display: none;
    }

    .content-section.active {
        display: block;
    }
</style>
@section('content')
    <div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
        @include('admin.command.widgets.page-header', $pageHeader)
        
        <!-- Pumper Cards Navigation -->
        <div class="pumper-grid">
            <button class="pumper-card active" data-target="pump-operators">
                <i class="mdi mdi-account"></i>
                <span>Pump Operators</span>
            </button>

            <button class="pumper-card" data-target="excess-shortage">
                <i class="mdi mdi-scale-balance"></i>
                <span>Excess & Shortage</span>
            </button>

            <button class="pumper-card" data-target="day-entries">
                <i class="mdi mdi-calendar-clock"></i>
                <span>Day Entries</span>
            </button>

            <!-- Add data-target attribute to all cards -->
            <button class="pumper-card" data-target="shift-summary">
                <i class="mdi mdi-clipboard-text-clock"></i>
                <span>Shift Summary</span>
            </button>

            <button class="pumper-card" data-target="payment-summary">
                <i class="mdi mdi-cash-multiple"></i>
                <span>Payment Summary</span>
            </button>

            <button class="pumper-card" data-target="meter-payment">
                <i class="mdi mdi-gauge"></i>
                <span>Meter + Payment</span>
            </button>

            <button class="pumper-card" data-target="daily-status">
                <i class="mdi mdi-fuel"></i>
                <span>Daily Status</span>
            </button>

            <button class="pumper-card" data-target="close-shift">
                <i class="mdi mdi-lock-check"></i>
                <span>Close Shift</span>
            </button>

            <button class="pumper-card" data-target="current-meter">
                <i class="mdi mdi-speedometer"></i>
                <span>Current Meter</span>
            </button>

            <button class="pumper-card" data-target="unload-stock">
                <i class="mdi mdi-truck-delivery-outline"></i>
                <span>Unload Stock</span>
            </button>
        </div>

        <!-- Content Sections -->
        <div class="content-sections">
            <!-- Pump Operators Section -->
            <div id="pump-operators" class="content-section active">
                @include('admin.petro.pumper-management.widget.pump-oparaters-table')
            </div>

            <!-- Excess & Shortage Section -->
            <div id="excess-shortage" class="content-section">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Excess & Shortage</h4>
                        <p>Content for Excess & Shortage will go here...</p>
                    </div>
                </div>
            </div>

            <!-- Day Entries Section -->
            <div id="day-entries" class="content-section">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Day Entries</h4>
                        <p>Content for Day Entries will go here...</p>
                    </div>
                </div>
            </div>

            <!-- Add similar sections for other options -->
        </div>
    </div>

    @include('admin.petro.pumper-management.models.view-details')
@endsection
<script src="{{ asset('assets/js/pumper.js') }}"></script>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.pumper-card');
        const sections = document.querySelectorAll('.content-section');

        cards.forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                cards.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked card
                this.classList.add('active');
                
                // Hide all sections
                sections.forEach(section => section.classList.remove('active'));
                
                // Show target section
                const targetId = this.getAttribute('data-target');
                const targetSection = document.getElementById(targetId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }
            });
        });
    });
</script>
@endpush