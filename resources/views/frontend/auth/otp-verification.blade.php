@extends('frontend.auth.master')
@section('meta_title')
@endsection
@section('title')
    Otp Verification
@endsection

@push('styles')
<style>
  

.otp-form .otp-field {
	display: inline-block;
	width: 4rem;
	height: 4rem;
	font-size: 2rem;
	line-height: 4rem;
	text-align: center;
	border: none;
	border-bottom: 2px solid var(--bs-secondary);
	outline: none;
}

.otp-form .otp-field:focus {
	border-bottom-color: var(--bs-dark);
}

</style>
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
                                        <h1>OTP Verification</h1>
                                        <p>
                                            Enter your email and we'll send you OTP to reset password.
                                        </p>
                                    </div>
                                </div>
                                <div class="login_form">
                                    <form action="{{ route('otp.verification.submit') }}" class="otp-form" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                        <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                        <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                        <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                        <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                                        <input class="otp-field" type="text" name="opt-field[]" maxlength=1>
                
                                        <!-- Store OTP Value -->
                                        <input class="otp-value" type="hidden" name="otp">
                                        @if($errors->has('otp'))
                                            <span class="text-danger">{{ $errors->first('otp') }}</span>
                                        @endif
                                        <div class="d-block mt-4">
                                            <button class="btn btn-lg btn-primary btn-block btn-login" type="submit">Verify</button>
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
        $(document).ready(function() {
            $(".otp-form *:input[type!=hidden]:first").focus();
            let otp_fields = $(".otp-form .otp-field"),
                otp_value_field = $(".otp-form .otp-value");
            otp_fields
                .on("input", function(e) {
                    $(this).val(
                        $(this)
                        .val()
                        .replace(/[^0-9]/g, "")
                    );
                    let opt_value = "";
                    otp_fields.each(function() {
                        let field_value = $(this).val();
                        if (field_value != "") opt_value += field_value;
                    });
                    otp_value_field.val(opt_value);
                })
                .on("keyup", function(e) {
                    let key = e.keyCode || e.charCode;
                    if (key == 8 || key == 46 || key == 37 || key == 40) {
                        // Backspace or Delete or Left Arrow or Down Arrow
                        $(this).prev().focus();
                    } else if (key == 38 || key == 39 || $(this).val() != "") {
                        // Right Arrow or Top Arrow or Value not empty
                        $(this).next().focus();
                    }
                })
                .on("paste", function(e) {
                    let paste_data = e.originalEvent.clipboardData.getData("text");
                    let paste_data_splitted = paste_data.split("");
                    $.each(paste_data_splitted, function(index, value) {
                        otp_fields.eq(index).val(value);
                    });
                });
        });
    </script>
@endpush
