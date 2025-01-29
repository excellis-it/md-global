@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
   Medical Staff Dashboard
@endsection
@push('styles')
@endpush

@section('content')
    <?php use App\Helpers\Helper; ?>
    <section class="sidebar-sec" id="body-pd">
        <div class="container-fluid">
            <div class="sidebar-wrap d-flex justify-content-between">

                @include('frontend.doctor.partials.sidebar')


                <!-- Content -->
                <div class="sidebar-right height-100">
                    <div class="content">
                        <div class="row">
                            <div class="col-xl-6 col-12">
                                <div class="profile-div d-flex align-items-center">
                                    <div class="profile-img active-green">
                                        @if (Auth::user()->profile_picture)
                                            <img src="{{ Storage::url(Auth::user()->profile_picture) }}" alt="">
                                        @else
                                            <img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="profile-text">
                                        <h2><span>Hello!</span>{{ Auth::user()->name }}</h2>
                                        <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                                        <h3>Online</h3>
                                    </div>
                                </div>
                                <div class="my-app-div dr-panel-div mb-3">
                                    <div class="my-app-head-wrap d-flex justify-content-between align-items-center">
                                        <div class="my-app-head">
                                            <h3>Chat Request</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @if (count($chat_requests) == 0)
                                            <div class="col-xl-12 col-12 mb-2">
                                                <div
                                                    class="profile-div-box d-flex align-items-center justify-content-between">
                                                    <div
                                                        class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">

                                                        <div class="profile-text">
                                                            <h2>No Chat Request</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($chat_requests as $friend)
                                                <div class="col-xl-12 col-12 mb-2">
                                                    <div
                                                        class="profile-div-box d-flex align-items-center justify-content-between">
                                                        <div
                                                            class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                                                            <div class="profile-img">
                                                                @if ($friend->profile_picture)
                                                                    <img src="{{ Storage::url($friend->profile_picture) }}"
                                                                        alt="">
                                                                @else
                                                                    <img src="{{ asset('frontend_assets/images/profile.png') }}"
                                                                        alt="">
                                                                @endif

                                                            </div>
                                                            <div class="profile-text">
                                                                <h2>{{ $friend->name }}</h2>
                                                            </div>
                                                        </div>
                                                        <div class="patient-age">
                                                            <h3>Age: <span>{{ $friend->age }}</span></h3>
                                                        </div>
                                                        <div class="patient-age">
                                                            <h3>Gender: <span>{{ $friend->gender }}</span></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="my-app-div dr-panel-div">
                                    <div class="my-app-head-wrap d-flex justify-content-between align-items-center">
                                        <div class="my-app-head">
                                            <h3>Clinics</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xl-12 col-12">
                                            <div class="profile-div-box-wrap srl" id="srl_1">
                                                @if (count($clinics) == 0)
                                                    <div
                                                        class="profile-div-box d-flex align-items-center justify-content-between">
                                                        <div
                                                            class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                                                            <div class="profile-text">
                                                                <h2>No Service Centers Found</h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    @foreach ($clinics as $clinic)
                                                        <div
                                                            class="profile-div-box mb-3 d-flex justify-content-between align-items-center">
                                                            <div
                                                                class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">

                                                                <div class="profile-text">
                                                                    <h2>{{ $clinic['clinic_name'] }}</h2>
                                                                    <p>{{ $clinic['clinic_address'] }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="patient-age">
                                                                <h3><span>
                                                                        {{ Helper::getClinicOpeninDay($clinic['id']) }}</span>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-12">
                                <div class="my-app-div dr-panel-div justify-content-between align-items-center mb-3">
                                    <div class="my-app-head-wrap d-flex justify-content-between align-items-center">
                                        <div class="my-app-head">
                                            <h3>Revenue</h3>
                                        </div>
                                        <div class="my-app-head">
                                            <h5>Last 7 days VS prior week</h5>
                                        </div>
                                    </div>
                                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                                </div>

                                <div class="my-app-div dr-panel-div justify-content-between align-items-center">
                                    <div class="my-app-head-wrap d-flex justify-content-between align-items-center">
                                        <div class="my-app-head">
                                            <h3>Last 10 Booking History</h3>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="dr-suggestio-wrap srl" id="srl_1">
                                        @if (count($bookingHistory) == 0)
                                            <div class="profile-div-box d-flex align-items-center justify-content-between">
                                                <div
                                                    class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                                                    <div class="profile-text">
                                                        <h2>No Booking History Found</h2>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($bookingHistory as $history)
                                                <div class="dr-suggestion">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-md-6 col-12">
                                                            <div class="dr-name d-flex align-items-center">
                                                                <div class="dr-name-img">
                                                                    @if ($history->user->profile_picture)
                                                                        <img src="{{ Storage::url($history->user->profile_picture) }}"
                                                                            alt="">
                                                                    @else
                                                                        <img src="{{ asset('frontend_assets/images/profile.png') }}"
                                                                            alt="">
                                                                    @endif
                                                                </div>
                                                                <div class="dr-name-text">
                                                                    <h2>{{ $history->user->name }}</h2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6 col-12">
                                                            <div class="app-time app-time-2">
                                                                <h3><i class="fa-regular fa-clock"></i>
                                                                    Appointment time</h3>
                                                                <p>{{ date('D, d M Y', strtotime($history['appointment_date'])) }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-6 col-12">
                                                            <div class="app-time app-time-1 me-3">
                                                                <h3><i class="fa-solid fa-house-chimney-medical"></i>
                                                                    Service Centers Details</h3>
                                                                <p>{{ $history['clinic_name'] }}
                                                                    <span>{{ $history['clinic_address'] }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
    const xValues = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

    new Chart("myChart", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                data: [860, 1140, 1060, 1060, 1070, 1110, 1330, 2210, 7830, 2478],
                borderColor: "red",
                fill: false
            }, {
                data: [1600, 1700, 1700, 1900, 2000, 2700, 4000, 5000, 6000, 7000],
                borderColor: "green",
                fill: false
            }, {
                data: [300, 700, 2000, 5000, 6000, 4000, 2000, 1000, 200, 100],
                borderColor: "blue",
                fill: false
            }]
        },
        options: {
            legend: {
                display: false
            }
        }
    });
</script>
@endpush
