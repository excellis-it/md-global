@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Telehealth
@endsection
@push('styles')
@endpush

@section('content')
    @php
        use App\Helpers\Helper;
        $getTelehealth = Helper::getTelehealth();
    @endphp
    <section class="inr-bnr">
        <div class="inr-bnr-img">
            <img src="{{ asset('frontend_assets/images/tele-bg.jpg') }}" alt="" />
            <div class="inr-bnr-text">
                <h1>Telehealth</h1>
            </div>
        </div>
    </section>
    @if (count($symptoms) > 0)
        <section class="feeling-sec">
            <div class="container">
                <div class="feeling-sec-wrap">
                    <div class="head-1 h-b text-center p-5">
                        <h2>{{ $getTelehealth['symptom_title'] }}</h2>
                        <p><b>{{ $getTelehealth['symptom_description'] }}</b></p>
                    </div>

                    <div class="feel-slide">
                        @foreach ($symptoms->chunk(12) as $items)
                            <div class="feel-slide-wrap">
                                <div class="row row-cols-xxl-6 row-cols-lg-4 row-cols-md-2 row-cols-1 pb-5">
                                    @foreach ($items as $symptom)
                                        <div class="col">
                                            <div class="feel-box">
                                                <a
                                                    href="{{ route('doctors', ['type' => 'symptoms', 'slug' => $symptom['symptom_slug']]) }}">
                                                    <div class="feel-icon-div">
                                                        <div class="feel-icon-box-1 feel-icon">
                                                            <img src="{{ Storage::url($symptom['symptom_image']) }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <div class="feel-text">
                                                        <h4>
                                                            {{ $symptom['symptom_name'] }}
                                                        </h4>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="doc-ct-sec">
                    <div class="doc-ct-sec-wrap">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="doc-img">
                                    <a href="#">
                                        @if ($getTelehealth['offer_image_1'] != null)
                                            <img src="{{ Storage::url($getTelehealth['offer_image_1']) }}" alt="">
                                        @else
                                            <img src="{{ asset('frontend_assets/images/doc-1.png') }}" alt="">
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="doc-img">
                                    <a href="#">
                                         @if ($getTelehealth['offer_image_2'] != null)
                                            <img src="{{ Storage::url($getTelehealth['offer_image_2']) }}" alt="">
                                        @else
                                            <img src="{{ asset('frontend_assets/images/doc-2.png') }}" alt="">
                                         @endif
                                    </a>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 col-12">
                                <div class="doc-img">
                                    <a href="#">
                                        @if ($getTelehealth['offer_image_3'] != null)
                                            <img src="{{ Storage::url($getTelehealth['offer_image_3']) }}" alt="">
                                        @else
                                            <img src="{{ asset('frontend_assets/images/doc-3.png') }}" alt="">
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @if (count($speciliaztions) > 0)
        <section class="bk-app-sec bg-white">
            <div class="container">
                <div class="bk-app-sec-wrap">
                    <div class="row justify-content-between">
                        <div class="col-xl-6 col-12">
                            <div class="head-1 h-b">
                                <h2>{{ $getTelehealth['specialization_title'] }}</h2>
                            </div>
                        </div>
                        <div class="col-xl-3 col-12">
                            <div class="main-btn pt-4">
                                <a href="{{ route('all-specializations') }}" tabindex="0"><span>View all
                                        Specialization</span><span class="btn-arw"><i
                                            class="fa-solid fa-arrow-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="app-doc-wrap">
                        @foreach ($speciliaztions as $speciliaztion)
                            <div class="app-doc-box">
                                <a
                                    href="{{ route('doctors', ['type' => 'speciaization', 'slug' => $speciliaztion['slug']]) }}">
                                    <div class="app-doc-img">
                                        <img src="{{ Storage::url($speciliaztion['image']) }}" alt="">
                                    </div>
                                </a>
                                <div class="app-doc-text">
                                    <a
                                        href="{{ route('doctors', ['type' => 'speciaization', 'slug' => $speciliaztion['slug']]) }}">
                                        <h3>{{ $speciliaztion['name'] }}</h3>
                                    </a>
                                    <p>{{ substr($speciliaztion['description'], 0, 80) }}
                                    </p>
                                </div>
                                @if ($speciliaztion['doctor_count'] > 0)
                                    <div class="doc-avl d-flex">
                                        <div class="doc-avl-img">
                                            <img src="{{ asset('frontend_assets/images/doc-v.png') }}" alt="">
                                        </div>
                                        <div class="doc-avl-text">
                                            <h4>{{ $speciliaztion['doctor_count'] }}Medical Stuff available</h4>
                                        </div>
                                    </div>
                                @else
                                    <div class="doc-avl d-flex">
                                        <div class="doc-avl-img">
                                            <img src="{{ asset('frontend_assets/images/doc-v.png') }}" alt="">
                                        </div>
                                        <div class="doc-avl-text">
                                            <h4>Medical Stuff not available</h4>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- <section class="bk-app-sec inst-vdo">
        <div class="container">
            <div class="bk-app-sec-wrap">
                <div class="row justify-content-between">
                    <div class="col-xl-6 col-12">
                        <div class="head-1 h-b">
                            <h2>Instant video consultations with specialists</h2>
                        </div>
                    </div>
                    <div class="col-xl-3 col-12">
                        <div class="main-btn pt-4">
                            <a href="#" tabindex="0"><span>View all Specialist</span><span class="btn-arw"><i
                                        class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="app-doc-wrap">
                    <div class="app-doc-box">
                        <a href="category-list.html">
                            <div class="app-doc-img">
                                <img src="{{asset('frontend_assets/images/bk-1.png')}}" alt="">
                                <div class="vdo-div d-flex align-items-center justify-content-center">
                                    <div class="vdo-div-icon">
                                        <i class="fa-sharp fa-solid fa-video"></i>
                                    </div>
                                    <div class="vdo-div-text">
                                        <h3>VIDEO</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="app-doc-text">
                            <h3>Orthopedist</h3>
                            <p>Visit your medical stuff for joint pain, sprains, arthritis, and other bone pains.
                            </p>
                        </div>
                        <div class="doc-avl d-flex">
                            <div class="doc-avl-img">
                                <img src="{{asset('frontend_assets/images/doc-v.png')}}" alt="">
                            </div>
                            <div class="doc-avl-text">
                                <h4>51Medical Stuff available</h4>
                            </div>
                        </div>
                        <div class="av-5 py-3">
                            <h4>Available in 5 min</h4>
                        </div>
                    </div>
                    <div class="app-doc-box">
                        <a href="category-list.html">
                            <div class="app-doc-img">
                                <img src="{{asset('frontend_assets/images/bk-2.png')}}" alt="">
                                <div class="vdo-div d-flex align-items-center justify-content-center">
                                    <div class="vdo-div-icon">
                                        <i class="fa-sharp fa-solid fa-video"></i>
                                    </div>
                                    <div class="vdo-div-text">
                                        <h3>VIDEO</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="app-doc-text">
                            <h3>Dentist</h3>
                            <p>Visit your medical stuff for joint pain, sprains, arthritis, and other bone pains.
                            </p>
                        </div>
                        <div class="doc-avl d-flex">
                            <div class="doc-avl-img">
                                <img src="{{asset('frontend_assets/images/doc-v.png')}}" alt="">
                            </div>
                            <div class="doc-avl-text">
                                <h4>128Medical Stuff available</h4>
                            </div>
                        </div>
                        <div class="av-5 py-3">
                            <h4>Available in 5 min</h4>
                        </div>
                    </div>
                    <div class="app-doc-box">
                        <a href="category-list.html">
                            <div class="app-doc-img">
                                <img src="{{asset('frontend_assets/images/bk-6.png')}}" alt="">
                                <div class="vdo-div d-flex align-items-center justify-content-center">
                                    <div class="vdo-div-icon">
                                        <i class="fa-sharp fa-solid fa-video"></i>
                                    </div>
                                    <div class="vdo-div-text">
                                        <h3>VIDEO</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="app-doc-text">
                            <h3>ENT specialist</h3>
                            <p>Visit your medical stuff for joint pain, sprains, arthritis, and other bone pains.
                            </p>
                        </div>
                        <div class="doc-avl d-flex">
                            <div class="doc-avl-img">
                                <img src="{{asset('frontend_assets/images/doc-v.png')}}" alt="">
                            </div>
                            <div class="doc-avl-text">
                                <h4>51Medical Stuff available</h4>
                            </div>
                        </div>
                        <div class="av-5 py-3">
                            <h4>Available in 5 min</h4>
                        </div>
                    </div>
                    <div class="app-doc-box">
                        <a href="category-list.html">
                            <div class="app-doc-img">
                                <img src="{{asset('frontend_assets/images/bk-7.png')}}" alt="">
                                <div class="vdo-div d-flex align-items-center justify-content-center">
                                    <div class="vdo-div-icon">
                                        <i class="fa-sharp fa-solid fa-video"></i>
                                    </div>
                                    <div class="vdo-div-text">
                                        <h3>VIDEO</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="app-doc-text">
                            <h3>Dermatologist</h3>
                            <p>Visit your medical stuff for joint pain, sprains, arthritis, and other bone pains.
                            </p>
                        </div>
                        <div class="doc-avl d-flex">
                            <div class="doc-avl-img">
                                <img src="{{asset('frontend_assets/images/doc-v.png')}}" alt="">
                            </div>
                            <div class="doc-avl-text">
                                <h4>128Medical Stuff available</h4>
                            </div>
                        </div>
                        <div class="av-5 py-3">
                            <h4>Available in 5 min</h4>
                        </div>
                    </div>
                    <div class="app-doc-box">
                        <a href="category-list.html">
                            <div class="app-doc-img">
                                <img src="{{asset('frontend_assets/images/bk-8.png')}}" alt="">
                                <div class="vdo-div d-flex align-items-center justify-content-center">
                                    <div class="vdo-div-icon">
                                        <i class="fa-sharp fa-solid fa-video"></i>
                                    </div>
                                    <div class="vdo-div-text">
                                        <h3>VIDEO</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="app-doc-text">
                            <h3>Gynecologist</h3>
                            <p>Visit your medical stuff for joint pain, sprains, arthritis, and other bone pains.
                            </p>
                        </div>
                        <div class="doc-avl d-flex">
                            <div class="doc-avl-img">
                                <img src="{{asset('frontend_assets/images/doc-v.png')}}" alt="">
                            </div>
                            <div class="doc-avl-text">
                                <h4>128Medical Stuff available</h4>
                            </div>
                        </div>
                        <div class="av-5 py-3">
                            <h4>Available in 5 min</h4>
                        </div>
                    </div>
                    <div class="app-doc-box">
                        <a href="category-list.html">
                            <div class="app-doc-img">
                                <img src="{{asset('frontend_assets/images/bk-8.png')}}" alt="">
                                <div class="vdo-div d-flex align-items-center justify-content-center">
                                    <div class="vdo-div-icon">
                                        <i class="fa-sharp fa-solid fa-video"></i>
                                    </div>
                                    <div class="vdo-div-text">
                                        <h3>VIDEO</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div class="app-doc-text">
                            <h3>Gynecologist</h3>
                            <p>Visit your medical stuff for joint pain, sprains, arthritis, and other bone pains.
                            </p>
                        </div>
                        <div class="doc-avl d-flex">
                            <div class="doc-avl-img">
                                <img src="{{asset('frontend_assets/images/doc-v.png')}}" alt="">
                            </div>
                            <div class="doc-avl-text">
                                <h4>51Medical Stuff available</h4>
                            </div>
                        </div>
                        <div class="av-5 py-3">
                            <h4>Available in 5 min</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="find-doc">
                <div class="find-doc-wrap">
                    <div class="row justify-content-between">
                        <div class="col-xl-6 col-12">
                            <div class="head-1 h-b">
                                <h2>FindMedical Staff Available Near You</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="find-doc-slide">
                    <div class="find-doc-slide-wrap">
                        <div class="find-doc-slide-box d-flex">
                            <div class="find-doc-slide-img">
                                <img src="{{asset('frontend_assets/images/fd-1.png')}}" alt="">
                            </div>
                            <div class="find-doc-slide-text">
                                <h3>Sandip Rungta</h3>
                                <h4>General Physician</h4>
                                <h5>Beadon Street</h5>
                                <div class="pec-div">
                                    <span class="pec"><i class="fa-solid fa-thumbs-up"></i>99%</span>
                                    <span class="exp"><i class="fa-regular fa-period"></i> 10 Years Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="find-doc-slide-wrap">
                        <div class="find-doc-slide-box d-flex">
                            <div class="find-doc-slide-img">
                                <img src="{{asset('frontend_assets/images/fd-2.png')}}" alt="">
                            </div>
                            <div class="find-doc-slide-text">
                                <h3>Sam Rungta</h3>
                                <h4>General Physician</h4>
                                <h5>Beadon Street</h5>
                                <div class="pec-div">
                                    <span class="pec"><i class="fa-solid fa-thumbs-up"></i>99%</span>
                                    <span class="exp"><i class="fa-regular fa-period"></i> 10 Years Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="find-doc-slide-wrap">
                        <div class="find-doc-slide-box d-flex">
                            <div class="find-doc-slide-img">
                                <img src="{{asset('frontend_assets/images/fd-3.png')}}" alt="">
                            </div>
                            <div class="find-doc-slide-text">
                                <h3>Zenifer Desusa</h3>
                                <h4>General Physician</h4>
                                <h5>Beadon Street</h5>
                                <div class="pec-div">
                                    <span class="pec"><i class="fa-solid fa-thumbs-up"></i>99%</span>
                                    <span class="exp"><i class="fa-regular fa-period"></i> 10 Years Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="find-doc-slide-wrap">
                        <div class="find-doc-slide-box d-flex">
                            <div class="find-doc-slide-img">
                                <img src="{{asset('frontend_assets/images/fd-4.png')}}" alt="">
                            </div>
                            <div class="find-doc-slide-text">
                                <h3>Frank Rungta</h3>
                                <h4>General Physician</h4>
                                <h5>Beadon Street</h5>
                                <div class="pec-div">
                                    <span class="pec"><i class="fa-solid fa-thumbs-up"></i>99%</span>
                                    <span class="exp"><i class="fa-regular fa-period"></i> 10 Years Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="find-doc-slide-wrap">
                        <div class="find-doc-slide-box d-flex">
                            <div class="find-doc-slide-img">
                                <img src="{{asset('frontend_assets/images/fd-1.png')}}" alt="">
                            </div>
                            <div class="find-doc-slide-text">
                                <h3>Sandip Rungta</h3>
                                <h4>General Physician</h4>
                                <h5>Beadon Street</h5>
                                <div class="pec-div">
                                    <span class="pec"><i class="fa-solid fa-thumbs-up"></i>99%</span>
                                    <span class="exp"><i class="fa-regular fa-period"></i> 10 Years Exp</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="hw-wrks">
        <div class="container">
            <div class="hw-wrks-wrap">
                <div class="head-1 h-b text-center">
                    <h2>How it works</h2>
                </div>
                <div class="wrk-div">
                    <!-- <div class="wrk-div-bg">
                                         <img src="{{ asset('frontend_assets/images/wv.png') }}" alt="">
                                      </div> -->
                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-md-12 col-12">
                            <div class="wrk-div-box">
                                <div class="wrk-icon">
                                    @if ($getTelehealth['how_it_works_icon_1_image'] != null)
                                        <img src="{{ Storage::url($getTelehealth['how_it_works_icon_1_image']) }}"
                                            alt="{{ $getTelehealth['how_it_works_icon_1_title'] }}">
                                    @else
                                        <img src="{{ asset('frontend_assets/images/w-1.png') }}">
                                    @endif

                                </div>
                                <div class="wrk-icon-text">
                                    <h3>{{ $getTelehealth['how_it_works_icon_1_title'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-12 col-12">
                            <div class="wrk-div-box">
                                <div class="wrk-icon">
                                    @if ($getTelehealth['how_it_works_icon_2_image'] != null)
                                        <img src="{{ Storage::url($getTelehealth['how_it_works_icon_2_image']) }}"
                                            alt="{{ $getTelehealth['how_it_works_icon_2_title'] }}">
                                    @else
                                        <img src="{{ asset('frontend_assets/images/w-2.png') }}">
                                    @endif
                                </div>
                                <div class="wrk-icon-text">
                                    <h3>{{ $getTelehealth['how_it_works_icon_2_title'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-12 col-12">
                            <div class="wrk-div-box">
                                <div class="wrk-icon">
                                    @if ($getTelehealth['how_it_works_icon_3_image'] != null)
                                        <img src="{{ Storage::url($getTelehealth['how_it_works_icon_3_image']) }}"
                                            alt="{{ $getTelehealth['how_it_works_icon_3_title'] }}">
                                    @else
                                        <img src="{{ asset('frontend_assets/images/w-3.png') }}">
                                    @endif
                                </div>
                                <div class="wrk-icon-text">
                                    <h3>{{ $getTelehealth['how_it_works_icon_3_title'] }}</h3>
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
                <div class="blog-sec-head text-center pb-5" data-aos="fade-up" data-aos-easing="linear"
                    data-aos-duration="1000">
                    <div class="head-1 h-b pb-3">
                        <h2>Check Out Some Of Our Recent Blog Posts</h2>
                    </div>
                    <div class="para p-b">
                        <p>
                            We aim at changing the global perspective at health and
                            wellness in the United States by providing people the
                            necessary<br />
                            knowledge and resources.
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
                                            <img src="{{ asset('frontend_assets/images/date.png') }}') }}"
                                                alt="" />
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
                                                <img src="{{ asset('frontend_assets/images/date.png') }}') }}"
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
