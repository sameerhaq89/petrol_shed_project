@extends('super-admin.layouts.master')

@section('title', 'Manage Addons - SuperAdmin Panel')

@section('content')
    <div class="dashboard-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Manage Addons - {{ $station->name }}</h1>
            <a href="{{ route('super-admin.stations.show', $station->id) }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Back to Station
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Subscription Info -->
        @if($activeSubscription)
            <div class="subscription-info-banner">
                <div class="banner-content">
                    <h3>{{ $activeSubscription->plan->name }}</h3>
                    <p>
                        Max Addons: 
                        <strong>
                            @if($activeSubscription->plan->max_addons == -1)
                                Unlimited
                            @else
                                {{ $activeSubscription->plan->max_addons }}
                            @endif
                        </strong>
                    </p>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                This station has no active subscription. Please assign a subscription first.
            </div>
        @endif

        <!-- Addons Selection Form -->
        @if($activeSubscription)
            <form action="{{ route('super-admin.stations.update-addons', $station->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="addons-selection-grid">
                    @foreach($allAddons as $addon)
                        <div class="addon-selection-card">
                            <input type="checkbox" 
                                   name="addons[]" 
                                   value="{{ $addon->id }}" 
                                   id="addon_{{ $addon->id }}"
                                   {{ in_array($addon->id, $enabledAddonIds) ? 'checked' : '' }}>
                            
                            <label for="addon_{{ $addon->id }}" class="addon-label">
                                <div class="addon-icon">
                                    <i class="{{ $addon->icon ?? 'fas fa-puzzle-piece' }}"></i>
                                </div>
                                <div class="addon-details">
                                    <h4>{{ $addon->name }}</h4>
                                    @if($addon->description)
                                        <p class="addon-desc">{{ $addon->description }}</p>
                                    @endif
                                </div>
                                <div class="check-indicator">
                                    <i class="fas fa-check"></i>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-actions-sticky">
                    <div class="selected-counter">
                        Selected: <span id="selectedCount">{{ count($enabledAddonIds) }}</span>
                        @if($activeSubscription->plan->max_addons > 0)
                            / {{ $activeSubscription->plan->max_addons }}
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save Addons
                    </button>
                </div>
            </form>
        @endif
    </div>

    <style>
        .subscription-info-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 32px;
        }

        .banner-content h3 {
            margin: 0 0 8px 0;
            font-size: 24px;
        }

        .banner-content p {
            margin: 0;
            opacity: 0.9;
        }

        .addons-selection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 100px;
        }

        .addon-selection-card {
            position: relative;
        }

        .addon-selection-card input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .addon-label {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .addon-label:hover {
            border-color: #6366f1;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }

        .addon-selection-card input[type="checkbox"]:checked + .addon-label {
            border-color: #6366f1;
            background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
        }

        .addon-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .addon-icon i {
            font-size: 24px;
            color: white;
        }

        .addon-details {
            flex: 1;
        }

        .addon-details h4 {
            margin: 0 0 4px 0;
            font-size: 16px;
            color: #1f2937;
        }

        .addon-desc {
            margin: 0;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.4;
        }

        .check-indicator {
            width: 28px;
            height: 28px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .check-indicator i {
            color: white;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .addon-selection-card input[type="checkbox"]:checked + .addon-label .check-indicator {
            background: #6366f1;
            border-color: #6366f1;
        }

        .addon-selection-card input[type="checkbox"]:checked + .addon-label .check-indicator i {
            opacity: 1;
        }

        .form-actions-sticky {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 20px;
            box-shadow: 0 -4px 16px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }

        .selected-counter {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
        }

        .selected-counter span {
            color: #6366f1;
        }

        .btn-lg {
            padding: 14px 32px;
            font-size: 16px;
        }
    </style>

    <script>
        // Count selected addons
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="addons[]"]');
            const counter = document.getElementById('selectedCount');
            const maxAddons = {{ $activeSubscription ? $activeSubscription->plan->max_addons : 0 }};

            function updateCount() {
                const checked = document.querySelectorAll('input[name="addons[]"]:checked').length;
                counter.textContent = checked;

                // Disable unchecked boxes if limit reached
                if (maxAddons > 0 && checked >= maxAddons) {
                    checkboxes.forEach(cb => {
                        if (!cb.checked) {
                            cb.disabled = true;
                            cb.closest('.addon-selection-card').style.opacity = '0.5';
                        }
                    });
                } else {
                    checkboxes.forEach(cb => {
                        cb.disabled = false;
                        cb.closest('.addon-selection-card').style.opacity = '1';
                    });
                }
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateCount);
            });

            updateCount();
        });
    </script>
@endsection
