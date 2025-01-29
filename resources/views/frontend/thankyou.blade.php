@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Thanks Page
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
                                <h3>Thank you for your donation.</h3>
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
