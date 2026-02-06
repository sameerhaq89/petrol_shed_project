@extends('admin.layouts.app')

@section('content')
<style>
    @media print {

        /* 1. Hide everything initially */
        body * {
            visibility: hidden;
        }

        /* 2. Make the printable area visible */
        #printable-area,
        #printable-area * {
            visibility: visible;
        }

        /* 3. Position the printable area at the top-left of the page */
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
            background: white;
            color: black !important;
            /* Force black text */
        }

        /* 4. Hide specific elements inside the printable area if needed */
        .no-print,
        .btn {
            display: none !important;
        }

        /* 5. Styling Overrides for Print */
        .card {
            border: 1px solid #ddd !important;
            box-shadow: none !important;
        }

        .card-body {
            padding: 10px !important;
        }

        /* 6. Fix Colors for Print (Black text, white backgrounds) */
        .text-white,
        .card-img-holder {
            color: black !important;
            text-shadow: none !important;
        }

        .bg-gradient-success,
        .bg-gradient-info,
        .bg-gradient-primary,
        .bg-gradient-danger {
            background: white !important;
            background-image: none !important;
        }

        /* 7. Ensure Tables are readable */
        .table {
            color: black !important;
            border-collapse: collapse !important;
        }

        .table th,
        .table td {
            border: 1px solid #ccc !important;
        }
    }
</style>
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-chart-bar"></i>
            </span> Reports
        </h3>
    </div>

    <div class="row no-print">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Generate Report</h4>
                    <p class="card-description"> Connect with your station data </p>

                    <div id="report-filters">
                        <form action="{{ route('reports.generate') }}" method="GET" class="row align-items-end">
                            <div class="col-12 mb-3">
                                <label class="d-block text-muted small mb-2">Quick Filters:</label>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" onclick="setDateRange('today')">Today</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="setDateRange('yesterday')">Yesterday</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="setDateRange('this_month')">This Month</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="setDateRange('last_month')">Last Month</button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="setDateRange('this_year')">This Year</button>
                                </div>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Report Type</label>
                                <select name="report_type" class="form-control form-control-sm" required>
                                    <option value="">Select Type</option>
                                    <option value="sales" {{ (isset($reportType) && $reportType == 'sales') ? 'selected' : '' }}>Sales Report</option>
                                    <option value="settlements" {{ (isset($reportType) && $reportType == 'settlements') ? 'selected' : '' }}>Settlements (Shifts)</option>
                                    <option value="stock" {{ (isset($reportType) && $reportType == 'stock') ? 'selected' : '' }}>Stock Movement</option>
                                    <option value="cash_drops" {{ (isset($reportType) && $reportType == 'cash_drops') ? 'selected' : '' }}>Cash Drops</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label>User (Optional)</label>
                                <select name="user_id" class="form-control form-control-sm">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ (isset($filters['user_id']) && $filters['user_id'] == $user->id) ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 form-group">
                                <label>Shift # (Optional)</label>
                                <input type="text" name="shift_number" class="form-control form-control-sm"
                                    value="{{ $filters['shift_number'] ?? '' }}" placeholder="Shift #">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" required
                                    value="{{ $filters['start_date'] ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" required
                                    value="{{ $filters['end_date'] ?? date('Y-m-d') }}">
                            </div>
                            <div class="col-md-2 form-group">
                                <button type="submit" class="btn btn-gradient-primary btn-sm w-100">Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function setDateRange(range) {
                const today = new Date();
                let start, end;

                // Helper to format date as YYYY-MM-DD
                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                };

                switch (range) {
                    case 'today':
                        start = new Date();
                        end = new Date();
                        break;
                    case 'yesterday':
                        start = new Date();
                        start.setDate(today.getDate() - 1);
                        end = new Date();
                        end.setDate(today.getDate() - 1);
                        break;
                    case 'this_month':
                        start = new Date(today.getFullYear(), today.getMonth(), 1);
                        end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                        break;
                    case 'last_month':
                        start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        end = new Date(today.getFullYear(), today.getMonth(), 0);
                        break;
                    case 'this_year':
                        start = new Date(today.getFullYear(), 0, 1);
                        end = new Date(today.getFullYear(), 11, 31);
                        break;
                }

                if (start && end) {
                    document.getElementById('start_date').value = formatDate(start);
                    document.getElementById('end_date').value = formatDate(end);
                }
            }
        </script>

        @if(isset($reportData))
        <div class="row" id="printable-area">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Results</h4>
                            <div class="no-print">
                                <button onclick="window.print()" class="btn btn-inverse-info btn-sm me-2">
                                    <i class="mdi mdi-printer btn-icon-prepend"></i> Print
                                </button>
                                <form action="{{ route('reports.export') }}" method="POST" target="_blank" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="report_type" value="{{ $reportType }}">
                                    <input type="hidden" name="start_date" value="{{ $filters['start_date'] }}">
                                    <input type="hidden" name="end_date" value="{{ $filters['end_date'] }}">
                                    <input type="hidden" name="user_id" value="{{ $filters['user_id'] ?? '' }}">
                                    <input type="hidden" name="shift_number" value="{{ $filters['shift_number'] ?? '' }}">
                                    <button type="submit" class="btn btn-inverse-success btn-sm">
                                        <i class="mdi mdi-file-export btn-icon-prepend"></i> Export CSV
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            @if($reportType === 'sales')
                            <div class="col-md-6 stretch-card grid-margin">
                                <div class="card bg-gradient-success card-img-holder text-white">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3">Total Sales Amount <i class="mdi mdi-currency-usd mdi-24px float-right"></i></h4>
                                        <h2 class="mb-5">{{ number_format($totals['total_amount'], 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 stretch-card grid-margin">
                                <div class="card bg-gradient-info card-img-holder text-white">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3">Total Quantity <i class="mdi mdi-gas-station mdi-24px float-right"></i></h4>
                                        <h2 class="mb-5">{{ number_format($totals['total_quantity'], 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                            @elseif($reportType === 'settlements')
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-primary card-img-holder text-white">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3">Total Sales <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                                        <h2 class="mb-5">{{ number_format($totals['total_sales'], 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-success card-img-holder text-white">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3">Cash Sales <i class="mdi mdi-cash mdi-24px float-right"></i></h4>
                                        <h2 class="mb-5">{{ number_format($totals['cash_sales'] ?? 0, 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card {{ $totals['total_variance'] < 0 ? 'bg-gradient-danger' : 'bg-gradient-success' }} card-img-holder text-white">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3">Total Variance <i class="mdi mdi-alert-circle-outline mdi-24px float-right"></i></h4>
                                        <h2 class="mb-5">{{ number_format($totals['total_variance'], 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                            @elseif($reportType === 'cash_drops')
                            <div class="col-md-12 stretch-card grid-margin">
                                <div class="card bg-gradient-success card-img-holder text-white">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3">Total Cash Drops <i class="mdi mdi-cash-multiple mdi-24px float-right"></i></h4>
                                        <h2 class="mb-5">{{ number_format($totals['total_amount'], 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                            @elseif($reportType === 'stock')
                            <div class="col-md-12 stretch-card grid-margin">
                                <div class="card bg-gradient-info card-img-holder text-white">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3">Total Stock Movement <i class="mdi mdi-cube-outline mdi-24px float-right"></i></h4>
                                        <h2 class="mb-5">{{ number_format($totals['total_quantity'], 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-info">
                                        @if($reportType === 'sales')
                                        <th>Date</th>
                                        <th>Fuel Type</th>
                                        <th>Pump</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                        <th>Payment</th>
                                        <th>Created By</th>
                                        @elseif($reportType === 'settlements')
                                        <th>Date</th>
                                        <th>Shift #</th>
                                        <th>User</th>
                                        <th>Total Sales</th>
                                        <th>Variance</th>
                                        <th>Status</th>
                                        @elseif($reportType === 'stock')
                                        <th>Date</th>
                                        <th>Tank</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>Reference</th>
                                        @elseif($reportType === 'cash_drops')
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Shift #</th>
                                        <th>Amount</th>
                                        <th>Notes</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reportData as $row)
                                    <tr>
                                        @if($reportType === 'sales')
                                        <td>{{ $row->sale_datetime->format('Y-m-d H:i') }}</td>
                                        <td>{{ $row->fuelType->name ?? '-' }}</td>
                                        <td>{{ $row->pump->pump_name ?? '-' }}</td>
                                        <td>{{ number_format($row->quantity, 2) }}</td>
                                        <td>{{ number_format($row->amount, 2) }}</td>
                                        <td>{{ ucfirst($row->payment_method) }}</td>
                                        <td>{{ $row->creator->name ?? '-' }}</td>
                                        @elseif($reportType === 'settlements')
                                        <td>{{ $row->shift_date }}</td>
                                        <td>{{ $row->shift_number }}</td>
                                        <td>{{ $row->user->name ?? '-' }}</td>
                                        <td>{{ number_format($row->total_sales, 2) }}</td>
                                        <td class="{{ $row->cash_variance < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($row->cash_variance, 2) }}
                                        </td>
                                        <td>
                                            <label class="badge {{ $row->status === 'closed' ? 'badge-success' : 'badge-warning' }}">
                                                {{ ucfirst($row->status) }}
                                            </label>
                                        </td>
                                        @elseif($reportType === 'stock')
                                        <td>{{ $row->created_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $row->tank->tank_name ?? '-' }}</td>
                                        <td>
                                            <label class="badge {{ $row->type === 'in' ? 'badge-success' : 'badge-danger' }}">
                                                {{ ucfirst($row->type) }}
                                            </label>
                                        </td>
                                        <td>{{ number_format($row->quantity, 2) }}</td>
                                        <td>{{ $row->reference_number ?? '-' }}</td>
                                        @elseif($reportType === 'cash_drops')
                                        <td>{{ \Carbon\Carbon::parse($row->dropped_at)->format('Y-m-d H:i') }}</td>
                                        <td>{{ $row->user->name ?? '-' }}</td>
                                        <td>{{ $row->shift->shift_number ?? '-' }}</td>
                                        <td>{{ number_format($row->amount, 2) }}</td>
                                        <td>{{ $row->notes }}</td>
                                        @endif
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No records found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endsection