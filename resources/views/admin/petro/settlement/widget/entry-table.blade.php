<div class="row">
    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                <div class="d-flex align-items-center flex-wrap">
                    <h3 class="page-title mb-3">Entry</h3>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary float-end" type="button"
                            data-bs-toggle="collapse" data-bs-target="#metaFilterBodyEntry">
                            <i class="mdi mdi-filter"></i>
                            <span id="tableFilterBtnText">Show Filter</span>
                        </button>
                    </div>
                </div>

                @include('admin.petro.settlement.widget.filter')

                <div class="table-responsive">
                    <table class="table table-hover table-bordered w-100">
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
    {{-- DYNAMIC LOOP --}}
    @forelse($shift->sales as $sale)
    <tr>
        {{-- Sale Number --}}
        <td class="text-primary font-weight-bold">
            {{ $sale->sale_number }}
        </td>

        {{-- Product Name --}}
        <td>
            {{ $sale->fuelType->name ?? 'Unknown Fuel' }}
        </td>

        {{-- Pump Name --}}
        <td>
            <span class="badge badge-outline-info">
                {{ $sale->pump->pump_name ?? $sale->pump->pump_number }}
            </span>
        </td>

        {{-- Start Meter (USE DATABASE VALUE, NOT CALCULATION) --}}
        <td>
            {{ number_format($sale->start_reading, 2) }}
        </td>

        {{-- Close Meter (USE DATABASE VALUE) --}}
        <td>
            {{ number_format($sale->end_reading, 2) }}
        </td>

        {{-- Price --}}
        <td>{{ number_format($sale->rate, 2) }}</td>

        {{-- Qty --}}
        <td class="font-weight-bold">{{ number_format($sale->quantity, 2) }}</td>

        {{-- Total --}}
        <td class="text-success font-weight-bold">{{ number_format($sale->amount, 2) }}</td>

        {{-- Delete Button --}}
        <td>
            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Delete this entry?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-gradient-danger btn-sm btn-icon">
                    <i class="mdi mdi-delete"></i>
                </button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="text-center py-4 text-muted">
            <i class="mdi mdi-gas-station me-2"></i> No sales recorded for Shift #{{ $shift->id }}.
        </td>
    </tr>
    @endforelse
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
