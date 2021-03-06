<!DOCTYPE html>
<html lang="en">
    @include('layouts.header')
<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large clearfix">
        <!--=============== Top Bar Start ================-->
        @include('admin.layouts.top_bar')
        <!--=============== Top Bar End ================-->

        <!--=============== Left side Start ================-->
        @include('admin.layouts.sidebar')
        <!--=============== Left side End ================-->

        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            @yield('content')
        <!-- ============ Body content End ============= -->
        <!-- ============ Footer Start ============= -->
            @include('admin.layouts.footer')
        <!-- ============ Footer End ============= -->
        </div>
    </div>
<!--=============== End app-admin-wrap ================-->
@include('admin.layouts.script')
@yield('script')
</body>

</html>