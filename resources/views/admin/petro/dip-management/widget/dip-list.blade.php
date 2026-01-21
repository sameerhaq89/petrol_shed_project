<div class="row mt-4">
    <div class="col-12">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                <h5 class="card-title mb-3">Recent Dip Entries</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped custom-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Tank</th>
                                <th>Product</th>
                                <th class="text-end">Dip Level (cm)</th>
                                <th class="text-end">Volume (L)</th>
                                <th class="text-end">Temp (°C)</th>
                                <th>Recorded By</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
    @forelse($dip_readings as $dip)
        <tr>
            <td>{{ $dip['date'] }}</td>
            <td>
                <strong>{{ $dip['tank_name'] }}</strong>
            </td>
            <td>
                <span class="badge bg-inverse-info">{{ $dip['fuel_type'] }}</span>
            </td>
            <td class="text-end">{{ $dip['dip_level'] }}</td>
            <td class="text-end font-weight-bold text-success">{{ $dip['volume'] }}</td>
            <td class="text-end">{{ $dip['temperature'] }}</td>
            <td>
                <small class="text-muted">{{ $dip['recorded_by'] }}</small>
            </td>
            <td>{{ $dip['notes'] }}</td>
            
            {{-- NEW ACTION COLUMN --}}
            <td class="text-center">
                {{-- Edit Button --}}
                <button type="button" 
        class="btn btn-sm btn-outline-primary btn-icon edit-dip-btn"
        data-bs-toggle="modal" 
        data-bs-target="#editDipModal"
        
        data-id="{{ $dip['id'] }}"
        data-date="{{ $dip['date'] }}"
        
        {{-- USE THE NEW KEYS HERE --}}
        data-tank="{{ $dip['tank_id'] }}" 
        data-level="{{ $dip['raw_level'] }}" 
        data-volume="{{ $dip['raw_volume'] }}" 
        data-temp="{{ $dip['raw_temp'] }}"
        
        data-notes="{{ $dip['notes'] }}">
    <i class="mdi mdi-pencil"></i>
</button>
                {{-- Delete Button --}}
                <form action="{{ route('dip-management.destroy', $dip['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger btn-icon">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center text-muted py-4">
                <i class="mdi mdi-alert-circle-outline me-1"></i> No dip readings found.
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