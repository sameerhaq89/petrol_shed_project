@extends('super-admin.layouts.master')

@section('title', 'Station Details - SuperAdmin Panel')

@section('content')
    <div class="dashboard-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">{{ $station->name }}</h1>
            <a href="{{ route('super-admin.stations.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Back to Stations
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

        <div class="content-grid-two">
            <!-- Station Info Card -->
            <div class="info-card">
                <h3 class="card-title">Station Information</h3>
                <div class="info-group">
                    <label>Station Name:</label>
                    <p>{{ $station->name }}</p>
                </div>
                <div class="info-group">
                    <label>Location:</label>
                    <p>{{ $station->location ?? 'N/A' }}</p>
                </div>
                <div class="info-group">
                    <label>Created:</label>
                    <p>{{ $station->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Current Subscription Card -->
            <div class="info-card subscription-card">
                <h3 class="card-title">Current Subscription</h3>
                
                @if($activeSubscription)
                    <div class="subscription-details">
                        <div class="plan-header">
                            <h4>{{ $activeSubscription->plan->name }}</h4>
                            <span class="badge badge-{{ $activeSubscription->isActive() ? 'success' : 'danger' }}">
                                {{ $activeSubscription->status }}
                            </span>
                        </div>

                        <div class="info-group">
                            <label>Price:</label>
                            <p>${{ number_format($activeSubscription->plan->price, 2) }}</p>
                        </div>

                        <div class="info-group">
                            <label>Start Date:</label>
                            <p>{{ $activeSubscription->start_date->format('M d, Y') }}</p>
                        </div>

                        <div class="info-group">
                            <label>End Date:</label>
                            <p>{{ $activeSubscription->end_date->format('M d, Y') }}</p>
                        </div>

                        <div class="info-group">
                            <label>Days Remaining:</label>
                            <p class="{{ $activeSubscription->daysRemaining() <= 7 ? 'text-danger' : '' }}">
                                {{ $activeSubscription->daysRemaining() }} days
                            </p>
                        </div>

                        <div class="info-group">
                            <label>Max Addons:</label>
                            <p>
                                @if($activeSubscription->plan->max_addons == -1)
                                    Unlimited
                                @else
                                    {{ $activeSubscription->plan->max_addons }}
                                @endif
                            </p>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No active subscription</p>
                @endif

                <!-- Assign New Subscription Button -->
                <button type="button" class="btn btn-primary w-full mt-3" onclick="toggleAssignForm()">
                    <i class="fas fa-plus"></i> Assign New Subscription
                </button>
            </div>
        </div>

        <!-- Assign Subscription Form (Hidden by default) -->
        <div id="assignForm" class="form-card" style="display: none;">
            <h3 class="card-title">Assign Subscription Plan</h3>
            <form action="{{ route('super-admin.stations.assign-subscription', $station->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="subscription_plan_id">Select Plan *</label>
                    <select id="subscription_plan_id" name="subscription_plan_id" class="form-control" required>
                        <option value="">Choose a plan...</option>
                        @foreach(\App\Models\SubscriptionPlan::active()->get() as $plan)
                            <option value="{{ $plan->id }}">
                                {{ $plan->name }} - ${{ number_format($plan->price, 2) }} 
                                ({{ $plan->duration_days }} days, {{ $plan->max_addons == -1 ? 'Unlimited' : $plan->max_addons }} addons)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" 
                           value="{{ date('Y-m-d') }}">
                    <small class="form-text">Leave blank to start today</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Assign Subscription
                    </button>
                    <button type="button" class="btn btn-outline" onclick="toggleAssignForm()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Enabled Addons Section -->
        <div class="addons-section">
            <div class="section-header">
                <h3 class="card-title">Enabled Addons</h3>
                <a href="{{ route('super-admin.stations.manage-addons', $station->id) }}" class="btn btn-primary">
                    <i class="fas fa-cog"></i> Manage Addons
                </a>
            </div>

            <div class="addons-grid-compact">
                @forelse($stationAddons as $stationAddon)
                    <div class="addon-compact-card">
                        <div class="addon-icon-small">
                            <i class="{{ $stationAddon->addon->icon ?? 'fas fa-puzzle-piece' }}"></i>
                        </div>
                        <div class="addon-info">
                            <h4>{{ $stationAddon->addon->name }}</h4>
                            <small class="text-muted">Enabled {{ $stationAddon->enabled_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No addons enabled</p>
                @endforelse
            </div>
        </div>

        <!-- Subscription History -->
        <div class="history-card">
            <h3 class="card-title">Subscription History</h3>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptionHistory as $sub)
                            <tr>
                                <td><strong>{{ $sub->plan->name }}</strong></td>
                                <td>{{ $sub->start_date->format('M d, Y') }}</td>
                                <td>{{ $sub->end_date->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $sub->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $sub->status }}
                                    </span>
                                </td>
                                <td>${{ number_format($sub->plan->price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No subscription history</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .content-grid-two {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }

        .info-card, .form-card, .history-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .form-card {
            margin-top: 24px;
        }

        .subscription-card {
            border: 2px solid #6366f1;
        }

        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e5e7eb;
        }

        .info-group {
            margin-bottom: 16px;
        }

        .info-group label {
            display: block;
            font-weight: 600;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .info-group p {
            color: #1f2937;
            font-size: 16px;
            margin: 0;
        }

        .plan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .plan-header h4 {
            margin: 0;
            color: #6366f1;
            font-size: 24px;
        }

        .addons-section {
            margin-top: 24px;
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .addons-grid-compact {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .addon-compact-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .addon-icon-small {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .addon-icon-small i {
            color: white;
            font-size: 18px;
        }

        .addon-info h4 {
            margin: 0;
            font-size: 14px;
            color: #1f2937;
        }

        .history-card {
            margin-top: 24px;
        }

        .w-full {
            width: 100%;
        }

        .mt-3 {
            margin-top: 16px;
        }

        .text-danger {
            color: #ef4444;
            font-weight: 600;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-secondary {
            background: #f3f4f6;
            color: #6b7280;
        }
    </style>

    <script>
        function toggleAssignForm() {
            const form = document.getElementById('assignForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
@endsection
