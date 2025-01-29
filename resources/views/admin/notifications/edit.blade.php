@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Edit Notification
@endsection
@push('styles')
@endpush

@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notification List</a></li>
                            <li class="breadcrumb-item active">Edit Notification</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                            class="fa fa-plus"></i> Add Notification</a> --}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <h6 class="mb-0 text-uppercase">Edit A Notification</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('notifications.update', $notification->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Send To <span
                                                                style="color: red;">*</span></label>
                                                        <select name="send_to" class="form-control" id="">
                                                            <option value="">Select A Type</option>
                                                            <option value="All" @if($notification['send_to'] == "All") selected @endif>All</option>
                                                            <option value="Doctor" @if($notification['send_to'] == "Doctor") selected @endif>Doctor</option>
                                                            <option value="Patient" @if($notification['send_to'] == "Patient") selected @endif>Patient</option>
                                                        </select>
                                                        @if ($errors->has('send_to'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('send') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Message <span
                                                                style="color: red;">*</span></label>
                                                      <textarea name="message" id="" cols="30" rows="10" class="form-control">{{ $notification['message'] }}</textarea>
                                                        @if ($errors->has('message'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('message') }}</div>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="row" style="margin-top: 20px; float: left;">
                                                        <div class="col-sm-9">
                                                            <button type="submit"
                                                                class="btn px-5 submit-btn"> Update & Send Notification <i class="la la-paper-plane"></i></button>
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
            </div>

        </div>

    </div>
@endsection

@push('scripts')
   
@endpush
