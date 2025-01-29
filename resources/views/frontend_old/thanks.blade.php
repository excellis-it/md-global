@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Thanks
@endsection
@push('styles')
@endpush

@section('content')
    <section class="congratulation-sec">
        <div class="container">
            <div class="congratulation-sec-wrap">
                <div class="row justify-content-center align-items-center">
                    <div class="col-xl-8 col-md-8 col-12">
                        <div class="congo-div">
                            <div class="congo-img mb-3">
                                <img src="{{ asset('frontend_assets/images/congo.png') }}" alt="">
                            </div>
                            <div class="congo-text">
                                <h2>Congratulations</h2>
                                <h3>Your booking has been confirmed</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @Session::forget('remember')
@endsection

@push('scripts')
@endpush
