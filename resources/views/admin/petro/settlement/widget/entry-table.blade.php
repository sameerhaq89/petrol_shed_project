<div class="row">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                {{-- Filter button --}}
                <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary float-end" type="button"
                    data-bs-toggle="collapse" data-bs-target="#metaFilterBodyEntry">
                    <i class="mdi mdi-filter"></i>
                    <span id="tableFilterBtnText">Show Filter</span>
                </button>
                <h3 class="page-title mb-3">Entry</h3>
                @include('admin.petro.settlement.widget.filter')
                <div class="table-responsive">
                    <table class="data-table table table-hover table-bordered w-100">
                        <thead class="bg-light">
                            <tr>
                                <th>Code</th>
                                <th>Products</th>
                                <th>Pump</th>
                                <th>Start Meter</th>
                                <th>Close Meter</th>
                                <th>Price</th>
                                <th>Sold Qty</th>
                                <th>Total Price</th>
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