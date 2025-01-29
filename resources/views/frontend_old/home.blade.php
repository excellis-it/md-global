@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
MD Global  Organization for Personalized Healthcare for all.
<meta name="keywords" content="Affordability, Competition, Transparency , Shopping for Healthcare, Full Access to Healthcare">
	<meta name="description" content="An organization committed to placing Consumers in Drivers Seat with lowered premiums and Health Savings Accounts, where they can shop for healthcare and save lots of money with triple tax benefits.">
@endsection
@push('styles')
@endpush

@section('content')
    <section class="banner__slider banner_sec">
        <div class="slider stick-dots">
            @foreach($banners as $key =>$banner)
            <div class="slide">
                <div class="slide__img">
                    <img src="{{ $banner->image }}" alt="" data-lazy=""
                        class="full-image" />
                </div>
                <div class="slide__content slide__content__left">
                    <div class="slide__content--headings text-left" data-aos="fade-up" data-aos-easing="linear"
                        data-aos-duration="1000">
                        <h1 class="title">
                            {{ $key+1 }}. {{ $banner->title }}
                        </h1>
                        <p class="top-title">
                            {{ $banner->sub_title }}
                        </p>
                    </div>
                    <div class="main-btn pt-4">
                        @if (!Auth::check() )
                            <a href="{{ route('login') }}"><span>get started</span><span class="btn-arw"><i
                                        class="fa-solid fa-arrow-right"></i></span></a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    <section class="wht-we-do">
        <div class="container">
            <div class="wht-we-do-wrap">
                <div class="row">
                    <div class="col-xl-3" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                        <div class="head-1 h-b">
                            <h2>{{$homeContents['section_1_title'] ?? ''}}</h2>
                        </div>
                        <div class="para p-b">
                            <p>
                                {{$homeContents['section_1_description'] ?? ''}}
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-12">
                        <div class="wht-serv">
                            @foreach($homeBodies as $homeBody)
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
    </section>
    {{-- <section class="abt-sec">
        <div class="container">
            <div class="abt-sec-wrap">
                <div class="row justify-content-between">
                    <div class="col-xl-5 col-md-6 col-12">
                        <div class="abt-vdo">
                            <div class="">
                                <iframe width="100%" height="315" src="https://www.youtube.com/embed/tE0iX5Z6Aek"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-12">
                        <div class="abt-text pb-3" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                            <div class="head-1 h-b">
                                <h2>About Us</h2>
                            </div>
                            <div class="para p-b">
                                <p>
                                    <b>The Trusted Investment Platform For High-Yield
                                        Investments</b>
                                </p>
                                <p>
                                    We can delete thatpage- Most of the content from this page
                                    can be explained in About USpage with question and answers
                                    page about HSA's, Primary Care andSpecialists - how they
                                    were chosen to the website. Primarily fromEnrollments of
                                    Healthcare Professionals & Patients through
                                    MembershipServices , irrespective of their
                                    residence,race,color or sex.
                                </p>
                            </div>
                            <div class="main-btn pt-4">
                                <a href="{{ route('about-us') }}" tabindex="0"><span>read more</span><span
                                        class="btn-arw"><i class="fa-solid fa-arrow-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="service">
        <div class="container">
            <div class="service-wrap">
                <div class="service-head text-center" data-aos="fade-up" data-aos-easing="linear"
                    data-aos-duration="1000">
                    <div class="head-1 h-w">
                        <h2>Our Services</h2>
                    </div>
                </div>
                <div class="serv-wrap pt-5">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="serv-box" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="300">
                                <div class="serv-text">
                                    <div class="serv-head h-w pb-5">
                                        <h3>Individual Online Enrollment (IOE) Link</h3>
                                    </div>
                                    <div class="serv-p">
                                        <div class="para p-w">
                                            <p>
                                                At Foremost Organization, we provide stratified
                                                individual online enrollments for your Health
                                                Savings Account and other accounts related to real
                                                estate, rehabilitation, and other such areas.
                                                Complete your application within 10 minutes and get
                                                quick access to your enrollment with our assistance.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-btn-2">
                                    <a href="{{ route('services') }}#first_service">READ MORE<span class="btn-dash"><i
                                                class="fa-solid fa-minus"></i></span><span class="btn-dot"><i
                                                class="fa-solid fa-ellipsis"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="serv-box" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="600">
                                <div class="serv-text">
                                    <div class="serv-head h-w pb-5">
                                        <h3>Employer Sign-up Link</h3>
                                    </div>
                                    <div class="serv-p">
                                        <div class="para p-w">
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
                                    <a href="{{ route('services') }}#second_service">READ MORE<span class="btn-dash"><i
                                                class="fa-solid fa-minus"></i></span><span class="btn-dot"><i
                                                class="fa-solid fa-ellipsis"></i></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="serv-box" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="900">
                                <div class="serv-text">
                                    <div class="serv-head h-w pb-5">
                                        <h3>
                                            Family-Self-Directed Brokerage Account with TD
                                            Ameritrade
                                        </h3>
                                    </div>
                                    <div class="serv-p">
                                        <div class="para p-w">
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
                                    <a href="{{ route('services') }}#third_service">READ MORE<span class="btn-dash"><i
                                                class="fa-solid fa-minus"></i></span><span class="btn-dot"><i
                                                class="fa-solid fa-ellipsis"></i></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="abt-foremost">
        <div class="container">
            <div class="abt-foremost">
                <div class="abt-foremost-head text-center" data-aos="fade-up" data-aos-easing="linear"
                    data-aos-duration="1000">
                    <div class="head-1 h-b pb-3">
                        <h2>About Foremost Organization and HSAs</h2>
                    </div>
                    <div class="para p-b">
                        <p>
                            The Foremost Organization is one of the leading investment
                            platforms in the market that embark on projects that are from
                            a wide variety of industries including retail, food service,
                            accommodation services, multifamily, assisted living, skilled
                            nursing, medical offices, hospitals, construction, and
                            professional offices.
                        </p>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="test-slider">
                <div class="test-box-wrap" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="test-box-1-1">
                        <div class="test-box-1-2">
                            <div class="test-box-1">
                                <div class="test-box">
                                    <div class="test-img">
                                        <img src="{{ asset('frontend_assets/images/test-img.png') }}" alt="" />
                                    </div>
                                    <div class="test-name">
                                        <h4>Mary Brown</h4>
                                    </div>
                                </div>
                                <div class="test-p">
                                    <p>
                                        Mrs. Brown is a successful healthcare developer who has
                                        been a part of many renowned healthcare organizations.
                                        She served as a former health administrator of
                                        Healthcare Dual Diagnosis for ten years, a certified
                                        assisted living administrator for five years, and an
                                        insightful in formulating regulatory and complian
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="test-box-wrap" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="test-box-1-1">
                        <div class="test-box-1-2">
                            <div class="test-box-1">
                                <div class="test-box">
                                    <div class="test-img">
                                        <img src="{{ asset('frontend_assets/images/test-img.png') }}" alt="" />
                                    </div>
                                    <div class="test-name">
                                        <h4>Mary Brown</h4>
                                    </div>
                                </div>
                                <div class="test-p">
                                    <p>
                                        Mrs. Brown is a successful healthcare developer who has
                                        been a part of many renowned healthcare organizations.
                                        She served as a former health administrator of
                                        Healthcare Dual Diagnosis for ten years, a certified
                                        assisted living administrator for five years, and an
                                        insightful in formulating regulatory and complian
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="test-box-wrap" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="test-box-1-1">
                        <div class="test-box-1-2">
                            <div class="test-box-1">
                                <div class="test-box">
                                    <div class="test-img">
                                        <img src="{{ asset('frontend_assets/images/test-img.png') }}" alt="" />
                                    </div>
                                    <div class="test-name">
                                        <h4>Mary Brown</h4>
                                    </div>
                                </div>
                                <div class="test-p">
                                    <p>
                                        Mrs. Brown is a successful healthcare developer who has
                                        been a part of many renowned healthcare organizations.
                                        She served as a former health administrator of
                                        Healthcare Dual Diagnosis for ten years, a certified
                                        assisted living administrator for five years, and an
                                        insightful in formulating regulatory and complian
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="test-box-wrap" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                    <div class="test-box-1-1">
                        <div class="test-box-1-2">
                            <div class="test-box-1">
                                <div class="test-box">
                                    <div class="test-img">
                                        <img src="{{ asset('frontend_assets/images/test-img.png') }}" alt="" />
                                    </div>
                                    <div class="test-name">
                                        <h4>Mary Brown</h4>
                                    </div>
                                </div>
                                <div class="test-p">
                                    <p>
                                        Mrs. Brown is a successful healthcare developer who has
                                        been a part of many renowned healthcare organizations.
                                        She served as a former health administrator of
                                        Healthcare Dual Diagnosis for ten years, a certified
                                        assisted living administrator for five years, and an
                                        insightful in formulating regulatory and complian
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="blog-sec">
        <div class="container">
            <div class="blog-sec-wrap">
                <div class="blog-sec-head text-center pb-5" data-aos="fade-up" data-aos-easing="linear"
                    data-aos-duration="1000">
                    <div class="head-1 h-b pb-3">
                        <h2>{{$homeContents['section_2_title'] ?? ''}}</h2>
                    </div>
                    <div class="para p-b">
                        <p>
                            {{nl2br($homeContents['section_2_description'] ?? '')}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="blog-box-wrap">
                <div class="row justify-content-between">
                    @if ($blogs->count() > 0)
                        <div class="col-xl-6 col-md-12 col-12">
                            <div class="blog-box-img">
                                <a
                                    href="{{ route('blogs.details', ['category_slug' => $blog['category']['slug'], 'blog_slug' => $blog['slug']]) }}">
                                    <img src="{{ Storage::url($blog['image']) }}" alt="" /></a>
                            </div>
                            <div class="blog-rit d-flex" data-aos="fade-up" data-aos-easing="linear"
                                data-aos-duration="600">
                                <div class="bl-text bl-text-1">
                                    <a
                                        href="{{ route('blogs.details', ['category_slug' => $blog['category']['slug'], 'blog_slug' => $blog['slug']]) }}">
                                        <h3>{{ $blog['title'] }}</h3>
                                    </a>
                                    <p>
                                        {!! substr($blog['content'], 0, 200) !!}...
                                    </p>
                                    <div class="date-box d-flex align-items-center">
                                        <div class="bl-date-img">
                                            <img src="{{ asset('frontend_assets/images/date.png') }}" alt="" />
                                        </div>
                                        <div class="bl-date">
                                            <h4>{{ date("d M' Y", strtotime($blog['created_at'])) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-12 col-12">
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

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
