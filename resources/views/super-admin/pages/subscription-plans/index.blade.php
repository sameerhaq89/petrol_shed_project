@extends('super-admin.layouts.master')

@section('title', 'Subscription Plans - SuperAdmin Panel')

@section('content')
    <div class="dashboard-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Subscription Plans</h1>
            <a href="{{ route('super-admin.plans.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Plan
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

        <!-- Plans Grid -->
        <div class="plans-grid">
            @foreach($plans as $plan)
                <div class="plan-card {{ $plan->is_trial ? 'trial-plan' : '' }} {{ !$plan->is_active ? 'inactive-plan' : '' }}">
                    <div class="plan-header">
                        <h3 class="plan-name">{{ $plan->name }}</h3>
                        @if($plan->is_trial)
                            <span class="badge badge-info">Trial</span>
                        @endif
                        @if(!$plan->is_active)
                            <span class="badge badge-secondary">Inactive</span>
                        @else
                            <span class="badge badge-success">Active</span>
                        @endif
                    </div>

                    <div class="plan-price">
                        <span class="currency">$</span>
                        <span class="amount">{{ number_format($plan->price, 2) }}</span>
                        <span class="period">/ {{ $plan->duration_days }} days</span>
                    </div>

                    <div class="plan-features">
                        <div class="feature-item">
                            <i class="fas fa-clock"></i>
                            <span>Duration: {{ $plan->duration_days }} days</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-puzzle-piece"></i>
                            <span>
                                Addons: 
                                @if($plan->max_addons == -1)
                                    Unlimited
                                @elseif($plan->max_addons == 0)
                                    None
                                @else
                                    {{ $plan->max_addons }}
                                @endif
                            </span>
                        </div>
                    </div>

                    @if($plan->description)
                        <p class="plan-description">{{ $plan->description }}</p>
                    @endif

                    <div class="plan-actions">
                        <a href="{{ route('super-admin.plans.edit', $plan->id) }}" class="btn btn-sm btn-outline">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('super-admin.plans.toggle-status', $plan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline">
                                <i class="fas fa-{{ $plan->is_active ? 'eye-slash' : 'eye' }}"></i>
                                {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form action="{{ route('super-admin.plans.destroy', $plan->id) }}" method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this plan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>

                    <div class="plan-stats">
                        <small class="text-muted">
                            {{ $plan->subscriptions()->count() }} active subscriptions
                        </small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }

        .plan-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .plan-card:hover {
            border-color: #6366f1;
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.2);
        }

        .trial-plan {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
        }

        .inactive-plan {
            opacity: 0.6;
        }

        .plan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .plan-name {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .plan-price {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 20px;
        }

        .plan-price .currency {
            font-size: 24px;
            color: #6b7280;
            vertical-align: top;
        }

        .plan-price .amount {
            font-size: 48px;
            font-weight: 700;
            color: #6366f1;
        }

        .plan-price .period {
            display: block;
            color: #6b7280;
            font-size: 14px;
            margin-top: 8px;
        }

        .plan-features {
            margin: 20px 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
            color: #4b5563;
        }

        .feature-item i {
            color: #6366f1;
            width: 20px;
        }

        .plan-description {
            color: #6b7280;
            font-size: 14px;
            margin: 16px 0;
            line-height: 1.6;
        }

        .plan-actions {
            display: flex;
            gap: 8px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            flex-wrap: wrap;
        }

        .plan-stats {
            margin-top: 12px;
            text-align: center;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-secondary {
            background: #f3f4f6;
            color: #6b7280;
        }
    </style>
@endsection
