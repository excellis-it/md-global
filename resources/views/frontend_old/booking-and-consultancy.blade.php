@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Booking Appointment and Video Consultancy
@endsection
@push('styles')
@endpush

@section('content')
    @php
        use App\Models\User;
        use App\Helpers\Helper;
    @endphp
    {{-- @dd(Auth::user()->id) --}}
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <section class="inr-bnr">
        <div class="inr-bnr-img">
            <img src="{{ asset('frontend_assets/images/tele-bg.jpg') }}" alt="" />
            <div class="inr-bnr-text">
                <h1>Booking Appointment and Video Consultancy</h1>
            </div>
        </div>
    </section>
    <section class="clinic-sec">
        <div class="container">
            <div class="clinic-sec-wrap">
                <div class="row justify-content-center">
                    <div class="col-xl-9">
                        <div class="cl-dc-bx">
                            <div class="row justify-content-between">
                                <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                                    <div class="find-doc-slide-img" id="{{ $doctor['id'] }}-status">
                                        @if ($doctor['profile_picture'])
                                            <img src="{{ Storage::url($doctor['profile_picture']) }}" alt="">
                                        @else
                                            <img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                                    <div class="find-doc-slide-text">
                                        <h3>{{ $doctor['name'] }}</h3>
                                        <h4>{{ User::getDoctorSpecializations($doctor['id']) }}</h4>
                                        <h4>
                                            @if ($doctor['license_number'])
                                                License No. {{ $doctor['license_number'] }}
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                                    <div class="pec-div">
                                        <span class="pec d-block"><i class="fa-solid fa-thumbs-up"></i>99%</span>
                                        <span class="exp d-block"><i class="fa-regular fa-period"></i>
                                            {{ $doctor['year_of_experience'] }} Years
                                            Exp</span>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                                    <div class="find-doc-slide-text">
                                        <h5>{{ $doctor['location'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="slot-sec">
        <div class="container">
            <div class="slot-sec-wrap">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="slot-div">
                            <div class="row">
                                @if ($clinics->count() > 0)
                                    <div class="col-md-6">
                                        <div class="slot-div-wrap">
                                            <a href="javascript:void(0);">
                                                <div class="slot-1 slot-2 lft active-slot clinic-visit">
                                                    <h3>Service Centers Visit Slots</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="slot-div-wrap">
                                        <a href="javascript:void(0);">
                                            <div class="slot-1 user-list chat" id="show-chat" data-id="{{ $doctor['id'] }}"
                                                data-query="1">
                                                {{-- add chat class when implemetation start --}}
                                                <h3>Chat / Video Consultation</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="chat-sec chat-slot" id="chat-view">
        @include('frontend.chat')
    </section>
    @if ($clinics->count() > 0)
        <section class="cl-tm-slot booking-slot">
            <form action="{{ route('appointment-store') }}" method="POST">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor['id'] }}">
                <div class="container">
                    <div class="cl-name-div">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="cl-slot-wrap">
                                    <div class="cl-slot-icon d-flex align-items-center">
                                        <i class="fa-solid fa-house-chimney-medical"></i>
                                        <h3>Service Centers Name</h3>
                                    </div>
                                    <div class="clinic-name-ck-div">
                                        <div class="clinic-name-ck">

                                            <div class="row align-items-center justify-content-between">
                                                {{-- @dd(Helper::countSlotAvailability($clinics[1]['id'])) --}}
                                                @foreach ($clinics as $key => $clinic)
                                                    <div
                                                        class="col-xl-5 col-12 @if (Helper::countSlotAvailability($clinic['id']) == 0) disable-or-not @endif">
                                                        <label for="clinic_name_{{ $clinic['id'] }}"
                                                            style="cursor: pointer;" class="form-check d-flex">
                                                            <div class="form-check-box">
                                                                <input class="form-check-input clinic_add" type="radio"
                                                                    value="{{ $clinic['id'] }}" name="clinic_id"
                                                                    id="clinic_name_{{ $clinic['id'] }}"
                                                                    @if (Helper::countSlotAvailability($clinic['id']) == 0) disabled @endif>
                                                            </div>
                                                            <div class="form-text">
                                                                <h3>{{ $clinic['clinic_name'] }} </h3>
                                                                <p>{{ $clinic['clinic_address'] }}</p>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="cl-tm-slot-wrap">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-6 col-md-12" id="clinic_visit_slots">
                                @include('frontend.ajax-clinic-visit')
                            </div>
                            <div class="col-xl-6 col-md-12" id="clinic_visit_slots_time">
                                @include('frontend.ajax-clinic-visit-slot-time')

                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-4 col-md-6 col-12">
                                <div class="main-btn-p pt-4">
                                    <input type="submit" value="Book" class="sub-btn">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    @endif


@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#payment_now").click(function() {
                $("#Modal1").modal('hide');
                $("#Modal2").modal('show');
            });

            $("#Modal1").modal('show');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.chat-slot').css('display', 'none');
            $('.clinic-visit').on('click', function() {
                $('.chat').removeClass('active-slot');
                $(this).addClass('active-slot');
                $('.booking-slot').css('display', 'block');
                $('.chat-slot').css('display', 'none');
            });
            $('#show-chat').on('click', function() {
                var doctor_id = "{{ $doctor['id'] }}"
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                $.ajax({
                    url: "{{ route('doctor.chat') }}",
                    type: 'GET',
                    data: {
                        doctor_id: doctor_id,
                    },
                    success: function(resp) {
                        // console.log(resp);
                        if (resp.status == true) {
                            $('.booking-slot').css('display', 'none');
                            $('.clinic-visit').removeClass('active-slot');
                            $('#show-chat').addClass('active-slot');
                            $('.chat-slot').css('display', 'block');
                            $('.chat-slot').html(resp.view);
                            if (resp.chat_count > 0) {
                                scrollChatToBottom()
                            }
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                        } else {
                            // console.log(resp);
                            toastr.error(resp.message);
                            $('#loading').removeClass('loading');
                            $('#loading-content').removeClass('loading-content');
                        }
                    }
                });
            });

            function scrollChatToBottom() {
                var messages = document.getElementById('chat-container');
                messages.scrollTop = messages.scrollHeight;
            }
        });
    </script>


    <script>
        $('.clinic_add').on('change', function() {
            var clinic_id = $(this).val();
            $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');
            $.ajax({
                url: "{{ route('clinic.visit.slot-ajax') }}",
                type: 'GET',
                data: {
                    clinic_id: clinic_id
                },
                success: function(resp) {
                    // console.log(resp.clinic.slots);

                    $('#clinic_visit_slots').html(resp.view)
                    $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');
                }
            });
        });
    </script>

    <script>
        $(document).on("change", ".appointment-date", function() {
            var slot_id = $(this).data('id');
            $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');
            // alert(slot_id)
            $.ajax({
                url: "{{ route('clinic.ajax-clinic-visit-slot-time') }}",
                type: 'GET',
                data: {
                    slot_id: slot_id
                },
                success: function(resp) {
                    // console.log(resp.clinic.slots);

                    $('#clinic_visit_slots_time').html(resp.view)
                    $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');
                }
            });
        });
    </script>
@endpush
