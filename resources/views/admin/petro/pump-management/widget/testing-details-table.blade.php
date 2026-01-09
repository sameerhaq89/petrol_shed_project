<div class="row d-none" id="testingWidget">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2 flex-wrap">
                    <h3 class="page-title mb-3 table-name">All Filling Station Tests</h3>
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
                                <th>Settlement</th>
                                <th>Pump No</th>
                                <th>Product</th>
                                <th>Operator</th>
                                <th>Leter</th>
                                <th>Sale Value</th>
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
                                            class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view"
                                            data-bs-toggle="modal" data-bs-target="#testViewDetailsModal">
                                            <i class="mdi mdi-eye-arrow-right-outline"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-outline-primary btn-gradient-primary btn-icon edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        <button
                                            class="btn btn-sm btn-outline-danger btn-gradient-danger btn-icon delete">
                                            <i class="mdi mdi-delete"></i>
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