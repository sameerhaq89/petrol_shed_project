@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-danger text-white">
                    <h4 class="mb-0"><i class="mdi mdi-lock-clock me-2"></i>Close Pumper Duty</h4>
                </div>
                
                <form action="{{ route('pumper.process-close', $assignment->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        {{-- FIX: Changed $assignment->user->name to $assignment->pumper->name --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="text-muted">Pumper: <span class="text-dark font-weight-bold">{{ $assignment->pumper->name ?? 'Unknown' }}</span></h5>
                            <span class="badge badge-outline-primary">{{ $assignment->pump->pump_name ?? 'N/A' }}</span>
                        </div>

                        <div class="alert alert-light border">
                            <small class="text-muted d-block">Duty Started At:</small>
                            <strong>{{ \Carbon\Carbon::parse($assignment->start_time)->format('h:i A') }}</strong>
                            <hr class="my-2">
                            <small class="text-muted d-block">Opening Meter Reading:</small>
                            <strong class="text-primary">{{ number_format($assignment->opening_reading, 2) }}</strong>
                        </div>

                        {{-- 1. Meter Reading --}}
                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark">Final Pump Reading (Meter)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="closing_reading" class="form-control form-control-lg border-danger" 
                                       value="{{ $assignment->pump->current_reading }}" required>
                                <span class="input-group-text bg-danger text-white">Liters</span>
                            </div>
                            <small class="text-danger">Enter the actual meter reading from the pump right now.</small>
                        </div>

                        {{-- 2. Physical Cash --}}
                        <div class="form-group mb-4">
    <label for="closing_cash_received" class="font-weight-bold text-dark">
        Final Cash Handover (LKR)
    </label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text bg-gradient-primary text-white">Rs.</span>
        </div>
        <input type="number" 
               step="0.01" 
               name="closing_cash_received" 
               id="closing_cash_received" 
               class="form-control form-control-lg border-primary" 
               placeholder="e.g. 9800.00" 
               required>
    </div>
    <small class="text-muted">Enter the total physical cash handed over by the pumper at the end of duty.</small>
</div>

                        <button type="submit" class="btn btn-gradient-danger btn-lg w-100 font-weight-bold">
                            <i class="mdi mdi-check-circle-outline me-2"></i> Finalize & Close Duty
                        </button>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('pumper.index') }}" class="text-muted small">Cancel and go back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection