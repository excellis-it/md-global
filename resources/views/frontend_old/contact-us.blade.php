@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Services
@endsection
@push('styles')
@endpush

@section('content')
    <section class="inr-bnr">
        <div class="inr-bnr-img">
            <img src="{{ asset('frontend_assets/images/blog-bg.jpg')}}" alt="" />
            <div class="inr-bnr-text">
                <h1>Contact</h1>
            </div>
        </div>
    </section>
    <section class="inner_contact_sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="abt_content font_size_line_height" data-aos="fade-up" data-aos-duration="1000">
                        <div class="con-head">
                            <h4 data-aos="fade-up">Contact Us</h4>
                        </div>
                        <form class="inr-frm" method="post" action="{{ route('contact-us.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>First name</label>
                                    <input type="text" class="form-control" id="" value="{{ old('first_name') }}" placeholder="" name="first_name"
                                         />
                                        @if($errors->has('first_name'))
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Last name</label>
                                    <input type="text" class="form-control" id="" value="{{ old('last_name') }}" placeholder="" name="last_name"
                                         />
                                        @if($errors->has('last_name'))
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                        @endif
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Email Id</label>
                                    <input type="text" class="form-control" id="" value="{{ old('email') }}" placeholder="" name="email"
                                         />
                                        @if($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                </div>
                                <div class="form-group col-lg-6 col-md-12">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" id="" value="{{ old('phone') }}" placeholder="" name="phone"
                                         />
                                        @if($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                </div>
                                <div class="form-group col-12">
                                    <label>Message</label>
                                    <textarea class="form-control" id="" placeholder="" rows="3" name="message">{{ old('message') }}</textarea>
                                    @if($errors->has('message'))
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-12">
                                    <!-- <a class="red_btn red_btn_2" href="about.html"><span>Read more</span><i class="fa-solid fa-arrow-right"></i></a> -->
                                    <input type="submit" value="Submit" class="sub-btn" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="google_map" data-aos="fade-up" data-aos-duration="1000">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3291.609105343673!2d-117.28107092362244!3d34.41128019868601!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c35de6101f709b%3A0xcf16c0069d48becb!2s17581%20Sultana%20St%2C%20Hesperia%2C%20CA%2092345%2C%20USA!5e0!3m2!1sen!2sin!4v1684491862845!5m2!1sen!2sin"
                            width="100%" height="530" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="inner_contact_sec pt-0 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1200">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-4 col-md-12 aos-init aos-animate" data-aos="fade-up" data-aos-duration="500">
                    <div class="main_loc">
                        <div class="main_icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div class="main_text">
                            <h5>VISIT US</h5>
                            <p>{{ $detail['visit_us'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1000">
                    <div class="main_loc">
                        <div class="main_icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div class="main_text">
                            <h5>CALL US</h5>
                            <a href="tel:{{ $detail['call_us'] }}">{{ $detail['call_us'] }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 aos-init aos-animate" data-aos="fade-up" data-aos-duration="1500">
                    <div class="main_loc">
                        <div class="main_icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div class="main_text">
                            <h5>MAIL US</h5>
                            <a href="mailto:{{ $detail['mail_us'] }}">{{ $detail['mail_us'] }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
