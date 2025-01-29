@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Patient Profile
@endsection
@push('styles')
@endpush
@php
    use App\Helpers\Helper;
@endphp

@section('content')
    <section class="sidebar-sec" id="body-pd">
        <div class="container-fluid">
            <div class="sidebar-wrap d-flex justify-content-between">
                @include('frontend.patient.partials.sidebar')

                <!-- Content -->
                <div class="sidebar-right height-100">
                    <div class="content">
                        <div class="my-app-div-wrap">
                            <div class="content-head">
                                <h2>Payment History</h2>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="clinical-consultation-wrap">
                                        <div class="clinicl-head clinicl-head-l">
                                            <h3>Membership Plan </h3>
                                        </div>
                                        <div class="basic-plan-wrap">

                                            <div class="row justify-content-between align-items-center">
                                                @if (isset($membership) && !empty($membership))
                                                    <div class="col-xl-4">
                                                        <div class="basic-plan">
                                                            <div class="active-g">
                                                                <h3>Active</h3>
                                                            </div>
                                                            <h2>{{ $membership['plan']['plan_name'] }} plan</h2>
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <h3>USD</h3>
                                                                <h4>${{ $membership['amount'] }}</h4>
                                                                <h3>{{ $membership['plan']['plan_duration'] }} month</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="plan-e">
                                                            @if (Helper::countExpireDays($membership['membership_expiry_date']) < 7)
                                                                <p>Plan ends on within @if (Helper::countExpireDays($membership['membership_expiry_date']) == 0)
                                                                        today
                                                                    @else
                                                                        {{ Helper::countExpireDays($membership['membership_expiry_date']) }}
                                                                        days
                                                                    @endif please renew your plan again
                                                                    to continue</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-xl-12">
                                                        <div class="plan-e">
                                                            <p>
                                                                You have not subscribed to any plan yet. Please subscribe to
                                                                a plan to continue.
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                    <div class="clinical-consultation-wrap d-payment">
                                        <div class="clinicl-head clinicl-head-l">
                                            <h3>Medical Stuff Video Consultation Visit </h3>
                                        </div>
                                        <div class="chat-box-1-wrap">
                                            <div class="row">
                                                @if (count($payment_history) > 0)
                                                    @foreach ($payment_history as $payment)
                                                        <div class="col-xl-4 col-6 col-12">
                                                            <div class="chat-box-1-1">
                                                                <div
                                                                    class="chat-box-1 d-flex align-items-center justify-content-between">
                                                                    <div
                                                                        class="profile-div profile-div-2 d-flex align-items-center">
                                                                        <div class="profile-img">
                                                                            @if ($payment['doctor']['profile_picture'])
                                                                                <img src="{{ Storage::url($payment['doctor']['profile_picture']) }}"
                                                                                    alt="">
                                                                            @else
                                                                                <img src="{{ asset('frontend_assets/images/fd-2.png') }}"
                                                                                    alt="">
                                                                            @endif
                                                                        </div>
                                                                        <div class="profile-text">
                                                                            <h2>{{ $payment['doctor']['name'] }}</h2>
                                                                            <h3>{{ date('D, d M Y H:i A', strtotime($payment['created_at'])) }}
                                                                                </h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cam-img">
                                                                        <span><i class="fa-solid fa-video"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="for-vdo">
                                                                        <h3>For Video Consultation Fee
                                                                            <span>${{ $payment['amount'] }}</span></h3>
                                                                        <h4>Payment via stripe</h4>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    {{-- pagiantion --}}
                                                    <div class="pagi_1 justify-content-center">
                                                        <nav aria-label="Page navigation example">
                                                            <div class="">
                                                                {{ $payment_history->render() }}
                                                            </div>
                                                        </nav>
                                                    </div>
                                                @else
                                                {{-- no data found --}}
                                                <div class="col-12" style="text-align: center">
                                                    <h5>!! No payment history found</h5>
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
        </div>
    </section>
@endsection

@push('scripts')
@endpush
