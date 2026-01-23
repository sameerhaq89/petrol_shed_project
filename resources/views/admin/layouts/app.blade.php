<!DOCTYPE html>
<html>
@include('admin.layouts.head')
@stack('css')

<body>
    <div class="container-scroller">

        @include('admin.layouts.header')

        <div class="container-fluid page-body-wrapper">

            @include('admin.layouts.left-side-bar')

            <div class="main-panel">
                @yield('content')
                @include('admin.common.quick-actions')
                @include('admin.layouts.footer')
            </div>
            
        </div>

    </div>

    <!-- js -->
    @include('admin.layouts.script')
    @stack('js')
    @yield('scripts')
</body>

</html>
