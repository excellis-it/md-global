@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
Q & A
@endsection
@push('styles')
@endpush

@section('content')
<section class="inr-bnr">
    <div class="inr-bnr-img">
        <img src="{{ asset('frontend_assets/images/blog-bg.jpg') }}" alt="" />
        <div class="inr-bnr-text">
            <h1>Q & A</h1>
        </div>
    </div>
</section>
<section class="q-acc">
    <div class="container">
        <div class="head-1 h-b text-center" data-aos="fade-up" data-aos-duration="1000">
            <h2>Frequently <span>Asked Questions</span></h2>
            <p>We have curated a list of general FAQs covering all your queries.</p>
        </div>
        <div class="q-acc" data-aos="fade-up" data-aos-duration="1000">
            <div class="accordion" id="accordionExample">
                <div class="row justify-content-between">
                    @foreach ($qnas->chunk(5) as $items)
                    <div class="col-xl-6">
                        @foreach ($items as $key=>$item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button @if($key==0) @else collapsed @endif" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key }}" aria-expanded="true"
                                    aria-controls="collapse{{ $key }}">
                                    {{ $key+1 }}. {{ $item->question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $key }}" class="accordion-collapse collapse @if($key==0) show @endif"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $item->answer !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
</section>
@endsection

@push('scripts')
@endpush
