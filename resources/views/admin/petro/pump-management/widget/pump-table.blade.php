<div class="row" id="pumpWidget">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                {{-- Filter button --}}
                {{-- <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary float-end" type="button"
                    data-bs-toggle="collapse" data-bs-target="#metaFilterBodyEntry">
                    <i class="mdi mdi-filter"></i>
                    <span id="tableFilterBtnText">Show Filter</span>
                </button> --}}
                <h3 class="page-title mb-3">Pump</h3>
                {{-- @include('admin.petro.settlement.widget.filter') --}}
                <div class="table-responsive">
                    <table class="data-table table table-hover table-bordered w-100">
                        <thead class="bg-light">
                            <tr>
                                <th>Date</th>
                                <th>Transaction Date</th>
                                <th>Pump No</th>
                                <th>Name</th>
                                <th>Start Meter</th>
                                <th>Current Meter</th>
                                <th>Product Name</th>
                                <th>Fuel Tanks</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pumps as $pump)
                            <tr>
                                <td>{{ $pump['date'] ?? '2026-01-07' }}</td>
                                <td>{{ $pump['transaction_date'] ?? '2026-01-07 08:00' }}</td>
                                <td>{{ $pump['pump_no'] }}</td>
                                <td>{{ $pump['name'] ?? 'Dummy Name' }}</td>
                                <td>{{ $pump['start_meter'] }}</td>
                                <td>{{ $pump['close_meter'] }}</td>
                                <td>{{ $pump['product_name'] }}</td>
                                <td>{{ $pump['fuel_tanks'] ?? 'Tank A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>