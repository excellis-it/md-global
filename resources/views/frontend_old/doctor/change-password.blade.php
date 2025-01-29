@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
   Medical Staff Notifications
@endsection
@push('styles')
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
                            <div class="content-head-wrap d-flex justify-content-between align-items-center">
                                <div class="content-head mb-4">
                                    <h2>Manage Service Centers Address</h2>
                                    <h3><a href="{{ route('doctor.dashboard') }}">Dashboard</a>  / Manage Service Centers Address</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="clinical-consultation-wrap">
                                        <div class="add-address-wrap">
                                            <div class="add-address-form-box">
                                                <form action="{{ route('doctor.change.password.submit') }}" name="form"
                                                    id="submitForm" method="POST">
                                                    @csrf
                                                    <div class="row g-3">
                                                        <div class="form-group col-lg-6 col-md-12">
                                                            <input type="password" class="form-control" id="current_password"
                                                                name="current_password" value=""
                                                                placeholder="Current Password" >
                                                            @if ($errors->has('current_password'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('current_password') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="form-group col-lg-6 col-md-12">
                                                            <input type="password" class="form-control" id="new_password"
                                                                name="new_password" value=""
                                                                placeholder="New Password" >
                                                            @if ($errors->has('new_password'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('new_password') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="form-group col-lg-6 col-md-12">
                                                            <input type="password" class="form-control" id="confirm_password"
                                                                name="confirm_password" value=""
                                                                placeholder="Confirm Password" >
                                                            @if ($errors->has('confirm_password'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-4 col-lg-4 col-12">
                                                            <div class="main-btn-p pt-4">
                                                                <input type="submit" value="SAVE" class="sub-btn">
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
                    </div>
    </section>
@endsection

@push('scripts')
<script>

</script>
@endpush
