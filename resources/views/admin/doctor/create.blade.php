@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | CreateMedical Staff
@endsection
@push('styles')
@endpush

@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Create</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('medical-stuff.index') }}">Medical Stuff</a></li>
                            <li class="breadcrumb-item active">CreateMedical Staff</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                            class="fa fa-plus"></i> AddMedical Staff</a> --}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <h6 class="mb-0 text-uppercase">Create AMedical Staff</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('medical-stuff.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Name <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="name" id=""
                                                            class="form-control" value="{{ old('name') }}"
                                                            placeholder="EnterMedical Staff Name">
                                                        @if ($errors->has('name'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('name') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Email <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="email" id=""
                                                            class="form-control" value="{{ old('email') }}"
                                                            placeholder="EnterMedical Staff Email">
                                                        @if ($errors->has('email'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('email') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Phone <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="phone" id=""
                                                            class="form-control" value="{{ old('phone') }}"
                                                            placeholder="Enter Phone Number">
                                                        @if ($errors->has('phone'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('phone') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">
                                                            Specialization <span style="color: red;">*</span></label>
                                                        <select name="specialization_id[]" id="specialization_id" class="form-control" multiple>
                                                            @foreach ($specializations as $specialization)
                                                            <option value="{{ $specialization['id'] }}">{{ $specialization['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('specialization_id'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('specialization_id') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Year of
                                                            Experience <span style="color: red;">*</span></label>
                                                        <input type="text" name="year_of_experience" id=""
                                                            class="form-control" value="{{ old('year_of_experience') }}"
                                                            placeholder="Enter year of experience">
                                                        @if ($errors->has('year_of_experience'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('year_of_experience') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="col-form-label">Gender<span
                                                                class="text-danger">*</span> </label>
                                                        <div class="display-between">
                                                            <span for="" class="radio-gender">Male </span> <input
                                                                type="radio" class="gender" name="gender" id="gender"
                                                                value="Male" checked>
                                                            <span class="radio-gender">Female </span> <input type="radio"
                                                                class="gender" name="gender" id="gender" value="Female">
                                                            <span class="radio-gender">Other </span> <input type="radio"
                                                                class="gender" name="gender" id="gender"
                                                                value="Other">
                                                        </div>
                                                        @if ($errors->has('gender'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('gender') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Location (
                                                            City,State,Country,Pincode )
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="location" id="location"
                                                            class="form-control" value="{{ old('location') }}"
                                                            placeholder="Location">
                                                        @if ($errors->has('location'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('location') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Status
                                                            <span style="color: red;">*</span></label>
                                                        <select name="status" id="" class="form-control">
                                                            <option value="">Select a Status</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                        @if ($errors->has('status'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('status') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Password
                                                            <span style="color: red;">*</span></label>
                                                        <input type="password" name="password" id=""
                                                            class="form-control" value="{{ old('password') }}"
                                                            placeholder="Enter pasword">
                                                        @if ($errors->has('password'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('password') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Confirm
                                                            Password <span style="color: red;">*</span></label>
                                                        <input type="password" name="confirm_password" id=""
                                                            class="form-control" value="{{ old('confirm_password') }}">
                                                        @if ($errors->has('confirm_password'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('confirm_password') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Profile
                                                            Picture <span style="color: red;">*</span></label>
                                                        <input type="file" name="profile_picture" id=""
                                                            class="form-control" value="{{ old('profile_picture') }}">
                                                        @if ($errors->has('profile_picture'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('profile_picture') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="row" style="margin-top: 20px; float: left;">
                                                        <div class="col-sm-9">
                                                            <button type="submit"
                                                                class="btn px-5 submit-btn">Create</button>
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
    <script>
        $(document).ready(function() {
            $('#specialization_id').select2();
        });
    </script>
@endpush
