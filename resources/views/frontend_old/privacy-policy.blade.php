@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
Privacy Policy
@endsection
@push('styles')
@endpush

@section('content')
<section class="inr-bnr">
    <div class="inr-bnr-img">
        <img src="{{ asset('frontend_assets/images/blog-bg.jpg') }}" alt="" />
        <div class="inr-bnr-text">
            <h1>Privacy Policy</h1>
        </div>
    </div>
</section>
<section class="q-acc">
    <div class="container">
        <div class="head-1 h-b text-center" data-aos="fade-up" data-aos-duration="1000">
            {{-- <h2>Privacy Policy</span></h2>
            <p>We have curated a list of general FAQs covering all your queries.</p> --}}
        </div>
        <div class="q-acc" data-aos="fade-up" data-aos-duration="1000">
            <div class="accordion" id="accordionExample">
                <div class="row justify-content-between">
                    <div class="col-xl-12">
                        {!! $privacyPolicy['content'] !!}
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@push('scripts')
@endpush
