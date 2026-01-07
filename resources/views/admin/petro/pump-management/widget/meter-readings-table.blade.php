<div class="row d-none" id="meterReadingWidget">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                {{-- Filter button --}}
                {{-- <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary float-end" type="button"
                    data-bs-toggle="collapse" data-bs-target="#metaFilterBodyEntry">
                    <i class="mdi mdi-filter"></i>
                    <span id="tableFilterBtnText">Show Filter</span>
                </button> --}}
                <h3 class="page-title mb-3">Testing Details</h3>
                {{-- @include('admin.petro.settlement.widget.filter') --}}
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
                                <th>Sames Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meterReadings as $readings)
                            <tr>
                                <td>{{ $readings['transaction_date'] }}</td>
                                <td>{{ $readings['location'] }}</td>
                                <td>{{ $readings['settlement_no'] }}</td>
                                <td>{{ $readings['pump_no'] }}</td>
                                <td>{{ $readings['product'] }}</td>
                                <td>{{ $readings['operator'] }}</td>
                                <td>{{ $readings['sold_ltr'] }}</td>
                                <td>{{ $readings['start_meter'] }}</td>
                                <td>{{ $readings['close_meter'] }}</td>
                                <td>{{ $readings['testing_qty'] }}</td>
                                <td>{{ $readings['sale_amount'] }}</td>
                                <td class="text-center">
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