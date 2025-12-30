@extends('admin.layouts.app')
@section('content')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .card-title-header {
            font-weight: 600;
            font-size: 1rem;
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tank-progress {
            height: 12px;
            border-radius: 6px;
            background-color: #f0f0f0;
        }

        .table-custom th {
            background-color: #f8f9fa;
            color: #777;
            font-weight: 500;
            font-size: 0.75rem;
        }

        .shift-box {
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .current-shift {
            background-color: #e6f7f3;
        }

        .next-shift {
            background-color: #fff9f0;
        }

        .badge-soft-success {
            background: #d1f2eb;
            color: #1abc9c;
            border: none;
        }

        .btn-action {
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 4px;
        }

        /* ----------------------- */
        /* Section specific styles */
        .summary-card {
            border: none;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header-text {
            font-weight: 700;
            color: #2c3e50;
            font-size: 1rem;
        }

        /* Shift Containers */
        .shift-container {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #f0f0f0;
        }

        .bg-current-shift {
            background-color: #f1f9f7;
            border-left: 4px solid #48c9b0;
        }

        .bg-next-shift {
            background-color: #fffaf5;
            border: 1px solid #ffe8cc;
        }

        /* Buttons & Pills */
        .btn-pill {
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border: none;
        }

        .btn-view-upgrade {
            background-color: #6bc9b4;
            color: white;
        }

        .btn-approve {
            background-color: #d1e9e3;
            color: #48c9b0;
        }

        .btn-close-shift {
            background-color: #ffdaab;
            color: #a67c00;
        }

        .btn-receipt {
            background-color: #fcefdc;
            color: #d68910;
        }

        /* Alerts */
        .alert-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f8f9fa;
            font-size: 13px;
        }

        .alert-action-pill {
            border-radius: 15px;
            padding: 2px 12px;
            font-size: 11px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pill-red {
            background: #fee2e2;
            color: #ef4444;
        }

        .pill-green {
            background: #d1fae5;
            color: #10b981;
        }
    </style>
    <div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">
        <div class="page-header" style="margin: 0 0 0.5rem 0;">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-gas-station"></i>
                </span>
                Petrol Station Dashboard
            </h3>
            <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <span></span>Overview
                        <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="row">
            <div class="col-md-3 stretch-card" style="padding-right: unset;margin-bottom: 1rem;">
                <div class="card bg-gradient-primary card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <div class="d-flex justify-content-between">
                            <h4>Total Sales</h4>
                            <i class="mdi mdi-chart-bar mdi-24px"></i>
                        </div>
                        <h3 class="mt-2">LKR 245,700</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 stretch-card" style="padding-right: unset;margin-bottom: 1rem;">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <div class="d-flex justify-content-between">
                            <h4>Cash Collected</h4>
                            <i class="mdi mdi-cash mdi-24px"></i>
                        </div>
                        <h3 class="mt-2">LKR 12,400</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 stretch-card" style="padding-right: unset;margin-bottom: 1rem;">
                <div class="card bg-gradient-warning card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <div class="d-flex justify-content-between">
                            <h4>Open Shifts</h4>
                            <i class="mdi mdi-account-clock mdi-24px"></i>
                        </div>
                        <h3 class="mt-2">2</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 stretch-card" style="margin-bottom: 1rem;">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                        <div class="d-flex justify-content-between">
                            <h4>Low Fuel Alerts</h4>
                            <i class="mdi mdi-alert mdi-24px"></i>
                        </div>
                        <h3 class="mt-2">1</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 d-flex flex-column">
                <div class="card dashboard-card mb-3">
                    <div class="card-body">
                        <div class="card-title-header">
                            Tanks Overview
                            <div class="text-muted"><i class="mdi mdi-chevron-left"></i><i
                                    class="mdi mdi-chevron-right"></i></div>
                        </div>
                        <div class="btn-group w-100 mb-3" role="group">
                            <button class="btn btn-outline-secondary btn-sm active">Petrol 92</button>
                            <button class="btn btn-outline-secondary btn-sm">Petrol 95</button>
                        </div>
                        <div class="progress tank-progress mb-2">
                            <div class="progress-bar bg-info" style="width: 80%"></div>
                        </div>
                        <div class="row small text-muted">
                            <div class="col-6">Tank ID: 5,820 L</div>
                            <div class="col-6 text-end">Capacity: 5,820 L</div>
                        </div>
                        <hr>
                        <div class="progress tank-progress mb-2">
                            <div class="progress-bar bg-info" style="width: 40%"></div>
                        </div>
                        <div class="row small text-muted">
                            <div class="col-6">Tank ID: 3,330 L</div>
                            <div class="col-6 text-end">Capacity: 1,430 L</div>
                        </div>
                    </div>
                </div>

                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-title-header">Pumps Overview</div>
                        <table class="table table-sm table-borderless table-custom">
                            <thead>
                                <tr>
                                    <th>Pump Type</th>
                                    <th>Status</th>
                                    <th>Sale...</th>
                                    <th>Closing</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td>Pump 01</td>
                                    <td><span class="badge badge-soft-success">Active</span></td>
                                    <td>1,200L</td>
                                    <td>6,867</td>
                                </tr>
                                <tr>
                                    <td>Pump 02</td>
                                    <td><span class="badge badge-soft-success">Active</span></td>
                                    <td>900L</td>
                                    <td>6,140</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 d-flex flex-column">
                <div class="card dashboard-card mb-3">
                    <div class="card-body">
                        <div class="card-title-header">Fuel Stock & Dip Management</div>
                        <table class="table table-sm table-custom">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Current Stock</th>
                                    <th>Last Dip</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td>Petrol 92</td>
                                    <td>5,820 L</td>
                                    <td>5,700 L</td>
                                </tr>
                                <tr>
                                    <td>Petrol 95</td>
                                    <td>8,100 L</td>
                                    <td class="text-danger">8,230 L</td>
                                </tr>
                                <tr>
                                    <td>Diesel</td>
                                    <td>3,330 L</td>
                                    <td class="text-danger">3,350 L</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-end small"><a href="#">View Dip History ></a></div>
                    </div>
                </div>

                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-title-header">Sales Summary <span class="text-primary">LKR 66,200</span></div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                <div class="small mb-1">Cash</div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 75%"></div>
                                </div>
                            </div>
                            <div class="ms-2 badge bg-success">75%</div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                <div class="small mb-1">Card</div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger" style="width: 20%"></div>
                                </div>
                            </div>
                            <div class="ms-2 badge bg-danger">20%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 d-flex flex-column">
                <div class="card dashboard-card mb-3">
                    <div class="card-body">
                        <div class="card-title-header">Shift & Settlement Summary</div>

                        <div class="shift-box current-shift">
                            <span class="badge bg-success mb-2">Current Shift</span>
                            <div class="small"><strong>Morning Shift</strong> (6:00 AM - 2:00 PM)</div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="small">John Silva</span>
                                <span class="text-success fw-bold">40,000 LKR</span>
                            </div>
                            <div class="mt-2 d-flex gap-1">
                                <button class="btn btn-success btn-action">Approve</button>
                                <button class="btn btn-outline-secondary btn-action">Receipt</button>
                            </div>
                        </div>

                        <div class="shift-box next-shift">
                            <span class="text-danger small fw-bold">Next Shift</span>
                            <div class="small">Evening Shift (2:00 PM - 10:00 PM)</div>
                            <div class="text-muted x-small mt-1">Variance: 5.00 LKR</div>
                            <button class="btn btn-warning btn-action mt-2 w-100">Close Shift</button>
                        </div>
                    </div>
                </div>

                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-title-header">Alerts</div>
                        <div class="alert alert-light border small d-flex justify-content-between">
                            Low Fuel Alert: Petrol 92 <span class="text-danger">Run ></span>
                        </div>
                        <div class="alert alert-light border small d-flex justify-content-between">
                            Shift Not Closed: Evening <span class="text-danger">Close ></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>
@endsection
