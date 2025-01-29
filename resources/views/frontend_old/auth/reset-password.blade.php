@extends('frontend.auth.master')
@section('meta_title')
@endsection
@section('title')
    Change Password
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
                    <a href="{{ route('home') }}"><img src="{{ asset('frontend_assets/images/logo-t.png') }}" /></a>
                  </div>
                  <div class="res-head pb-5">
                    <h1>
                      Change your password
                    </h1>
                  </div>
                </div>
                <div class="login_form login_form-1">
                  <form action="{{ route('reset.password.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="row">
                      <div class="col-xl-12 col-12 col-12">
                        <div class="form-group">
                          <label for="txtPassword">New Password</label>
                          <div class="i-btn position-relative">
                              <input type="password" id="password-field" class="form-control" name="password" />
                              <button type="button" id="btnToggle" class="toggle">
                               <i id="eyeIcon" class="fa fa-eye-slash" toggle="#password-field"></i>
                                </button>
                          </div>
                          @if($errors->has('password'))
                            <div class="error" style="color:red;">
                                {{ $errors->first('password') }}</div>
                        @endif
                        </div>
                      </div>
                      <div class="col-xl-12 col-12 col-12">
                        <div class="form-group">
                          <label for="txtPassword">Confirm Password</label>
                          <div class="position-relative">
                            <input type="password" id="password-field1" class="form-control" name="confirm_password" />
                            <button type="button" id="btnToggle" class="toggle">
                            <i id="eyeIcon1" class="fa fa-eye-slash" toggle="#password-field1"></i>
                            </button>  
                          </div>
                            @if($errors->has('confirm_password'))
                                <div class="error" style="color:red;">
                                    {{ $errors->first('confirm_password') }}</div>
                            @endif
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-login">
                      Change Password
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
<script>
  $("#eyeIcon1").click(function() {
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
