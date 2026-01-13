<div class="row d-none" id="meterReadingWidget">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3 flex-wrap">
                    <h3 class="page-title mb-3">Meter Readings</h3>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary float-end" type="button"
                            data-bs-toggle="collapse" data-bs-target="#meterReadingsFilterDiv">
                            <i class="mdi mdi-filter"></i>
                            <span id="tableFilterBtnText">Show Filter</span>
                        </button>
                    </div>
                </div>
                @include('admin.petro.pump-management.widget.meter-reading-table-filter')
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
                                <th>Sold Ltr</th>
                                <th>Start Meter</th>
                                <th>Close Meter</th>
                                <th>Testing Qty</th>
                                <th>Sales Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($meter_readings as $reading)
                            <tr>
                                <td data-label="Transaction Date">{{ $readings['transaction_date'] }}</td>
                                <td data-label="Location">{{ $readings['location'] }}</td>
                                <td data-label="Settlement No">{{ $readings['settlement_no'] }}</td>
                                <td data-label="Pump No">{{ $readings['pump_no'] }}</td>
                                <td data-label="Product">{{ $readings['product'] }}</td>
                                <td data-label="Operator">{{ $readings['operator'] }}</td>
                                <td data-label="Sold Ltr">{{ $readings['sold_ltr'] }}</td>
                                <td data-label="Start Meter">{{ $readings['start_meter'] }}</td>
                                <td data-label="Close Meter">{{ $readings['close_meter'] }}</td>
                                <td data-label="Testing Qty">{{ $readings['testing_qty'] }}</td>
                                <td data-label="Sales Amount">{{ $readings['sale_amount'] }}</td>
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