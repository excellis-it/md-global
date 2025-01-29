@extends('frontend.auth.master')
@section('meta_title')
@endsection
@section('title')
    Forget Password
@endsection

@push('styles')
@endpush

@section('content')
    <div class="login_sec_wrap">
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-xl-6 col-lg-12 col-12 p-0">
                    <div class="login_sec_left">
                        <div class="login_sec_left_bg"></div>
                        <div class="width_545">
                            <div class="main_hh">
                                <div class="login_sec_right_text">
                                    <div class="login-logo">
                                        <a href="{{ route('home') }}"><img
                                                src="{{ asset('frontend_assets/images/logo-t.png') }}" /></a>
                                    </div>
                                    <div class="login-logo-head">
                                        <h1>Forget Password</h1>
                                        <p>
                                            Enter your email and we'll send you OTP to reset password.
                                        </p>
                                    </div>
                                </div>
                                <div class="login_form">
                                    <form class="" action="{{ route('forget.password.submit') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Email ID</label>
                                            <input type="text" class="form-control" id="exampleInputEmail1"
                                                aria-describedby="emailHelp" value="{{ old('email') }}" name="email" />
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                        <button class="btn btn-lg btn-primary btn-block btn-login">
                                            Send OTP
                                        </button>
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
@endpush
