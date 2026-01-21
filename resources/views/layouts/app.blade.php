<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Purple Admin') }}</title>

    {{-- 1. FIXED ASSET PATHS (Removed ../..) --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    
    {{-- Layout styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    
    {{-- Stack for specific page CSS --}}
    @stack('css')
</head>

<body>
    <div class="container-scroller">
        {{-- 2. YIELD CONTENT --}}
        @yield('content')
    </div>

    {{-- 3. INCLUDE QUICK ACTIONS --}}
    {{-- Ensure this file exists at: resources/views/admin/common/quick-actions.blade.php --}}
   

    {{-- 4. CORE SCRIPTS --}}
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    
    {{-- Stack for specific page JS --}}
    @stack('js')

</body>
</html>