@extends('frontend.auth.master')
@section('meta_title')
@endsection
@section('title')
   Medical Staff Login
@endsection

@push('styles')
@endpush

@section('content')
    @php
        use App\Helpers\Helper;
    @endphp
    <div class="login_sec_wrap">
        <div class="container-fluid login_container_fluid">
            <div class="row m-0 justify-content-end">
                <div class="col-xl-6 col-lg-12 col-12 p-0">
                    <div class="login_sec_left">
                        <div class="login_sec_left_bg"></div>
                        <div class="width_545">
                            <div class="main_hh">
                                <div class="login_sec_right_text">
                                    <div class="login-logo">
                                        @if (Helper::getLogo() != null)
                                            <a href="{{ route('home') }}"><img
                                                    src="{{ Storage::url(Helper::getLogo()) }}" /></a>
                                        @else
                                            <a href="{{ route('home') }}"><img
                                                    src="{{ asset('frontend_assets/images/logo.png') }}" /></a>
                                        @endif

                                    </div>
                                    <div class="login-logo-head">
                                        <h1>Login to explore more</h1>
                                        <p>
                                            Log in to access your account and explore personalized features.
                                        </p>
                                    </div>
                                </div>
                                <div class="login_form">
                                    <form class="" action="{{ route('login.medical-stuff') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="type" value="doctor_login_page">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Email ID</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1"
                                                aria-describedby="emailHelp" value="{{ old('email') }}" name="email" />
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                         {{-- user_type patient or doctor --}}
                                         {{-- <div class="form-group">
                                            <label for="user_type">Select User Type:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="user_type"
                                                    id="patientRadio" value="patient"  {{ old('user_type') == 'patient' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="patientRadio">
                                                    Patient
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="user_type"
                                                    id="doctorRadio" value="doctor" {{ old('user_type') == 'doctor' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="doctorRadio">
                                                   Medical Staff
                                                </label>
                                            </div>

                                            @if ($errors->has('user_type'))
                                                <span class="text-danger">{{ $errors->first('user_type') }}</span>
                                            @endif
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="txtPassword">Password</label>
                                            <div class="position-relative">
                                                <input type="password" id="password-field" class="form-control"
                                                    name="password" />
                                                <button type="button" id="btnToggle" class="toggle">
                                                    <i id="eyeIcon" toggle="#password-field"
                                                        class="fa fa-eye-slash toggle"></i>
                                                </button>
                                            </div>
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                            <div class="login-text text-right">
                                                <p>
                                                    <a href="{{ route('forget.password') }}">Forgot Password?</a>
                                                </p>
                                            </div>
                                        </div>

                                        <button class="btn btn-lg btn-primary btn-block btn-login">
                                            LOGIN
                                        </button>
                                        <div class="login-text login-text-2 text-center">
                                            <p>
                                                Don’t Have an Account? <a href="{{ route('medical-stuff.register') }}">Register NOW</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $("#eyeIcon").click(function() {
            // alert('d')
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endpush
