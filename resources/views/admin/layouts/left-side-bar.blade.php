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
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#petro" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Petro</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-fire menu-icon"></i>
            </a>
            <div class="collapse" id="petro">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/tanks') }}">Tank Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/settlement') }}">Settlement</a>
                        <a class="nav-link" href="{{ url('/dip-management') }}">Dip Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">p2</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">p3</a>
                    </li>
                </ul>
            </div>
        </li>
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
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#purchases" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Stock Transfers</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-truck-delivery menu-icon"></i>
            </a>
            <div class="collapse" id="purchases">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">st0</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">st1</a>
                    </li>
                </ul>
            </div>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#purchases" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Stock Adjustment</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-database menu-icon"></i>
            </a>
            <div class="collapse" id="purchases">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">sa0</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">sa1</a>
                    </li>
                </ul>
            </div>
        </li> --}}
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
        {{-- <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#purchases" aria-expanded="false"
                aria-controls="ui-basic">
                <span class="menu-title">Accounting Module</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-deskphone menu-icon"></i>
            </a>
            <div class="collapse" id="purchases">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">sa0</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">sa1</a>
                    </li>
                </ul>
            </div>
        </li> --}}
    </ul>
</nav>
