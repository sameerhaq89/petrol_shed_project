@extends('admin.layouts.app')
@section('content')
    <style>
        .command-row-gap {
            --bs-gutter-x: 12px !important;
        }

        .tank-card {
            border-radius: 20px;
            background: #fff;
            transition: transform 0.2s;
        }

        .tank-card:hover {
            transform: translateY(-5px);
        }

        .tank-visual-container {
            position: relative;
            width: 100%;
            height: 180px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            margin-top: 10px;
        }

        .tank-body {
            position: relative;
            width: 120px;
            height: 160px;
            background: #f0f3f7;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .tank-liquid {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            transition: height 1.0s ease-in-out;
            background: linear-gradient(to bottom, #a1c4fd 0%, #c2e9fb 100%);
        }


        .tank-liquid.blue {
            background: linear-gradient(to bottom, #4facfe 0%, #00f2fe 100%);
        }

        .tank-liquid.green,
        .tank-liquid.emerald {
            background: linear-gradient(to bottom, #43e97b 0%, #38f9d7 100%);
        }

        .tank-liquid.orange,
        .tank-liquid.red {
            background: linear-gradient(to bottom, #fa709a 0%, #fee140 100%);
        }

        .tank-liquid.purple {
            background: linear-gradient(to bottom, #a18cd1 0%, #fbc2eb 100%);
        }


        .tank-percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: 800;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }


        .tank-alert {
            position: absolute;
            bottom: 15px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            background: rgba(255, 0, 0, 0.7);
            padding: 2px 0;
        }


        .tank-cap {
            position: absolute;
            top: 0;
            width: 40px;
            height: 4px;
            background-color: #00d25b;
            border-radius: 2px;
        }
    </style>

    <div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">

       
        @include('admin.command.widgets.page-header', $pageHeader)

        <div class="row mt-3 command-row-gap">
            @if (isset($tanks) && count($tanks) > 0)
                @foreach ($tanks as $tank)
                    @include('admin.petro.tank-management.widget.tank-overview', $tank)
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i> No tank data available. Please add tanks to the system.
                    </div>
                </div>
            @endif
        </div>


        <div class="page-header mt-2">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-water-pump"></i>
                </span> Fuel Pump Distribution
            </h3>
        </div>

        <div class="row">
            @if (isset($pumps) && count($pumps) > 0)
                @foreach ($pumps as $pump)
                    @include('admin.petro.tank-management.widget.pump-distribution', $pump)
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i> No pump data available. Please add pumps to the system.
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('admin.petro.tank-management.widget.create-tank-modal')

@endsection

@section('scripts')
    <script>
        document.getElementById('recordDipBtn')?.addEventListener('click', function() {

            alert('Record New Dip functionality will be implemented here');
        });


        setInterval(function() {
            location.reload();
        }, 300000);
    </script>
@endsection
