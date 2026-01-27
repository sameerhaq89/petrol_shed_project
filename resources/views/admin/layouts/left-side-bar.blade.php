<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile" />
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    {{-- <span class="text-secondary text-small">Project Manager</span> --}}
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#purchases" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Products</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-package menu-icon"></i>
            </a>
            <div class="collapse" id="purchases">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">p0</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">p1</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">p2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">p3</a>
                    </li>
                </ul>
            </div>
        </li> --}}
        @can('users.create')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <span class="menu-title">User Management</span>
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
            </li>
        @endcan
        @can('roles.view')
            <li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('roles.index') }}">
                    <span class="menu-title">Role Management</span>
                    <i class="mdi mdi-shield-account menu-icon"></i>
                </a>
            </li>
        @endcan


        @can('view.admin.sidebar')
            @php
                $petroAddons = ['tank-management', 'settlement', 'settlement-list', 'pump-management', 'pumper-management', 'dip-management', 'fuel-management'];
                $hasPetroAccess = false;
                $user = auth()->user();
                
                // Only check addons if user has a station assigned
                if ($user && $user->station_id) {
                    $service = app(\App\Services\SubscriptionService::class);
                    foreach ($petroAddons as $addon) {
                        if ($service->hasAddon($user->station_id, $addon)) {
                            $hasPetroAccess = true;
                            break;
                        }
                    }
                }
            @endphp

            @if($hasPetroAccess)
                <li class="nav-item {{ Request::is('tanks*', 'pumps*', 'fuel-prices*', 'fuel-types*') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#petro" aria-expanded="false" aria-controls="ui-basic">
                        <span class="menu-title">Petro</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-fire menu-icon"></i>
                    </a>
                    <div class="collapse" id="petro">
                        <ul class="nav flex-column sub-menu">
                            @hasAddon('tank-management')
                                <li class="nav-item {{ Request::is('tanks*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/tanks') }}">Tank Management</a>
                                </li>
                            @endhasAddon

                            @hasAddon('settlement')
                                <li class="nav-item {{ Request::is('settlement*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/settlement') }}">Settlement</a>
                                </li>
                            @endhasAddon

                            @hasAddon('settlement-list')
                                <li class="nav-item {{ Request::is('settlement-list*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/settlement-list') }}">Settlement List</a>
                                </li>
                            @endhasAddon

                            @hasAddon('pump-management')
                                <li class="nav-item {{ Request::is('pumps*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/pumps') }}">Pump Management</a>
                                </li>
                            @endhasAddon

                            @hasAddon('pumper-management')
                                <li class="nav-item {{ Request::is('pumper-management*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/pumper-management') }}">Pumper Management</a>
                                </li>
                            @endhasAddon

                            @hasAddon('dip-management')
                                <li class="nav-item {{ Request::is('dip-management*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ url('/dip-management') }}">Dip Management</a>
                                </li>
                            @endhasAddon

                            @hasAddon('fuel-management')
                                <li class="nav-item {{ Request::is('fuel-management*') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('fuel-management.index') }}">
                                        <span class="menu-title">Fuel Management</span>
                                    </a>
                                </li>
                            @endhasAddon
                        </ul>
                    </div>
                </li>
            @endif
        @endcan

        @can('sales.entry.access')
            @hasAddon('sales-entry')
                <li class="nav-item {{ Request::is('pumper/sales*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('pumper.sales.entry') }}">
                        <span class="menu-title">Sales Entry</span>
                        <i class="mdi mdi-gas-station menu-icon"></i>
                    </a>
                </li>
            @endhasAddon
        @endcan

        {{-- @can('view.admin.sidebar')
            <li class="nav-item {{ Request::is('/add-purchases') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#purchases" aria-expanded="false"
                    aria-controls="ui-basic">
                    <span class="menu-title">Purchases</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-cart menu-icon"></i>
                </a>
                <div class="collapse" id="purchases">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('add-purchases') }}">Add Purchase</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Add Bulk Purchases</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">List Purchases</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">List Return Purchases</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Import Purchases</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ Request::is('/add-expenses') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#expenses" aria-expanded="false"
                    aria-controls="ui-basic">
                    <span class="menu-title">Expenses</span>
                    <i class="menu-arrow"></i>
                    <i class="mdi mdi-currency-usd menu-icon"></i>
                </a>
                <div class="collapse" id="expenses">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('add-expenses') }}">Add Expenses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">List Expenses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Expenses Category</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Expenses Setting</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endcan --}}
    </ul>
</nav>
