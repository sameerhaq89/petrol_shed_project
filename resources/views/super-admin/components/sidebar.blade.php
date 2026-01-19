<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="fas fa-chart-line"></i>
            <span>SuperAdmin Panel</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('super-admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('super-admin.subscriptions*') ? 'active' : '' }}">
                <a href="{{ route('super-admin.subscriptions') }}" class="nav-link">
                    <i class="fas fa-credit-card"></i>
                    <span>Subscriptions</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('super-admin.stations*') ? 'active' : '' }}">
                <a href="{{ route('super-admin.stations') }}" class="nav-link">
                    <i class="fas fa-gas-pump"></i>
                    <span>Stations</span>
                </a>
            </li>

            <li class="nav-item has-dropdown {{ request()->routeIs('super-admin.users*') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('super-admin.users.list') }}">All Users</a></li>
                    <li><a href="{{ route('super-admin.users.admins') }}">Admins</a></li>
                    <li><a href="{{ route('super-admin.users.staff') }}">Staff</a></li>
                </ul>
            </li>

            <li class="nav-item has-dropdown {{ request()->routeIs('super-admin.extras*') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-th"></i>
                    <span>Extras</span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('super-admin.extras.reports') }}">Reports</a></li>
                    <li><a href="{{ route('super-admin.extras.analytics') }}">Analytics</a></li>
                    <li><a href="{{ route('super-admin.extras.logs') }}">Logs</a></li>
                </ul>
            </li>

            <li class="nav-item {{ request()->routeIs('super-admin.settings*') ? 'active' : '' }}">
                <a href="{{ route('super-admin.settings') }}" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('super-admin.logout') }}" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('super-admin.logout') }}" method="POST"
                    style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</aside>
