<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <!-- provide the csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title')</title>
    @php
        use App\Helpers\Helper;
    @endphp
    @if (Helper::getFavicon() != null)
        <link rel="shortcut icon" type="image/png" href="{{ Storage::url(Helper::getFavicon()) }}" />
    @else
        <link rel="shortcut icon" type="image/png" href="{{ asset('admin_assets/img/favicon.ico') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/material.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/plugins/morris/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('admin_assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/css/jquery.dataTables.min.css') }}">
    @stack('styles')
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <!--header-->
    @include('admin.includes.header')

    <!--end header-->
    <!--sidebar-wrapper-->
    @include('admin.includes.sidebar')
    <!--end sidebar-wrapper-->

    <!--page-wrapper-->
    @yield('content')

    <!--end page-wrapper-->

    <!--footer -->
    @include('admin.includes.footer')

    <!-- end footer -->

</body>
<script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="{{ asset('admin_assets/js/jquery-3.6.0.min.js') }}"></script>

<script src="{{ asset('admin_assets/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('admin_assets/js/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('admin_assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/chart.js') }}"></script>
<script src="{{ asset('admin_assets/js/greedynav.js') }}"></script>
<script src="{{ asset('admin_assets/js/select2.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/bootstrap-datetimepicker.min.js') }}"></script>

<script src="{{ asset('admin_assets/js/layout.js') }}"></script>
<script src="{{ asset('admin_assets/js/theme-settings.js') }}"></script>
<script src="{{ asset('admin_assets/js/app.js') }}"></script>

<script src="{{ asset('admin_assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/jquery.validate.min.js') }}"></script>

<script src="{{ asset('admin_assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/sweetalert2.all.min.js') }}"></script>

<script>
    @if (Session::has('message'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('message') }}");
    @endif

    @if (Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
    @endif

    @if (Session::has('info'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.info("{{ session('info') }}");
    @endif

    @if (Session::has('warning'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
<script>
    $(document).ready(function() {
        toastr.options = {
            // 'closeButton': true,
            // 'debug': false,
            // 'newestOnTop': false,
            // 'progressBar': false,
            'positionClass': 'toast-top-center',
            // 'preventDuplicates': false,
            'showDuration': '10',
            'hideDuration': '10',
            'timeOut': '800',
            'extendedTimeOut': '800',
            // 'showEasing': 'swing',
            // 'hideEasing': 'linear',
            // 'showMethod': 'fadeIn',
            // 'hideMethod': 'fadeOut',
        }
    });
</script>

@stack('scripts')

</html>
