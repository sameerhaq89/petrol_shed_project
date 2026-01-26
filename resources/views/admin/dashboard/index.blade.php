@extends('admin.layouts.app')
@section('content')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        .card-title-header {
            font-weight: 600;
            font-size: 1rem;
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .tank-progress {
            height: 12px;
            border-radius: 6px;
            background-color: #f0f0f0;
        }
        .table-custom th {
            background-color: #f8f9fa;
            color: #777;
            font-weight: 500;
            font-size: 0.75rem;
        }
        .shift-box {
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .current-shift {
            background-color: #e6f7f3;
        }
        .next-shift {
            background-color: #fff9f0;
        }
        .badge-soft-success {
            background: #d1f2eb;
            color: #1abc9c;
            border: none;
        }
        .btn-action {
            font-size: 0.7rem;
            padding: 4px 10px;
            border-radius: 4px;
        }
        .command-font-size {
            font-size: 0.8em !important;
        }
        .command-row-gap {
            --bs-gutter-x: 12px !important;
        }
    </style>

    <div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">

        @include('admin.command.widgets.page-header', $pageHeader)

        <div class="row command-row-gap">
            <div class="col-md-3 stretch-card" style="margin-bottom: 1rem;">
                <div class="card bg-gradient-primary card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <div class="d-flex justify-content-between">
                            <h4>Total Sales (Today)</h4>
                            <i class="mdi mdi-chart-bar mdi-24px"></i>
                        </div>
                        <h3 class="mt-2">LKR {{ number_format($totalSalesToday, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 stretch-card" style="margin-bottom: 1rem;">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <div class="d-flex justify-content-between">
                            <h4>Cash Collected (Drops)</h4>
                            <i class="mdi mdi-cash mdi-24px"></i>
                        </div>
                        {{-- UPDATED: Uses the physical drops variable --}}
                        <h3 class="mt-2">LKR {{ number_format($cashDropsToday, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 stretch-card" style="margin-bottom: 1rem;">
                <div class="card bg-gradient-warning card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <div class="d-flex justify-content-between">
                            <h4>Open Shifts</h4>
                            <i class="mdi mdi-account-clock mdi-24px"></i>
                        </div>
                        <h3 class="mt-2">{{ $openShiftsCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 stretch-card" style="margin-bottom: 1rem;">
                <div class="card bg-gradient-{{ $lowFuelAlertsCount > 0 ? 'danger' : 'secondary' }} card-img-holder text-white">
                    <div class="card-body">
                        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <div class="d-flex justify-content-between">
                            <h4>Low Fuel Alerts</h4>
                            <i class="mdi mdi-alert mdi-24px"></i>
                        </div>
                        <h3 class="mt-2">{{ $lowFuelAlertsCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row command-row-gap">
            <div class="col-lg-4 d-flex flex-column">
                <div class="card dashboard-card mb-3">
                    <div class="card-body command-font-size">
                        <div class="card-title-header">
                            Tanks Overview
                        </div>
                        <div class="btn-group w-100 mb-3" role="group" id="tankFilterBtns">
                            @foreach($fuelFilterButtons as $index => $btn)
                                <button class="btn btn-outline-secondary btn-sm {{ $index == 0 ? 'active' : '' }}"
                                        data-type="{{ $btn['code'] }}">
                                    {{ $btn['label'] }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Tank 1 Slot --}}
                        <div class="progress tank-progress mb-2">
                            <div class="progress-bar bg-gradient-info" id="tankProgress1" style="width: 0%"></div>
                        </div>
                        <div class="row small text-muted">
                            <div class="col-6">Tank: <span id="tank1Id">#</span> (<span id="tank1Current">0</span> L)</div>
                            <div class="col-6 text-end">Cap: <span id="tank1Capacity">0</span> L</div>
                        </div>
                        <hr>
                        {{-- Tank 2 Slot --}}
                        <div class="progress tank-progress mb-2">
                            <div class="progress-bar bg-gradient-info" id="tankProgress2" style="width: 0%"></div>
                        </div>
                        <div class="row small text-muted">
                            <div class="col-6">Tank: <span id="tank2Id">#</span> (<span id="tank2Current">0</span> L)</div>
                            <div class="col-6 text-end">Cap: <span id="tank2Capacity">0</span> L</div>
                        </div>
                    </div>
                </div>

                <div class="card dashboard-card">
                    <div class="card-body command-font-size">
                        <div class="card-title-header">Pumps Overview</div>
                        <table class="table table-sm table-borderless table-custom">
                            <thead>
                            <tr>
                                <th>Pump</th>
                                <th>Status</th>
                                <th>Vol.</th>
                                <th>Reading</th>
                            </tr>
                            </thead>
                            <tbody class="small command-font-size">
                            @forelse($pumps as $pump)
                                <tr>
                                    <td>{{ $pump->pump_name }}</td>
                                    <td>
                                        <span class="badge badge-soft-{{ $pump->status === 'active' ? 'success' : ($pump->status === 'maintenance' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($pump->status) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($pump->todays_volume) }}L</td>
                                    <td>{{ number_format($pump->current_reading) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center">No pumps found.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 d-flex flex-column">
                <div class="card dashboard-card mb-3">
                    <div class="card-body command-font-size">
                        <div class="card-title-header">Fuel Stock Summary</div>
                        <table class="table table-sm table-custom">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Current Stock</th>
                                <th>Last Dip</th>
                            </tr>
                            </thead>
                            <tbody class="small command-font-size">
                            @foreach($fuelStockSummary as $stock)
                                <tr>
                                    <td>{{ $stock['name'] }}</td>
                                    <td class="fw-bold">{{ number_format($stock['current_stock']) }} L</td>
                                    <td class="text-muted">{{ number_format($stock['last_dip']) }} L</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{-- Make sure dip-management route exists or change to # --}}
                        <div class="text-end small mt-2"><a href="{{ route('dip-management.index') }}">View Dip History ></a></div>
                    </div>
                </div>

                <div class="card dashboard-card command-font-size">
                    <div class="card-body">
                        <div class="card-title-header">Sales Split (Today) <span class="text-primary">LKR {{ number_format($totalSalesForSplit) }}</span></div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                {{-- Updated: Uses Cash Sales (Meter) for graph context --}}
                                <div class="small mb-1">Cash (LKR {{ number_format($cashSalesToday) }})</div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-gradient-success" style="width: {{ $cashPercent }}%"></div>
                                </div>
                            </div>
                            <div class="ms-2 badge bg-success">{{ $cashPercent }}%</div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-grow-1">
                                <div class="small mb-1">Card (LKR {{ number_format($cardSalesToday) }})</div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-gradient-danger" style="width: {{ $cardPercent }}%"></div>
                                </div>
                            </div>
                            <div class="ms-2 badge bg-danger">{{ $cardPercent }}%</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 d-flex flex-column">
                <div class="card dashboard-card mb-3">
                    <div class="card-body command-font-size">
                        <div class="card-title-header">Shift & Settlement Summary</div>

                        @if($currentShift)
                        <div class="shift-box current-shift">
                            <span class="badge bg-gradient-success mb-2">Current Open Shift</span>
                            <div class="small"><strong>#{{ $currentShift->shift_number }}</strong> (Started: {{ \Carbon\Carbon::parse($currentShift->start_time)->format('h:i A') }})</div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="small">{{ $currentShift->user->name ?? 'Unknown' }}</span>
                                <span class="text-success fw-bold">Est. Sales: {{ number_format($currentShift->total_sales) }} LKR</span>
                            </div>
                            <div class="mt-2 d-flex gap-1">
                                <a href="{{ route('settlement.entry', $currentShift->id) }}" class="btn btn-gradient-success btn-action text-white">Manage / Close Shift</a>
                            </div>
                        </div>
                        @else
                            <div class="alert alert-warning small">No shift is currently open.</div>
                        @endif

                        <div class="shift-box next-shift">
                            @if($lastClosedShift)
                                <span class="text-muted small fw-bold">Last Closed Shift</span>
                                <div class="small mt-1">#{{ $lastClosedShift->shift_number }}</div>
                                <div class="{{ $lastClosedShift->cash_variance < 0 ? 'text-danger' : 'text-success' }} x-small mt-1 fw-bold">
                                    Variance: {{ number_format($lastClosedShift->cash_variance, 2) }} LKR
                                </div>
                            @else
                                 <span class="text-muted small fw-bold">Next Shift</span>
                                <div class="small mt-1">Waiting for new shift...</div>
                            @endif
                                <a href="{{ route('settlement-list.index') }}" class="btn btn-gradient-warning btn-action mt-2 w-100">View All Settlements</a>
                        </div>
                    </div>
                </div>

                <div class="card dashboard-card command-font-size">
                    <div class="card-body">
                        <div class="card-title-header">Alerts</div>
                        @forelse($lowFuelTanks as $tank)
                        <div class="alert alert-danger border-danger small d-flex justify-content-between mb-1 p-2">
                            <span>Low Fuel: <strong>{{ $tank->fuelType->name }}</strong> ({{ $tank->tank_number }})</span>
                            <a href="#" class="text-danger fw-bold">View ></a>
                        </div>
                        @empty
                            <div class="text-muted small text-center">No critical alerts.</div>
                        @endforelse

                        @if($openShiftsCount > 1)
                            <div class="alert alert-warning border-warning small d-flex justify-content-between mb-1 p-2 mt-2">
                                <span>Multiple shifts are open!</span>
                                <a href="{{ route('settlement-list.index') }}" class="text-warning fw-bold">Fix ></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        const TANKS_DATA = @json($tanksDataForJs);

        document.addEventListener('DOMContentLoaded', function() {
            const btnGroup = document.getElementById('tankFilterBtns');
            const btns = btnGroup?.querySelectorAll('button[data-type]') || [];

            function setActive(btn) {
                btns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            }

            function updateView(type) {
                const data = TANKS_DATA[type];

                const p1 = document.getElementById('tankProgress1');
                const t1id = document.getElementById('tank1Id');
                const t1c = document.getElementById('tank1Current');
                const t1cap = document.getElementById('tank1Capacity');

                const p2 = document.getElementById('tankProgress2');
                const t2id = document.getElementById('tank2Id');
                const t2c = document.getElementById('tank2Current');
                const t2cap = document.getElementById('tank2Capacity');

                if(p1) p1.style.width = '0%'; t1c.innerText = '-'; t1cap.innerText = '-'; t1id.innerText = '#';
                if(p2) p2.style.width = '0%'; t2c.innerText = '-'; t2cap.innerText = '-'; t2id.innerText = '#';

                if (!data || !data.tanks) return;

                if (data.tanks[0]) {
                    const a = data.tanks[0];
                    if (p1) {
                        p1.style.width = (a.percent || 0) + '%';
                        p1.className = 'progress-bar ' + (a.percent < 20 ? 'bg-danger' : 'bg-info');
                    }
                    if (t1id) t1id.textContent = a.id;
                    if (t1c) t1c.textContent = (a.current || 0).toLocaleString();
                    if (t1cap) t1cap.textContent = (a.capacity || 0).toLocaleString();
                }

                if (data.tanks[1]) {
                    const b = data.tanks[1];
                    if (p2) {
                        p2.style.width = (b.percent || 0) + '%';
                        p2.className = 'progress-bar ' + (b.percent < 20 ? 'bg-danger' : 'bg-info');
                    }
                    if (t2id) t2id.textContent = b.id;
                    if (t2c) t2c.textContent = (b.current || 0).toLocaleString();
                    if (t2cap) t2cap.textContent = (b.capacity || 0).toLocaleString();
                }
            }

            btns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const type = this.getAttribute('data-type');
                    setActive(this);
                    updateView(type);
                });
            });

            const active = btnGroup?.querySelector('button.active');
            if (active) updateView(active.getAttribute('data-type'));
        });
    </script>
@endsection
