{{-- Replace 'layouts.admin' with your actual layout name from other pages --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4 mt-3">
            <div class="col-md-12">
                <h3 class="text-dark">Pumper Financial Ledger</h3>
                <p class="text-muted">Detailed history of shortages and settlements for individual operators.</p>
            </div>
        </div>

        <div class="card shadow border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Ledger: {{ $pumper->name }}</h5>
                {{-- This badge shows the total remaining debt, like the Rs. 5,000.00 float --}}
                <span class="badge badge-warning p-2">Total Owed: Rs. {{ number_format($currentBalance, 2) }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Type</th>
                                <th class="text-end">Amount</th>
                                <th class="text-end">Balance Owed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ledgerEntries as $entry)
                                <tr>
                                    <td>{{ $entry->created_at->format('d M Y') }}</td>
                                    <td>{{ $entry->remarks }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $entry->type == 'shortage' ? 'badge-danger' : 'badge-success' }}">
                                            {{ ucfirst($entry->type) }}
                                        </span>
                                    </td>
                                    <td class="text-end font-weight-bold">
                                        {{-- Payments are shown as negative to reduce the balance --}}
                                        {{ $entry->type == 'payment' ? '-' : '' }} {{ number_format($entry->amount, 2) }}
                                    </td>
                                    <td class="text-end font-weight-bold">{{ number_format($entry->running_balance, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-folder-open fa-3x text-light mb-3"></i><br>
                                        No ledger history found for this pumper.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('pumper.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Management
            </a>
        </div>
    </div>
@endsection
