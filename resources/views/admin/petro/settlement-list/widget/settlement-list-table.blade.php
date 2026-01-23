<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card border-primary shadow-sm" style="border-left: 5px solid #b66dff;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Settlement History</h4>
                    {{-- Optional: Add Filter/Export buttons here --}}
                </div>

                <div class="table-responsive">
                    <table class="table table-hover" id="settlementTable">
                        <thead>
                            <tr class="bg-light">
                                <th># Settlement ID</th>
                                <th>Date</th>
                                <th>Station</th>
                                <th>Total Sales</th>
                                <th>Cash Collected</th>
                                <th>Variance</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($settlements as $settlement)
                            <tr>
                                <td class="font-weight-bold text-primary">
                                    {{ $settlement->shift_number }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($settlement->shift_date)->format('d M Y') }}</td>
                                <td>{{ $settlement->station->name ?? 'N/A' }}</td>
                                <td class="font-weight-bold">
                                    {{ number_format($settlement->total_sales, 2) }}
                                </td>
                                <td>
                                    {{ number_format($settlement->closing_cash, 2) }}
                                </td>
                                <td class="{{ $settlement->cash_variance < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($settlement->cash_variance, 2) }}
                                </td>
                                <td>
                                    <span class="badge badge-outline-success">Settled</span>
                                </td>
                                <td>
                                    {{-- View Details Button --}}
                                    <button type="button"
                                            class="btn btn-sm btn-gradient-primary btn-icon"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewDetailsModal"
                                            onclick="loadSettlementDetails({{ $settlement->id }})">
                                        <i class="mdi mdi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="mdi mdi-file-document-outline" style="font-size: 30px;"></i><br>
                                    No settlement records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (if you use paginate() in controller later) --}}
                {{-- <div class="mt-3">
                    {{ $settlements->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</div>

<script>
    // Simple script to handle loading details if you aren't using a separate page
    function loadSettlementDetails(id) {
        // You can fetch details via AJAX or redirect
        // For now, let's just redirect to the shift show page
        window.location.href = "/settlement/" + id;
    }
</script>
