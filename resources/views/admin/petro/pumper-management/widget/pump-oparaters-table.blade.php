<div class="row">
    <div class="col-12 mb-4 stretch-card">
        <div class=" card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3 flex-wrap">
                    <h3 class="page-title mb-3 table-name">Summary Table</h3>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <div class="dropdown export-dropdown">
                            <button type="button" class="btn btn-sm btn-gradient-primary dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false" title="Export Options">
                                <i class="fa fa-download"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="#" data-export="copy"><i
                                            class="fa fa-copy me-2"></i>
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
                        <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary" type="button"
                            data-bs-toggle="collapse" data-bs-target="#metaFilterBody">
                            <i class="mdi mdi-filter"></i>
                            <span id="tableFilterBtnText">Show Filter</span>
                        </button>
                    </div>
                </div>
                @include('admin.petro.pumper-management.widget.filter')
                <div class="table-responsive">
                    <table class="data-table table table-hover table-bordered w-100">
                        <thead class="bg-light">
                            <tr>
                                <th>Pump Operator</th>
                                <th>Location</th>
                                <th>Sold Fuel Qty(lts)</th>
                                <th>Sale Amount Fuel</th>
                                <th>Excess Amount</th>
                                <th>Short Amount</th>
                                <th>Current Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
