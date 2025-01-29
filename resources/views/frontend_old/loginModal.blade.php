@extends('frontend.auth.master')
@section('meta_title')
@endsection
@section('title')
    Login
@endsection

@push('styles')
@endpush

@section('content')

<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Please Login!!</p>

        <form class="" action="{{ route('login.check') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" class="form-label">Email ID</label>
                <input type="text" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" value="{{ old('email') }}" name="email" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="txtPassword">Password</label>
                <div class="position-relative">
                    <input type="password" id="password-field" class="form-control"
                        name="password" />
                    <button type="button" id="btnToggle" class="toggle">
                        <i id="eyeIcon" toggle="#password-field" class="fa fa-eye-slash toggle"></i>
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
                    Don’t Have an Account? <a href="{{ route('register') }}">Register NOW</a>
                </p>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close" data-bs-target="#mySidenav" data-bs-toggle="modal" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        $('.modal').modal('show');
        //toggle modal when click on close button
        $('.close').click(function(){
            $('.modal').modal('hide');
            window.location.href = "{{ url('/') }}";
        });
    });
</script>


@endpush