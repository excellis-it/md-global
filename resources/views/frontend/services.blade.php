@extends('frontend.layouts.master')
@section('meta_title')
<meta name="keywords" content="{{$service['meta_keyword'] ?? ''}}">
<meta name="description" content="{{$service['meta_description'] ?? ''}}">
@endsection
@section('title')
{{$service['meta_title'] ?? ''}}
@endsection
@push('styles')
@endpush

@section('content')
<section class="inr-bnr">
    <div class="inr-bnr-img">
        <div class="inr-bnr-text">
            <h1>Our Services</h1>
            <nav>
                <ol class="cd-breadcrumb custom-separator">
                    <li><a href="/">Home</a></li>
                    <li class="current"><em>Our Services</em></li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<section class="blog-inr mt-5">
    <div class="container">
        <div class="blog-inr-wrap">
            <div class="row justify-content-between">
                @if ($services->count() > 0)
                <div class="col-xl-9 col-12">
                    @foreach ($services as $data)
                    <div class="blog-box-1">
                        <div class="blog-inr-img">
                            <img src="{{ Storage::url($data['image']) }}" alt="" />
                        </div>
                        <div class="blog-text">
                            <div class="date-box d-flex align-items-center justify-content-end">
                                <div class="bl-date-img">
                                    <img src="assets/images/date.png" alt="" />
                                </div>
                                <div class="bl-date">
                                    <h4>{{ date("d M' Y", strtotime($data['created_at'])) }}</h4>
                                </div>
                            </div>
                            <div class="blg-d">
                                <div class="head-1 h-b pb-3">
                                    <h2>{{ $data['title'] }}</h2>
                                </div>
                                <div class="para p-b">
                                    {!! $data['description'] !!}
                                </div>
                            </div>
                        </div>
                        <div class="main-btn text-left">
                            <a href="{{ route('service.details', ['service_slug' => $data->slug]) }}" tabindex="0"><span>Read More</span><span class="btn-arw"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="col-xl-3 col-12">
                    @if (count($topService) > 0)
                    <div class="cat-div">
                        <div class="cat-box">
                            <h4>Top 10 Services</h4>
                            <ul class="cat-list">
                                @foreach ($topService as $service)
                                <li> <a href="{{ route('service.details', ['service_slug' => $service['slug']]) }}">
                                        {{ $service['title'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@endpush
