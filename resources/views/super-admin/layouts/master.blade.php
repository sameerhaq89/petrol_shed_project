<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SuperAdmin Panel')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/super-admin/style.css') }}">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>

<body>
    <div class="super-admin-wrapper">
        <!-- Sidebar -->
        @include('super-admin.components.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            @include('super-admin.components.header')

            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/super-admin/script.js') }}"></script>
    @stack('scripts')
</body>

</html>
