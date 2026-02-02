<div class="row" id="pumpWidget">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 flex-wrap">
                    <h3 class="page-title mb-3 table-name">All Your Pumps</h3>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <div class="dropdown export-dropdown">
                            <button type="button" class="btn btn-sm btn-gradient-primary dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false" title="Export Options">
                                <i class="fa fa-download"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="#" data-export="copy"><i class="fa fa-copy me-2"></i>
                                        Copy</a></li>
                                <li><a class="dropdown-item" href="#" data-export="csv"><i
                                            class="fa fa-file-text-o me-2"></i> CSV</a></li>
                                <li><a class="dropdown-item" href="#" data-export="excel"><i
                                            class="fa fa-file-excel-o text me-2"></i> Excel</a>
                                </li>
                                <li><a class="dropdown-item" href="#" data-export="pdf"><i
                                            class="fa fa-file-pdf-o me-2"></i> PDF</a></li>
                                <li><a class="dropdown-item" href="#" data-export="print"><i
                                            class="fa fa-print me-2"></i> Print</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal"
                            data-bs-target="#importModal" title="Import">
                            <i class="fa fa-upload"></i> Import
                        </button>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createPumpModal">
            <i class="mdi mdi-plus"></i> Add </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table dt-export table table-hover table-bordered w-100">
                        <thead class="bg-light">
                            <tr>
                                <th>Date</th>
                                <th>Transaction Date</th>
                                <th>Pump No</th>
                                <th>Pump Name</th>
                                <th>Start Meter</th>
                                <th>Current Meter</th>
                                <th>Product Name</th>
                                <th>Tank</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pumps as $pump)
                            <tr>
                                <td data-label="Date">{{ $pump['date'] ?? '2026-01-07' }}</td>
                                <td data-label="Transaction Date">{{ $pump['transaction_date'] ?? '2026-01-07 08:00' }}
                                </td>
                                <td data-label="Pump No">{{ $pump['pump_no'] }}</td>
                                <td data-label="Pump Name">{{ $pump['name'] ?? 'Dummy Name' }}</td>
                                <td data-label="Start Meter">{{ $pump['start_meter'] }}</td>
                                <td data-label="Current Meter">{{ $pump['close_meter'] }}</td>
                                <td data-label="Product Name">{{ $pump['product_name'] }}</td>
                                <td data-label="Fuel Tank">{{ $pump['fuel_tanks'] ?? 'Tank A' }}</td>
                                <td data-label="Action" class="text-center">
    <div class="btn-group">
        {{-- 1. VIEW BUTTON (Keep existing style) --}}
        {{-- <button class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view"
                data-bs-toggle="modal"
                data-bs-target="#pumpViewDetailsModal">
            <i class="mdi mdi-eye-arrow-right-outline"></i>
        </button> --}}

        {{-- 2. EDIT BUTTON (Updated with Data Attributes) --}}
        <button type="button"
                class="btn btn-sm btn-outline-primary btn-gradient-primary btn-icon edit-pump-btn"
                data-bs-toggle="modal"
                data-bs-target="#editPumpModal"
                data-id="{{ $pump['id'] }}"
                data-number="{{ $pump['pump_no'] }}"
                data-name="{{ $pump['name'] }}"
                data-tank="{{ $pump['tank_id'] ?? '' }}"
                data-meter="{{ $pump['start_meter'] }}"
                data-status="{{ $pump['status'] ?? 'active' }}">
            <i class="mdi mdi-pencil"></i>
        </button>

        {{-- 3. DELETE BUTTON (Wrapped in Form) --}}
        <form action="{{ route('pumps.destroy', $pump['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this pump?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger btn-gradient-danger btn-icon delete" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                <i class="mdi mdi-delete"></i>
            </button>
        </form>
    </div>
</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
