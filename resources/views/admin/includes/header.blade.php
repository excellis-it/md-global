@php
    use App\Helpers\Helper;
@endphp
<div class="main-wrapper">
    <div class="header">
        <div class="header-left mt-2">
            @if (Helper::getLogo() != null)
                <a href="{{ route('home') }}"><img src="{{ Storage::url(Helper::getLogo()) }}" width="70" height="40"
                        alt="" /></a>
            @else
                <a href="{{ route('home') }}"><img src="{{ asset('admin_assets/img/logo2.png') }}" width="60"
                        height="40" alt="" /></a>
            @endif

        </div>
        <a id="toggle_btn" href="{{ route('home') }}">
            <span class="bar-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </a>

        <div class="page-title-box">
            <h3>Welcome to admin panel</h3>
        </div>

        <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu">

            <li class="nav-item dropdown has-arrow main-drop">
                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                    <span class="user-img">
                        @if (Auth::user()->profile_picture)
                            <img src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="">
                        @else
                            <img src="{{ asset('admin_assets/img/profiles/avatar-21.jpg') }}" alt="">
                        @endif
                        <span class="status online"></span>
                    </span>
                    <span>Admin</span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a>
                    <a class="dropdown-item" href="{{ route('admin.password') }}">Change Password</a>
                    <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                </div>
            </li>
        </ul>

        <div class="dropdown mobile-user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                    class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a>
                <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
            </div>
        </div>
    </div>
