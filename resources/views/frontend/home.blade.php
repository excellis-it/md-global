@extends('frontend.layouts.master')
@section('meta_title')
<meta name="keywords" content="{{$homeContents['meta_keyword'] ?? ''}}">
<meta name="description" content="{{$homeContents['meta_description'] ?? ''}}">
@endsection
@section('title')
{{$homeContents['meta_title'] ?? ''}}

@endsection
@push('styles')
{{-- <style>
    .top-title h1,h2,h3,p{
        color: black !important;
    }
</style> --}}
@endpush

@section('content')
<section class="banner__slider banner_sec">
    <div class="slider stick-dots">
        {{-- @dd($banners) --}}
        @foreach ($banners as $key => $banner)
        <div class="slide">
            <div class="slide__img">
                <img src="{{ $banner->image }}" alt="" data-lazy="" class="full-image" />
            </div>
            <div class="slide__content slide__content__left">
                <div class="slide__content--headings text-left" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                    <h1 class="title">
                        {!! $banner->title !!}
                    </h1>
                    <p class="top-title">
                        {!! $banner->sub_title !!}
                        {{-- <a href="tel:{{$banner->sub_title}}"><b>Call {{ $banner->sub_title }}</b></a> --}}
                    </p>
                </div>
                <!-- <div class="main-btn pt-4">
                                    @if (!Auth::check())
    <a href="{{ route('login') }}"><span>get started</span><span class="btn-arw"><i
                                                    class="fa-solid fa-arrow-right"></i></span></a>
    @endif
                                </div> -->
            </div>
        </div>
        @endforeach
    </div>
</section>

<section class="after_banner">
    <div class="container">

        <div class="row justify-content-center m-0">
            <div class="col-xl-4 col-md-6 col-12 p-0">
                <a href="{{ isset($homeContents['colab_section_1_link']) && $homeContents['colab_section_1_link'] ? $homeContents['colab_section_1_link'] : 'https://www.youtube.com/embed/RMwow6cw6HM' }}" target="_blank">
                    <div class="white_box">
                        <span><i class="fa-solid fa-headset"></i></span>
                        {{-- <h4>HDHP Video</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat veritatis ex placeat
                                corrupti eum facilis, tempore, minus pariatur corporis officiis voluptatibus, maiores
                                exercitationem eaque voluptatum. Animi omnis dolores rerum expedita.</p> --}}
                        <h4>{!! $homeContents['colab_section_1_title'] ?? '' !!}</h4>
                        <p> {!! $homeContents['colab_section_1_description'] ?? '' !!}</p>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 col-12 p-0">
                <a href="{{ isset($homeContents['colab_section_2_link']) && $homeContents['colab_section_2_link'] ? $homeContents['colab_section_2_link'] : 'https://youtu.be/xn6FtTZYeWE' }}" target="_blank">
                    <div class="white_box bg_blue">
                        <span><i class="fa-regular fa-handshake"></i></span>
                        {{-- <h4>HSA Video</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat veritatis ex placeat
                                corrupti eum facilis, tempore, minus pariatur corporis officiis voluptatibus, maiores
                                exercitationem eaque voluptatum. Animi omnis dolores rerum expedita.</p> --}}
                        <h4>{!! $homeContents['colab_section_2_title'] ?? '' !!}</h4>
                        <p> {!! $homeContents['colab_section_2_description'] ?? '' !!}</p>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 col-12 p-0">
                <a href="{{ isset($homeContents['colab_section_3_link']) && $homeContents['colab_section_3_link'] ? $homeContents['colab_section_3_link'] : 'https://ioe.hsabank.com/home' }}" target="_blank">
                    <div class="white_box">
                        <span><i class="fa-solid fa-heart-pulse"></i></span>
                        {{-- <h4>HSA Bank Link</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat veritatis ex placeat
                                corrupti eum facilis, tempore, minus pariatur corporis officiis voluptatibus, maiores
                                exercitationem eaque voluptatum. Animi omnis dolores rerum expedita.</p> --}}
                        <h4>{!! $homeContents['colab_section_3_title'] ?? '' !!}</h4>
                        <p> {!! $homeContents['colab_section_3_description'] ?? '' !!}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>


<section class="abt-sec">
    <div class="container">
        <div class="abt-sec-wrap">
            <div class="row justify-content-between">
                <div class="col-xl-5 col-md-6 col-12">
                    <div class="abt-vdo">
                        <div class="">
                            <iframe width="100%" height="315" src="{{ isset($homeContents['about_section_link']) && $homeContents['about_section_link'] ? $homeContents['about_section_link'] : 'https://www.youtube.com/embed/tE0iX5Z6Aek' }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-12">
                    <div class="abt-text pb-3">
                        <div class="head-1 h-b">
                            {{-- <h2>About Us</h2> --}}
                            <h2>{!! $homeContents['about_section_title'] ?? '' !!}</h2>
                        </div>
                        <div class="para p-b">
                            {{-- <p>
                                    <b>The Trusted Investment Platform For High-Yield Investments</b>
                                </p>
                                 <p>
                                    We can delete thatpage- Most of the content from this page
                                    can be explained in About USpage with question and answers
                                    page about HSA's, Primary Care andSpecialists - how they
                                    were chosen to the website. Primarily fromEnrollments of
                                    Healthcare Professionals & Patients through
                                    MembershipServices , irrespective of their
                                    residence,race,color or sex.
                                </p> --}}
                            <p>
                                {!! $homeContents['about_section_description'] ?? '' !!}
                            </p>
                        </div>
                        <div class="main-btn pt-4">
                            <a href="" tabindex="0"><span>read more</span><span class="btn-arw"><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section class="service" style="background: url({{ asset('frontend_assets/images/bg_dots.png') }});">
    <div class="container">
        <div class="service-wrap">
            <div class="service-head text-center" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                <div class="head-1 h-b">
                    {{-- <h2>Our Services</h2> --}}
                    <h2>{!! $homeContents['services_section_title'] ?? '' !!}</h2>
                </div>
            </div>
            <div class="serv-wrap">
                <div class="services_slid">
                    @if ($service->count() > 0)
                    @foreach ($service as $data)
                    <div class="services_padding">

                        <div class="serv-box" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="300">
                            <div class="services_img">
                                {{-- <img src="{{ asset('frontend_assets/images/bk-1.png') }}" alt="" /> --}}
                                <img src="{{ Storage::url($data['image']) }}" alt="" />
                            </div>
                            <div class="serv-text">
                                <div class="serv-head">
                                    {{-- <h3>Individual Online Enrollment (IOE) Link</h3> --}}
                                    <h3>{{ $data['title'] ?? '' }}</h3>
                                </div>
                                <div class="serv-p">
                                    <div class="para">
                                        {{-- <p>
                                                At Foremost Organization, we provide stratified
                                                individual online enrollments for your Health
                                                Savings Account and other accounts related to real
                                                estate, rehabilitation, and other such areas.
                                                Complete your application within 10 minutes and get
                                                quick access to your enrollment with our assistance.
                                            </p> --}}
                                        <p>{!! $data['description'] ?? '' !!}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="main-btn-2">
                                            <a href="{{ route('services') }}#first_service">READ MORE<span class="btn-dash"><i class="fa-solid fa-minus"></i></span><span class="btn-dot"><i class="fa-solid fa-ellipsis"></i></span></a>
                        </div> --}}
                        <div class="main-btn-2">
                            <a href="{{ route('service.details',['service_slug' => $data->slug]) }}">READ MORE<span class="btn-dash"><i class="fa-solid fa-minus"></i></span><span class="btn-dot"><i class="fa-solid fa-ellipsis"></i></span></a>
                        </div>
                    </div>

                </div>
                @endforeach
                @endif
                {{-- <div class="services_padding">
                            <div class="serv-box" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600">
                                <div class="services_img">
                                    <img src="{{ asset('frontend_assets/images/bk-2.png') }}" alt="" />
            </div>
            <div class="serv-text">
                <div class="serv-head">
                    <h3>Employer Sign-up Link</h3>
                </div>
                <div class="serv-p">
                    <div class="para">
                        <p>
                            This form is the first step of getting your Health
                            Savings Account program. Completing this form allows
                            you to have access to the HSA's bank employer site
                            by which you can manage your benefits programs.
                        </p>
                    </div>
                </div>
            </div>
            <div class="main-btn-2">
                <a href="{{ route('services') }}#second_service">READ MORE<span class="btn-dash"><i class="fa-solid fa-minus"></i></span><span class="btn-dot"><i class="fa-solid fa-ellipsis"></i></span></a>
            </div>
        </div>
    </div> --}}
    {{-- <div class="services_padding">
                            <div class="serv-box" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="900">
                                <div class="services_img">
                                    <img src="{{ asset('frontend_assets/images/bk-3.png') }}" alt="" />
    </div>
    <div class="serv-text">
        <div class="serv-head">
            <h3>
                Family-Self-Directed Brokerage Account with TD
                Ameritrade
            </h3>
        </div>
        <div class="serv-p">
            <div class="para">
                <p>
                    Nowadays, most investors are turning to a
                    self-directed brokerage account to take their
                    investment decisions by themselves. These accounts
                    enable you to pick and choose from every investment
                    option possible, all from funds to individual
                    stocks.
                </p>
            </div>
        </div>
    </div>
    <div class="main-btn-2">
        <a href="{{ route('services') }}#third_service">READ MORE<span class="btn-dash"><i class="fa-solid fa-minus"></i></span><span class="btn-dot"><i class="fa-solid fa-ellipsis"></i></span></a>
    </div>
    </div>
    </div> --}}
    </div>
    </div>
    <div class="main-btn text-center pt-4">
        <a href="{{route('services')}}" tabindex="0"><span>View all</span><span class="btn-arw"><i class="fa-solid fa-arrow-right"></i></span></a>
    </div>
    </div>
    </div>
</section>
<section class="wht-we-do">
    <div class="container">
        <div class="wht-we-do-wrap">
            <div class="row align-items-center g-0">
                <div class="col-xl-6" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="head-1 h-b">
                        <h2>{!! $homeContents['section_1_title'] ?? '' !!}</h2>
                    </div>
                    <div class="para p-b">
                        <p>
                            {!! $homeContents['section_1_description'] ?? '' !!}
                        </p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="white_box_wh">
                        <span>
                            <img src="{{ asset('frontend_assets/images/cl-img.png') }}" alt="" />
                        </span>
                        <h4>Dermatology</h4>
                        <a href="">Consult Now!</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="white_box_wh">
                        <span>
                            <img src="{{ asset('frontend_assets/images/cl-img.png') }}" alt="" />
                        </span>
                        <h4>Orthopedics</h4>
                        <a href="">Consult Now!</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="white_box_wh">
                        <span>
                            <img src="{{ asset('frontend_assets/images/cl-img.png') }}" alt="" />
                        </span>
                        <h4>Cardiology</h4>
                        <a href="">Consult Now!</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="white_box_wh">
                        <span>
                            <img src="{{ asset('frontend_assets/images/cl-img.png') }}" alt="" />
                        </span>
                        <h4>Gastroenterology</h4>
                        <a href="">Consult Now!</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="white_box_wh">
                        <span>
                            <img src="{{ asset('frontend_assets/images/cl-img.png') }}" alt="" />
                        </span>
                        <h4>Pediatrics</h4>
                        <a href="">Consult Now!</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="white_box_wh">
                        <span>
                            <img src="{{ asset('frontend_assets/images/cl-img.png') }}" alt="" />
                        </span>
                        <h4>Oncology</h4>
                        <a href="">Consult Now!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <section class="wht-we-do">
                    <div class="container">
                        <div class="wht-we-do-wrap">
                            <div class="row">
                                <div class="col-xl-3" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                                    <div class="head-1 h-b">
                                        <h2>{{ $homeContents['section_1_title'] ?? '' }}</h2>
                                    </div>
                                    <div class="para p-b">
                                        <p>
                                            {{ $homeContents['section_1_description'] ?? '' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-12">
                                    <div class="wht-serv">
                                        @foreach ($homeBodies as $homeBody)
    <div class="wht-slide">
                                            <div class="wht-slide-wrap" data-aos="fade-up" data-aos-easing="linear"
                                                data-aos-duration="600">
                                                <div class="wht-slide-box">
                                                    <div class="wht-slide-icon-div">
                                                        <div class="wht-slide-icon-1 wht-slide-icon">
                                                            <img src="{{ $homeBody->image }}" alt="" />
                                                        </div>

                                                    </div>
                                                    <div class="wht-slide-text">
                                                        <div class="wht-slide-h h-b pb-3">
                                                            <h3>
                                                                {{ $homeBody->title }}
                                                            </h3>
                                                        </div>
                                                        <div class="para p-b wht-slide-p">
                                                            <p>
                                                                {{ $homeBody->sub_title }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
<section class="abt-foremost" style="background: url({{ asset('frontend_assets/images/bg_dots.png') }});">
    <div class="container">
        <div class="abt-foremost1">
            <div class="abt-foremost-head text-center" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                <div class="head-1 h-b pb-3">
                    {{-- <h2>Testimonial</h2> --}}
                    <h2>{!! $homeContents['testimonial_section_title'] ?? '' !!}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="test-slider">
                    <div class="test-box-wrap" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                        <div class="test-box-1">
                            <div class="test-box">
                                <i class="fa-solid fa-quote-left"></i>
                                <div class="test-name">
                                    {{-- <h4>Venkat Vangala</h4> --}}
                                    <h4>{!! $testimonial['name'] ?? '' !!}</h4>
                                </div>
                            </div>
                            <div class="test-p">
                                {{-- <p>
                                    Venkat Vangala is a successful healthcare developer who has
                                        been a part of many renowned healthcare organizations.
                                        She served as a former health administrator of
                                        Healthcare Dual Diagnosis for ten years, a certified
                                        assisted living administrator for five years, and an
                                        insightful in formulating regulatory and complian
                                    </p> --}}
                                <p>{!! $testimonial['description'] ?? '' !!}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog-sec">
    <div class="container">
        <div class="blog-sec-wrap">
            <div class="blog-sec-head text-center pb-5" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                <div class="head-1 h-b pb-3">
                    <h2>{!! $homeContents['section_2_title'] ?? '' !!}</h2>
                </div>
                <div class="para p-b">
                    <p>
                        {!! $homeContents['section_2_description'] ?? '' !!}
                    </p>
                    {{-- <p>
                            {{ nl2br($homeContents['section_2_description'] ?? '') }}
                    </p> --}}
                </div>
            </div>
        </div>
        <div class="blog-box-wrap">
            <div class="blog_slider">
                @if ($blogs->count() > 0)
                @foreach ($blogs as $item)
                <div class="blog_padding">
                    <div class="blog-box-img">
                        <a href="{{ route('blogs.details', ['category_slug' => $item['category']['slug'], 'blog_slug' => $item['slug']]) }}">
                            <img src="{{ Storage::url($item['image']) }}" alt="" /></a>
                    </div>
                    <div class="blog-rit d-flex" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600">
                        <div class="bl-text bl-text-1">
                            <a href="{{ route('blogs.details', ['category_slug' => $item['category']['slug'], 'blog_slug' => $item['slug']]) }}">
                                <h3>{{ $item['title'] }}</h3>
                            </a>
                            <div class="date-box d-flex align-items-center">
                                <div class="bl-date-img">
                                    <img src="{{ asset('frontend_assets/images/date.png') }}" alt="" />
                                </div>
                                <div class="bl-date">
                                    <h4>{{ date("d M' Y", strtotime($item['created_at'])) }}</h4>
                                </div>
                            </div>
                            <p>
                                {!! substr($item['content'], 0, 200) !!}...
                            </p>

                        </div>
                    </div>
                </div>
                @endforeach

                <!-- <div class="col-xl-6 col-md-12 col-12">
                                        @foreach ($blogs as $item)
    <div class="blog-rit d-flex" data-aos="fade-up" data-aos-easing="linear"
                                                data-aos-duration="600">
                                                <div class="bl-lft">
                                                    <a
                                                        href="{{ route('blogs.details', ['category_slug' => $item['category']['slug'], 'blog_slug' => $item['slug']]) }}"><img
                                                            src="{{ Storage::url($item['image']) }}" alt="" /></a>
                                                </div>
                                                <div class="bl-text">
                                                    <a
                                                        href="{{ route('blogs.details', ['category_slug' => $item['category']['slug'], 'blog_slug' => $item['slug']]) }}">
                                                        <h3>{{ $item['title'] }}</h3>
                                                    </a>
                                                    <div class="date-box d-flex align-items-center pt-3">
                                                        <div class="bl-date-img">
                                                            <img src="{{ asset('frontend_assets/images/date.png') }}"
                                                                alt="" />
                                                        </div>
                                                        <div class="bl-date">
                                                            <h4>{{ date("d M' Y", strtotime($item['created_at'])) }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    @endforeach

                                    </div> -->
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
@endpush
