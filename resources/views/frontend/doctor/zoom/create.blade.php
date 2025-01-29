@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Zoom Credential Update
@endsection
@push('styles')
<style>
    .content {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .input-group-text {
        cursor: pointer;
    }

    .btn-copy {
        cursor: pointer;
    }

    .copied-message {
        display: none;
        color: green;
    }
</style>
@endpush

@section('content')
    <section class="sidebar-sec" id="body-pd">
        <div class="container-fluid">
            <div class="sidebar-wrap d-flex justify-content-between">
                @include('frontend.doctor.partials.sidebar')

                <!-- Content -->
                <div class="sidebar-right height-100">
                    <div class="content">
                        <div class="my-app-div-wrap">
                            <div class="content-head">
                                <h2>Zoom Credential</h2>
                            </div>
                            <div class="my-profile-div">
                                <form action="{{ route('doctor.zoom.crdential.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-10">
                                        <div class="profile-form">
                                            <div class="row">
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label for="client_id">Client ID</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" value="{{ Auth::user()->zoomCredentials->client_id ?? '' }}" name="client_id" id="client_id" placeholder="Client ID">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text toggle-password" onclick="togglePassword('client_id', 'client_id_icon')">
                                                                <i id="client_id_icon" class="fas fa-eye"></i>
                                                            </span>
                                                            <a class="btn-copy" onclick="copyToClipboard('client_id')"><i class="far fa-copy"></i></a>
                                                        </div>
                                                        <span class="copied-message" id="client_id_copied">Copied !!</span>
                                                    </div>
                                                    @if ($errors->has('client_id'))
                                                        <span class="text-danger">{{ $errors->first('client_id') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label for="client_secret">Client Secret</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" value="{{ Auth::user()->zoomCredentials->client_secret ?? '' }}" name="client_secret" id="client_secret" placeholder="Client Secret">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text toggle-password" onclick="togglePassword('client_secret', 'client_secret_icon')">
                                                                <i id="client_secret_icon" class="fas fa-eye"></i>
                                                            </span>
                                                            <a class="btn-copy" onclick="copyToClipboard('client_secret')"><i class="far fa-copy"></i></a>
                                                        </div>
                                                        <span class="copied-message" id="client_secret_copied">Copied !!</span>
                                                    </div>
                                                    @if ($errors->has('client_secret'))
                                                        <span class="text-danger">{{ $errors->first('client_secret') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-lg-12 col-md-12">
                                                    <label for="account_id">Account ID</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" value="{{ Auth::user()->zoomCredentials->account_id ?? '' }}" name="account_id" id="account_id" placeholder="Account ID">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text toggle-password" onclick="togglePassword('account_id', 'account_id_icon')">
                                                                <i id="account_id_icon" class="fas fa-eye"></i>
                                                            </span>
                                                            <a class="btn-copy" onclick="copyToClipboard('account_id')"><i class="far fa-copy"></i></a>
                                                        </div>
                                                        <span class="copied-message" id="account_id_copied">Copied !!</span>
                                                    </div>
                                                    @if ($errors->has('account_id'))
                                                        <span class="text-danger">{{ $errors->first('account_id') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="main-btn-p ">
                                                        <input type="submit" value="Update" class="sub-btn">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

    function copyToClipboard(inputId) {
        const input = document.getElementById(inputId);
        const hiddenInput = document.createElement('input');
        document.body.appendChild(hiddenInput);
        hiddenInput.value = input.value;
        hiddenInput.select();
        document.execCommand('copy');
        document.body.removeChild(hiddenInput);
        const copiedMessage = document.getElementById(inputId + "_copied");
        copiedMessage.style.display = "block";
        setTimeout(function() {
            copiedMessage.style.display = "none";
        }, 1000); // Hide the message after 1 second
    }
</script>
@endpush
