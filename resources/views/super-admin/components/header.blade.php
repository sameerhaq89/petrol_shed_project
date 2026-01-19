<header class="top-header">
    <div class="header-content">
        <!-- Search Bar -->
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search" class="search-input">
        </div>

        <!-- Header Right -->
        <div class="header-right">
            <!-- Notifications -->
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>

            <!-- User Profile Dropdown -->
            <div class="user-profile-dropdown">
                <button class="user-profile-btn" id="userProfileBtn">
                    <i class="fas fa-user-circle"></i>
                    <span>Super Admin</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="profile-dropdown-menu" id="profileDropdownMenu">
                    <li><a href="{{ route('super-admin.profile') }}"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="{{ route('super-admin.settings') }}"><i class="fas fa-cog"></i> Settings</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('super-admin.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
