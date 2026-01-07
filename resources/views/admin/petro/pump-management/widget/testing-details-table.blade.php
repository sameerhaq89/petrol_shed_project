<div class="row d-none" id="testingWidget">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3 flex-wrap">
                    <h3 class="page-title mb-3">All Filling Station Tests</h3>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <div class="dropdown">
                            <button type="button" class="btn btn-sm btn-gradient-primary dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false" title="Export Options">
                                <i class="fa fa-download"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#"
                                        onclick="exportTableToCSV('settlement_data.csv'); return false;">
                                        <i class="fa fa-file-text-o  me-2"></i> CSV
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#"
                                        onclick="exportTableToExcel('settlement_data.xlsx'); return false;">
                                        <i class="fa fa-file-excel-o text me-2"></i> Excel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="exportTableToPDF(); return false;">
                                        <i class="fa fa-file-pdf-o me-2"></i> PDF
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="printTable(); return false;">
                                        <i class="fa fa-print me-2"></i> Print
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary float-end" type="button"
                            data-bs-toggle="collapse" data-bs-target="#testingDetailsFilterDiv">
                            <i class="mdi mdi-filter"></i>
                            <span id="tableFilterBtnText">Show Filter</span>
                        </button>
                    </div>
                </div>
                @include('admin.petro.pump-management.widget.testing-details-filter')
                <div class="table-responsive">
                    <table class="data-table table table-hover table-bordered w-100">
                        <thead class="bg-light">
                            <tr>
                                <th>Transaction Date</th>
                                <th>Location</th>
                                <th>Settlement No</th>
                                <th>Pump No</th>
                                <th>Product</th>
                                <th>Operator</th>
                                <th>Testing Ltr</th>
                                <th>Testing Sale Value</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testing_details as $test)
                            <tr>
                                <td data-label="Transaction Date">{{ $test['transaction_date'] }}</td>
                                <td data-label="Location">{{ $test['location'] }}</td>
                                <td data-label="Settlement No">{{ $test['settlement_no'] }}</td>
                                <td data-label="Pump No">{{ $test['pump_no'] }}</td>
                                <td data-label="Product">{{ $test['product'] }}</td>
                                <td data-label="Operator">{{ $test['operator'] }}</td>
                                <td data-label="Testing Ltr">{{ $test['testing_ltr'] }}</td>
                                <td data-label="Testing Sale Value">{{ $test['testing_sale_value'] }}</td>
                                <td data-label="Action" class="text-center">
                                    <div class="btn-group">
                                        <button
                                            class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view-details">
                                            <i class="mdi mdi-eye-arrow-right-outline"></i>
                                        </button>
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