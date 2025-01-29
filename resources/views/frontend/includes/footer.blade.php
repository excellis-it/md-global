@php
    use App\Helpers\Helper;
@endphp
<footer class="ftr-sec">
    <div class="ftr-top">
        <div class="container">
            <div class="ftr-top-wrap">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="ftr-logo">
                            @if (Helper::getLogo() != null)
                                <img src="{{ Storage::url(Helper::getLogo()) }}" />
                            @else
                                <img src="{{ asset('frontend_assets/images/logo.png') }}" />
                            @endif
                        </div>
                        <div class="indus-head">
                            <p>
                                {!! Helper::getFooterCms()['footer_description'] ?? '' !!}
                            </p>
                            <a href="#" class="read-btn">READ MORE</a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-9 col-md-12 col-12">
                        <div class="row justify-content-between">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                <div class="find-us">
                                    <h4>Find us</h4>
                                    <div class="add d-flex">
                                        <div class="add-icon">
                                            <span><i class="fa-solid fa-location-dot"></i></span>
                                        </div>
                                        <div class="add-text">
                                            <h4>{{ Helper::getFooterCms()['website_name'] ?? '' }}</h4>
                                            <p>
                                                {{ Helper::getFooterCms()['address'] ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="add d-flex">
                                        <div class="add-icon">
                                            <span><i class="fa-solid fa-phone"></i></span>
                                        </div>
                                        <div class="add-text">
                                            <a href="tel: {{ Helper::getFooterCms()['phone'] ?? '' }}"> {{ Helper::getFooterCms()['phone'] ?? '' }}</a>
                                        </div>

                                    </div>
                                    <div class="add d-flex">
                                        <div class="add-icon">
                                            <span><i class="fa-solid fa-envelope"></i></span>
                                        </div>
                                        <div class="add-text">
                                            <a href="mailto:{{ Helper::getFooterCms()['email'] ?? '' }}">{{ Helper::getFooterCms()['email'] ?? '' }}</a>
                                        </div>
                                    </div>
                                    <div class="add d-flex">
                                        <div class="add-icon">
                                            <span><i class="fa-solid fa-briefcase"></i></span>
                                        </div>
                                        <div class="add-text">
                                            <a href="tel:{{ Helper::getFooterCms()['business_phone'] ?? '' }}"> {{ Helper::getFooterCms()['business_phone'] ?? '' }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                                <div class="find-us">
                                    <h4>
                                        {{ Helper::getFooterCms()['newsletter_title'] ?? '' }}
                                    </h4>
                                    <div class="ftr-frm">
                                        <form action="javascript:void(0);">
                                            <div class="row">
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <input type="text" class="form-control" id="name"
                                                        value="" placeholder="FULL NAME" required="" />
                                                    <span class="text-danger" id="name_msg"></span>
                                                </div>
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <input type="text" class="form-control" id="email"
                                                        value="" placeholder="EMAIL ID" required="" />
                                                    <span class="text-danger" id="email_msg"></span>
                                                </div>
                                                <div class="form-group col-12">
                                                    <textarea class="form-control" id="message" placeholder="YOUR MESSAGE" rows="2"></textarea>
                                                    <span class="text-danger" id="message_msg"></span>
                                                </div>
                                            </div>
                                            <div class="main-btn">
                                                <a href="javascript:void(0);" class="red_btn red_btn_2"
                                                    id="form-submit"><span>Submit</span></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ftr-btm-sec text-center">
        <div class="col-xl-12">
            <div class="social-icon">
                <ul>
                    @if (isset(Helper::getFooterCms()['footerSocialLinks']))
                    @foreach (Helper::getFooterCms()['footerSocialLinks'] as $item)
                        <li>
                            <a href="{{ $item['link'] }}" target="_blank"><span><i
                                    class="{{ $item['icon'] }}"></i></span></a>
                        </li>
                    @endforeach

                    @endif
                </ul>
            </div>
            <div class="ftr-link">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('telehealth') }}">Telehealth</a></li>
                    <li><a href="{{ route('membership-plans') }}">Membership Plans</a></li>
                    <li><a href="{{ route('blogs') }}">Q&A / Blogs</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                </ul>
            </div>
            <div class="ftr-btm">
                <ul>
                    <li class="bdr_1">
                        <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                    </li>
                    <li><a href="{{ route('terms-and-conditions') }}">Terms & Conditions</a></li>
                </ul>
                <p>
                    Copyright © {{ date('Y') }} MD Global. All Rights Reserved DESIGNED &
                    DEVELOPED BY <a href="https://www.excellisit.com/">EXCELLIS IT</a>·
                </p>
            </div>
        </div>
    </div>
</footer>
