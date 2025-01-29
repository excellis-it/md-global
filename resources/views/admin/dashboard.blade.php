@extends('admin.layouts.master')
@section('title')
    Dashboard - {{ env('APP_NAME') }} admin
@endsection
@push('styles')
@endpush

@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">Welcome Admin!</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row card_dash">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{ route('patients.index') }}" style="color: black">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-wheelchair"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{ $count['patient'] }}</h3>
                                    <span>Total Patient</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{ route('medical-stuff.index') }}" style="color: black">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fas fa-user-md"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{ $count['doctor'] }}</h3>
                                    <span>TotalMedical Staff</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{ route('appointments.index') }}" style="color: black">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-calendar"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{ $count['total_appointment'] }}</h3>
                                    <span>Total Appointments</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{ route('membership-history.index') }}" style="color: black">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                                <div class="dash-widget-info">
                                    <h3>${{ $count['membership_total_payment'] }}</h3>
                                    <span>Membership Transaction</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{ route('clinics.index') }}" style="color: black">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fas fa-clinic-medical"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{ $count['clinics'] }}</h3>
                                    <span>Total Clinics</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{ route('blogs.index') }}" style="color: black">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fas fa-blog"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{ $count['blogs'] }}</h3>
                                    <span>Total Blogs</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{ route('specializations.index') }}" style="color: black">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-heart"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{ $count['specializations'] }}</h3>
                                    <span>Total Specialization</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <a href="{{ route('symptoms.index') }}" style="color: black">
                        <div class="card dash-widget">
                            <div class="card-body">
                                <span class="dash-widget-icon"><i class="fa fa-stethoscope"></i></span>
                                <div class="dash-widget-info">
                                    <h3>{{ $count['symptoms'] }}</h3>
                                    <span>Total Symptoms</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-6 d-flex">
                    <div class="card flex-fill dash-statistics">
                        <div class="card-body">
                            <h5 class="card-title">Membership Purchase Transaction</h5>
                            @php
                                $year = 2022;
                            @endphp
                            <div>
                                <select name="" id="year" class="form-control">
                                    @for ($i = $year; $i <= date('Y'); $i++)
                                        <option value="{{ $year }}"
                                            @if ($year == date('Y')) selected="" @endif>
                                            {{ $year }}</option>
                                        @php $year++ @endphp
                                    @endfor
                                </select>
                            </div>
                            <div id="membership-bar-chart">
                                @include('admin.membership-bar-chart')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <h4 class="card-title">Top 5 Service Centers appointment</h4>
                            <div class="statistics">
                                <div class="row">
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Total Clinics</p>
                                            <h3>{{ $count['clinics'] }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <div class="stats-box mb-4">
                                            <p>Appointments</p>
                                            <h3>{{ $count['total_appointment'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress mb-4">
                                @foreach ($top_5_clinics as $key => $item)
                                {{-- get percentage of total appointment --}}
                                @php
                                    $percentage = ($item->total_appointment / $count['total_appointment']) * 100;
                                    // round to 2 decimal places
                                    $percentage = round($percentage, 0);
                                @endphp
                                    <div class="progress-bar  @if ($key == 0) bg-primary
                                @elseif($key == 1)
                                    bg-warning
                                @elseif($key == 2)
                                    bg-success
                                @elseif($key == 3)
                                    bg-danger
                                @elseif($key == 4)
                                    bg-info @endif"
                                        role="progressbar" style="width: {{$percentage}}%" aria-valuenow="{{$percentage}}" aria-valuemin="0"
                                        aria-valuemax="100">{{$percentage}}%</div>
                                @endforeach
                            </div>
                            <div>
                                @foreach ($top_5_clinics as $key => $item)
                                    <p><i
                                            class="fa fa-dot-circle-o
                                        {{-- dynamic bg color --}}
                                        @if ($key == 0) text-primary
                                        @elseif($key == 1)
                                            text-warning
                                        @elseif($key == 2)
                                            text-success
                                        @elseif($key == 3)
                                            text-danger
                                        @elseif($key == 4)
                                            text-info @endif
                                        me-2"></i>{{ $item->clinic_name }}
                                        <span class="float-end">{{ $item->total_appointment }}</span>
                                    </p>
                                @endforeach

                                {{-- <p><i class="fa fa-dot-circle-o text-warning me-2"></i>Inprogress Tasks <span
                                        class="float-end">115</span></p>
                                <p><i class="fa fa-dot-circle-o text-success me-2"></i>On Hold Tasks <span
                                        class="float-end">31</span></p>
                                <p><i class="fa fa-dot-circle-o text-danger me-2"></i>Pending Tasks <span
                                        class="float-end">47</span></p>
                                <p class="mb-0"><i class="fa fa-dot-circle-o text-info me-2"></i>Review Tasks <span
                                        class="float-end">5</span></p> --}}
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
            $('#year').change(function() {
                var year = $(this).val();
                $.ajax({
                    url: "{{ route('admin.membership.bar.chart') }}",
                    type: "GET",
                    data: {
                        year: year
                    },
                    success: function(resp) {
                        $('#membership-bar-chart').html(resp.view);
                    }
                });
            });
        });
    </script>
@endpush
