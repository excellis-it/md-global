@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
   Medical Staff Payment History
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
                                <h2>Payment History</h2>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="clinical-consultation-wrap d-payment">
                                        <div class="clinicl-head clinicl-head-l">
                                            <h3>Video Consultation</h3>
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
                                                                            @if ($payment['patient']['profile_picture'])
                                                                                <img src="{{ Storage::url($payment['patient']['profile_picture']) }}"
                                                                                    alt="">
                                                                            @else
                                                                                <img src="{{ asset('frontend_assets/images/fd-2.png') }}"
                                                                                    alt="">
                                                                            @endif
                                                                        </div>
                                                                        <div class="profile-text">
                                                                            <h2>{{ $payment['patient']['name'] }}</h2>
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
                                                                        <h3>{{ $payment['call_duration'] }} Min Video Call Duration</h3>
                                                                          <h3>  <span>${{ $payment['amount'] }}</span> Payment via stripe</h3>
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
