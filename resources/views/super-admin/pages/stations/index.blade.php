@extends('super-admin.layouts.master')

@section('title', 'Stations Management - SuperAdmin Panel')

@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <h1 class="page-title">Stations Management</h1>
        <a href="{{ route('super-admin.stations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Add New Station
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Stations Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Station Name</th>
                        <th>Location</th>
                        <th>Subscription</th>
                        <th>Status</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stations as $station)
                    <tr>
                        <td>{{ $station->id }}</td>
                        <td><strong>{{ $station->name }}</strong></td>
                        <td>{{ $station->location ?? 'N/A' }}</td>
                        <td>
                            @if($station->activeSubscription)
                            <span class="plan-badge">{{ $station->activeSubscription->plan->name }}</span>
                            @else
                            <span class="badge badge-warning">No Subscription</span>
                            @endif
                        </td>
                        <td>
                            @if($station->activeSubscription && $station->activeSubscription->isActive())
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            @if($station->activeSubscription)
                            {{ $station->activeSubscription->end_date->format('M d, Y') }}
                            <small class="text-muted d-block">
                                ({{ $station->activeSubscription->daysRemaining() }} days left)
                            </small>
                            @else
                            -
                            @endif
                        </td>
                        <td class="actions-cell">
                            <a href="{{ route('super-admin.stations.show', $station->id) }}"
                                class="btn btn-sm btn-primary" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No stations found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-top: 24px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #f9fafb;
    }

    .data-table th {
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 16px;
        border-bottom: 1px solid #e5e7eb;
        color: #6b7280;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .plan-badge {
        display: inline-block;
        padding: 4px 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        font-size: 12px;
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

    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .actions-cell {
        white-space: nowrap;
    }

    .text-muted {
        color: #9ca3af;
        font-size: 11px;
    }

    .d-block {
        display: block;
    }
</style>
@endsection