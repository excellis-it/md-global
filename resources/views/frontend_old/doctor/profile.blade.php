@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
   Medical Staff Profile
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
                        <div class="content-head">
                            <h2>My Profile</h2>
                        </div>
                        <div class="my-profile-div">
                            <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-xl-2">
                                    <div class="profile-img">
                                        @if (Auth::user()->profile_picture)
                                            <img src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="" id="blah">
                                        @else
                                            <img src="{{ asset('frontend_assets/images/profile.png') }}" alt="" id="blah">
                                        @endif
                                        <div class="pro-cam-img-1">
                                            <label for="file-input">
                                                <img src="{{ asset('frontend_assets/images/cam-img.png') }}" />
                                            </label>
                                            <input id="file-input" type="file" name="profile_picture"
                                                onchange="readURL(this);" />
                                            @if ($errors->has('profile_picture'))
                                                <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="profile-form">

                                        <div class="row">
                                            <div class="form-group col-lg-6 col-md-12">
                                                <input type="text" class="form-control" id=""
                                                    value="{{ Auth::user()->name }}" name="name" placeholder="Name">
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <input type="text" class="form-control" id=""
                                                    value="{{ Auth::user()->phone }}" name="phone"
                                                    placeholder="Phone Number">
                                                @if ($errors->has('phone'))
                                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <input type="text" class="form-control" id="" readonly
                                                    value="{{ Auth::user()->email }}" name="email" placeholder="Email ID">
                                                @if ($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group col-lg-6 col-md-12">
                                                <input type="date" class="form-control" id=""
                                                    value="{{ Auth::user()->age }}" name="age" placeholder="Age"
                                                    max="{{ date('Y-m-d') }}">
                                                @if ($errors->has('age'))
                                                    <span class="text-danger">{{ $errors->first('age') }}</span>
                                                @endif
                                            </div>
                                            <div class="row check-box m-0 p-0">
                                                <div class="form-group col-lg-3 col-md-12">
                                                    <label>Gender</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            value="Male" id="inlineRadio1" value="option1"
                                                            @if (Auth::user()->gender == 'Male') checked @endif>
                                                        <label class="form-check-label" for="inlineRadio1">Male</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            value="Female" id="inlineRadio2" value="option2"
                                                            @if (Auth::user()->gender == 'Female') checked @endif>
                                                        <label class="form-check-label" for="inlineRadio2">Female</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                            value="Other" id="inlineRadio3" value="option2"
                                                            @if (Auth::user()->gender == 'Other') checked @endif>
                                                        <label class="form-check-label" for="inlineRadio3">Other</label>
                                                    </div>
                                                    @if ($errors->has('gender'))
                                                        <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                    @endif
                                                </div>
                                                <div class="form-group col-lg-5 col-md-12">
                                                    <select name="specialization_id[]" id="specialization_id"
                                                    class="form-control" multiple>
                                                    <option value="">Select Specialization</option>
                                                    @foreach ($specializations as $specialization)
                                                        <option value="{{ $specialization['id'] }}" @if(Auth::user()->doctorSpecializations->count() > 0) @foreach(Auth::user()->doctorSpecializations as $item) @if($item['specialization_id'] == $specialization['id']) selected @endif @endforeach @endif>
                                                            {{ $specialization['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('specialization_id'))
                                                    <div class="error" style="color:red;">
                                                        {{ $errors->first('specialization_id') }}</div>
                                                @endif
                                                </div>
                                                <div class="form-group col-lg-4 col-md-12">
                                                    <input type="text" class="form-control" id="" value="{{ Auth::user()->license_number }}" name="license_number"
                                                        placeholder="License Number">
                                                    @if ($errors->has('license_number'))
                                                        <span class="text-danger">{{ $errors->first('license_number') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-xl-5">
                                                <div class="main-btn-p pt-4">
                                                    <input type="submit" value="SAVE" class="sub-btn">
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
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
     <script>
        $(document).ready(function() {
            $('#specialization_id').select2();
        });
    </script>
@endpush
