@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Patient Dashboard
@endsection
@push('styles')
@endpush

@section('content')
    @php
        use App\Helpers\Helper;
    @endphp
    <section class="sidebar-sec" id="body-pd">
        <div class="container-fluid">
            <div class="sidebar-wrap d-flex justify-content-between">

                @include('frontend.patient.partials.sidebar')


                <!-- Content -->
                <div class="sidebar-right height-100">
                    <div class="content">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="profile-div d-flex align-items-center">
                                    <div class="profile-img">
                                        @if (Auth::user()->profile_picture)
                                            <img src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="">
                                        @else
                                            <img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="profile-text">
                                        <h2><span>Hello!</span>{{ Auth::user()->name }}</h2>
                                        <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-app-div-wrap">
                            <div class="row">

                                <div class="col-xl-6 col-12">
                                    <div class="my-app-div">
                                        @if ($upcominAppontment)
                                            <div class="my-app-head-wrap d-flex justify-content-between align-items-center">
                                                <div class="my-app-head">
                                                    <h3>My Appointment</h3>
                                                </div>
                                                <div class="my-app-head">
                                                    <h4> {{ Helper::getLeftTimeFromDate($upcominAppontment['appointment_date'], $upcominAppontment['appointment_time']) }}
                                                        left</h4>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-xl-12 col-12">
                                                    <div class="profile-div profile-div-2 d-flex">
                                                        <div class="profile-img">
                                                            <img src="{{ asset('frontend_assets/images/profile.png') }}"
                                                                alt="">
                                                        </div>
                                                        <div class="profile-text">
                                                            <h2>{{ $upcominAppontment['doctor']['name'] }}</h2>
                                                            <p> {{ Helper::getDoctorSpecializations($upcominAppontment['doctor']['id']) }}
                                                            </p>
                                                            <p>{{ $upcominAppontment['doctor']['year_of_experience'] }}
                                                                years experience</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-12">
                                                        <div class="app-time-wrap d-flex  align-items-center">
                                                            <div class="app-time-img">
                                                                <span><i class="fa-regular fa-clock"></i></span>
                                                            </div>
                                                            <div class="app-time me-3">
                                                                <h3> Appointment time</h3>
                                                                <p>{{ date('D, d M Y', strtotime($upcominAppontment['appointment_date'])) }}
                                                                    {{ $upcominAppontment['appointment_time'] }}</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-12">
                                                        <div class="app-time-wrap d-flex align-items-center">
                                                            <div class="app-time-img">
                                                                <span><i
                                                                        class="fa-solid fa-house-chimney-medical"></i></span>
                                                            </div>
                                                            <div class="app-time app-time-1">
                                                                <h3>Service Centers Details</h3>
                                                                <p>{{ $upcominAppontment['clinic_name'] }}
                                                                    <span>{{ $upcominAppontment['clinic_address'] }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="my-app-head-wrap d-flex justify-content-between align-items-center">
                                                <div class="my-app-head">
                                                    <h3>My Appointment</h3>
                                                </div>
                                                <div class="my-app-head">
                                                    <h4> No Appointment</h4>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    {{-- image --}}
                                                    <center><img
                                                            src="{{ asset('frontend_assets/images/no-data-found-removebg-preview.png') }}"
                                                            alt=""></center>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-xl-6 col-12">
                                    <div class="my-app-div justify-content-between align-items-center">
                                        <div class="my-app-head-wrap d-flex justify-content-between align-items-center">
                                            <div class="my-app-head">
                                                <h3>Medical Stuff<span>Suggestion for you</span></h3>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="dr-suggestio-wrap srl" id="srl_1">
                                            @if (count($doctors) > 0)
                                                @foreach ($doctors as $doctor)
                                                    <div class="dr-suggestion">
                                                        <div class="row">
                                                            <div class="col-xl-4 col-md-6 col-12">
                                                                <div class="dr-name d-flex align-items-center">
                                                                    <div class="dr-name-img">
                                                                        @if ($doctor->profile_picture)
                                                                            <img src="{{ Storage::url($doctor->profile_picture) }}"
                                                                                alt="">
                                                                        @else
                                                                            <img src="{{ asset('frontend_assets/images/profile.png') }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div class="dr-name-text">
                                                                        <h2>{{ $doctor->name }}</h2>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-md-6 col-12">
                                                                <div class="app-time app-time-2">
                                                                    <h3><i class="fa-solid fa fa-medkit"></i>
                                                                        Specializations</h3>
                                                                    <p>{{ Helper::getDoctorSpecializations($doctor->id) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-md-6 col-12">
                                                                <div class="app-time app-time-1">
                                                                    <h3><i class="fa-solid fa fa-history"></i>
                                                                        Year of Experience</h3>
                                                                    <p>{{ $doctor->year_of_experience }} Years</p>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="dr-suggestion">
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            {{-- image --}}
                                                            <center><img
                                                                    src="{{ asset('frontend_assets/images/no-data-found-removebg-preview.png') }}"
                                                                    alt=""></center>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
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
@endpush
