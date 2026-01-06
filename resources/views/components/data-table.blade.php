@props([
'tables' => []
])

@foreach($tables as $table)
<div class="row {{ !empty($table['class']) ? implode(' ', $table['class']) : '' }}" id="{{ $table['id'] ?? '' }}">

    <div class="col-12 mb-4 stretch-card">
        <div class="card border-primary shadow-sm" style="border-top: 3px solid;">
            <div class="card-body">
                <h3 class="page-title mb-3">{{ $table['title'] }}</h3>
                <div class="table-responsive">
                    <table class="data-table table table-hover table-bordered w-100">
                        <thead class="bg-light">
                            <tr>
                                @foreach($table['columns'] as $col)
                                <th>{{ $col }}</th>
                                @endforeach
                                @if(!empty($table['Action']))
                                <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($table['rows'] ?? [] as $row)
                            <tr>
                                @foreach($row as $cell)
                                <td>{{ $cell }}</td>
                                @endforeach

                                @if(!empty($table['Action']))
                                <td class="text-center">
                                    <div class="btn-group">
                                        @if(in_array('view', $table['Action']))
                                        <button class="btn btn-sm btn-outline-success btn-icon view">
                                            <i class="mdi mdi-eye-arrow-right-outline"></i>
                                        </button>
                                        @endif
                                        @if(in_array('edit', $table['Action']))
                                        <button class="btn btn-sm btn-outline-primary btn-icon edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        @endif
                                        @if(in_array('delete', $table['Action']))
                                        <button class="btn btn-sm btn-outline-danger btn-icon delete">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach