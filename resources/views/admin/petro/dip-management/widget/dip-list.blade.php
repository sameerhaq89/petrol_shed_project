{{-- <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <input class="form-control form-control-sm" id="searchDip" placeholder="Search..." style="min-width:180px;">
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="dipListTable" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Location</th>
                <th>Tank</th>
                <th>Dip Reading</th>
                <th>Qty (L)</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>127</td>
                <td>12/01/2025 17:23</td>
                <td>S.H.M Jafris Lanka</td>
                <td>LP92-1</td>
                <td>700.00</td>
                <td>4,199.00</td>
                <td>OK</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary"><i class="mdi mdi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger"><i class="mdi mdi-delete"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div> --}}

<div class="row mt-3">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">

                <div class="d-flex align-items-center mb-3 flex-wrap">
                    <h3 class="page-title mb-3">Recent Dip Entries</h3>
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
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table table table-hover table-bordered w-100" id="dipListTable">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Tank</th>
                                <th>Dip Reading</th>
                                <th>Qty (L)</th>
                                <th>Note</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>127</td>
                                <td>12/01/2025 17:23</td>
                                <td>S.H.M Jafris Lanka</td>
                                <td>LP92-1</td>
                                <td>700.00</td>
                                <td>4,199.00</td>
                                <td>OK</td>
                                <td data-label="Action" class="text-center">
                                    <div class="btn-group">
                                        <button
                                            class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view">
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
                            <tr>
                                <td>127</td>
                                <td>12/01/2025 17:23</td>
                                <td>S.H.M Jafris Lanka</td>
                                <td>LP92-1</td>
                                <td>700.00</td>
                                <td>4,199.00</td>
                                <td>OK</td>
                                <td data-label="Action" class="text-center">
                                    <div class="btn-group">
                                        <button
                                            class="btn btn-sm btn-outline-success btn-gradient-success btn-icon view">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>