<div class="row">
    <div class="col-12">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary" type="button"
                    data-bs-toggle="collapse" data-bs-target="#metaFilterBody">
                    <i class="mdi mdi-filter"></i>
                    <span id="tableFilterBtnText">Show Filter</span>
                </button>
            </div>

            <div class="mb-3">
                @include('admin.petro.settlement.widget.filter')
            </div>

            <div class="table-responsive">
                <table class="data-table table table-hover table-bordered w-100">
                    <thead class="bg-light">
                        <tr>
                            <th>Date</th>
                            <th>Transaction Date</th>
                            <th>Pump No</th>
                            <th>Pump Name</th>
                            <th>Current Meter</th>
                            <th>Product Name</th>
                            <th>Fuel Tank</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Code</td>
                            <td>Products</td>
                            <td>Pump</td>
                            <td>Start Meter</td>
                            <td>Close Meter</td>
                            <td>Price</td>
                            <td>Sold Qty</td>
                            <td class="text-center">Action</td>
                        </tr>
                        <tr>
                            <td>Code</td>
                            <td>Products</td>
                            <td>Pump</td>
                            <td>Start Meter</td>
                            <td>Close Meter</td>
                            <td>Price</td>
                            <td>Sold Qty</td>
                            <td class="text-center">Action</td>
                        </tr>
                        <tr>
                            <td>Code</td>
                            <td>Products</td>
                            <td>Pump</td>
                            <td>Start Meter</td>
                            <td>Close Meter</td>
                            <td>Price</td>
                            <td>Sold Qty</td>
                            <td class="text-center">Action</td>
                        </tr>
                        <!-- more rows -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>