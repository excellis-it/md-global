@extends('frontend.auth.master')
@section('meta_title')
@endsection
@section('title')
    Register
@endsection

@push('styles')
@endpush

@section('content')
@php
    use App\Helpers\Helper;
@endphp
<div class="login_sec_wrap">
    <div class="container-fluid login_container_fluid">
      <div class="row justify-content-end m-0">
        <div class="col-xl-6 col-lg-12 col-12 p-0">
          <div class="login_sec_left">
            <div class="login_sec_left_bg"></div>
            <div class="width_545">
              <div class="main_hh">
                <div class="login_sec_right_text">
                  <div class="login-logo">
                    @if (Helper::getLogo() != null)
                    <a href="{{ route('home') }}"><img src="{{ Storage::url(Helper::getLogo()) }}" /></a>
                    @else
                    <a href="{{ route('home') }}"><img src="{{ asset('frontend_assets/images/logo.png') }}" /></a>
                @endif

                  </div>
                  <div class="res-head pb-5">
                    <h1>
                      Let’s get started! Register your name <br />
                      and other information
                    </h1>
                  </div>
                </div>
                <div class="login_form login_form-1">
                  <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-xl-6 col-12 col-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1" class="form-label">First Name</label>
                          <input type="text" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" name="first_name" value="{{ old('first_name') }}" />
                            @if ($errors->has('first_name'))
                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                      </div>
                      <div class="col-xl-6 col-12 col-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1" class="form-label">Last Name</label>
                          <input type="text" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" name="last_name" value="{{ old('last_name') }}" />
                            @if ($errors->has('last_name'))
                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xl-6 col-12 col-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1" class="form-label">Email</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" value="{{ old('email') }}"
                            aria-describedby="emailHelp" name="email" />
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                      </div>
                      <div class="col-xl-6 col-12 col-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" value="{{ old('phone') }}"
                            aria-describedby="emailHelp" name="phone"/>
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xl-6 col-12 col-12">
                        <div class="form-group g-h">
                          <label for="exampleInputEmail1" class="form-label">Gender</label><select class="form-select"
                            aria-label="Default select example" name="gender">
                            <option selected value="">Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                          </select>
                          @if ($errors->has('gender'))
                          <div class="error" style="color:red;">
                              {{ $errors->first('gender') }}</div>
                      @endif
                        </div>
                      </div>
                      <div class="col-xl-6 col-12 col-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1" class="form-label">Age</label>
                          <input type="date" class="form-control" id="exampleInputEmail1" name="age" value="{{ old('age') }}"
                            aria-describedby="emailHelp" />
                            @if ($errors->has('age'))
                            <div class="error" style="color:red;">
                                {{ $errors->first('age') }}</div>
                        @endif
                        </div>
                      </div>
                    </div>
                    {{-- <div class="row">
                      <div class="col-xl-12 col-12 col-12">
                        <div class="form-group g-h">
                          <label for="exampleInputEmail1" class="form-label">Are you</label>
                          <div class="doc-s">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="type" id="inlineRadio1"
                                value="Doctor" checked>
                              <label class="form-check-label" for="inlineRadio1">Doctor</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="type" id="inlineRadio2"
                                value="User">
                              <label class="form-check-label" for="inlineRadio2">User</label>
                            </div>
                            @if ($errors->has('type'))
                            <div class="error" style="color:red;">
                                {{ $errors->first('type') }}</div>
                        @endif
                          </div>
                        </div>
                      </div>
                    </div> --}}
                    <div class="row">
                      <div class="col-xl-6 col-12 col-12">
                        <div class="form-group">
                          <label for="txtPassword">Password</label>
                          <div class="i-btn position-relative">
                              <input type="password" id="password-field" class="form-control" name="password" value="{{ old('password') }}"/>
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
                      <div class="col-xl-6 col-12 col-12">
                        <div class="form-group">
                          <label for="txtPassword">Confirm Password</label>
                          <div class="position-relative">
                            <input type="password" id="password-field1" class="form-control" name="confirm_password" value="{{ old('confirm_password') }}"/>
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
                      Register
                    </button>
                    <div class="login-text login-text-2 text-center">
                      <p>
                        Don’t Have an Account? <a href="{{ route('login') }}">Login</a>
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
