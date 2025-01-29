<!DOCTYPE html>
<html lang="en">

<head>
    @php
        use App\Helpers\Helper;
    @endphp
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Swarnadwip Nath" />
    <meta name="generator" content="Hugo 0.84.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ env('APP_NAME') }}| @yield('title')</title>
    @yield('meta_title')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @if (Helper::getFavicon() != null)
        <link rel="shortcut icon" type="image/png" href="{{ Storage::url(Helper::getFavicon()) }}" />
    @else
        <link rel="shortcut icon" type="image/png" href="{{ asset('admin_assets/img/favicon.ico') }}">
    @endif

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('frontend_assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.3/animate.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="{{ asset('frontend_assets/css/menu.css') }}" rel="stylesheet" />
    <link href="{{ asset('frontend_assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('frontend_assets/css/responsive.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="{{ asset('frontend_assets/css/select2.min.css') }}">
    <style>
        #botmanWidgetRoot {
            position: fixed;
            z-index: 1;
        }

        .chatbot-title {
            font-size: 24px !important;
            font-weight: 600;
            font-family: "Times New Roman", Times, serif !important;
        }

        #messageArea {
            background-color: #f1f1f1 !important;
            color: #333 !important;
            font-size: 24px !important;
            font-weight: 400;
            font-family: "Times New Roman", Times, serif !important;
        }

        .banner {
            display: none !important;
        }

        /* M E S S A G E S */
        #messageArea {
            overflow-y: scroll;
        }

        .chat-bot {
            list-style: none;
            background: none;
            /* padding: 0;
            margin: 0; */
        }

        .chat-bot li {
            padding: 8px;
            padding: 0.5rem;
            font-size: 19px;
            overflow: hidden;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            color: #000000;
        }

        .visitor {
            -webkit-box-pack: end;
            -webkit-justify-content: flex-end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            -webkit-box-align: end;
            -webkit-align-items: flex-end;
            -ms-flex-align: end;
            -ms-grid-row-align: flex-end;
            align-items: flex-end;
        }

        .visitor .msg {
            -webkit-box-ordinal-group: 2;
            -webkit-order: 1;
            -ms-flex-order: 1;
            order: 1;
            border-top-right-radius: 2px;
        }

        .chatbot .msg {
            -webkit-box-ordinal-group: 2;
            -webkit-order: 1;
            -ms-flex-order: 1;
            order: 1;
            border-top-left-radius: 2px;
        }

        .msg {
            word-wrap: break-word;
            min-width: 50px;
            max-width: 80%;
            padding: 10px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            background: #dae1e7;
        }

        .msg p {
            margin: 0 0 0.2rem 0;
        }

        .msg .time {
            font-size: 0.7rem;
            color: #7d7b7b;
            margin-top: 3px;
            float: right;
            cursor: default;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        /* I N P U T */

        .textarea {
            position: fixed;
            bottom: 0px;
            left: 0;
            right: 0;
            width: 95%;
            height: 55px;
            z-index: 99;
            background-color: #fff;
            border: none;
            outline: none;
            padding-left: 15px;
            padding-right: 15px;
            color: #000000;
            font-weight: 300;
            font-size: 1rem;
            line-height: 1.5;
            background: rgba(250, 250, 250, 0.8);
        }

        .textarea:focus {
            background: white;
            box-shadow: 0 -6px 12px 0px rgba(235, 235, 235, 0.95);
            transition: 0.4s;
        }

        a.banners {
            position: absolute;
            bottom: 0px;
            right: 5px;
            height: 12px;
            z-index: 99;
            outline: none;
            color: #777;
            font-size: 10px;
            text-align: right;
            font-weight: 200;
            text-decoration: none
        }

        /* Loading Dot Animation */
        div.loading-dots {
            position: relative;
        }

        div.loading-dots .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 2px;
            border-radius: 50%;
            background: #196eb4;
            animation: blink 1.4s ease-out infinite;
            animation-fill-mode: both;
        }

        div.loading-dots .dot:nth-child(2) {
            animation-delay: -1.1s;
        }

        div.loading-dots .dot:nth-child(3) {
            animation-delay: -0.9s;
        }

        div.loading-dots .dot-grey {
            background: rgb(120, 120, 120);
        }

        div.loading-dots .dot-sm {
            width: 6px;
            height: 6px;
            margin-right: 2px;
        }

        div.loading-dots .dot-md {
            width: 12px;
            height: 12px;
            margin-right: 2px;
        }

        div.loading-dots .dot-lg {
            width: 16px;
            height: 16px;
            margin-right: 3px;
        }

        .chatbot-full {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 2147483647;
            box-sizing: content-box;
            overflow: hidden;
            border-radius: 5px;
            box-shadow: rgba(0, 0, 0, 0.2) 0px 0px 20px;
            width: 600px;
        }
        #userText{
            width: 100%;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 0.2;
            }

            20% {
                opacity: 1.0;
            }
        }

        @media (max-width: 768px) {
            .chatbot-title {
                font-size: 20px !important;
            }

            #messageArea {
                font-size: 20px !important;
            }

            .chatbot-full {
                width: 100%;
                right: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <main>
        @include('frontend.includes.header')
        @yield('content')
        @include('frontend.includes.footer')
    </main>
    <!-- Modal Start-->
    @if (Auth::check())
        <div id="zoom-modal-{{ Auth::user()->id }}">
            @include('frontend.includes.accept-zoom-request-modal')
        </div>
    @endif

    <!-- Modal Start-->


    <!-- Modal Start 2-->
    @if (Auth::check())
        <div id="zoom-payment-modal-{{ Auth::user()->id }}">
            @include('frontend.includes.zoom-payment-modal')
        </div>
    @endif


    <div class="modal modal-login fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-xl-9 col-md-9 col-12
                        ">
                            <div class="main_hh">
                                <div class="login_sec_right_text">
                                    <div class="login-logo">
                                        @if (Helper::getLogo() != null)
                                            <a href="{{ route('home') }}"><img
                                                    src="{{ Storage::url(Helper::getLogo()) }}" /></a>
                                        @else
                                            <a href="{{ route('home') }}"><img
                                                    src="{{ asset('frontend_assets/images/logo.png') }}" /></a>
                                        @endif
                                    </div>
                                    <div class="login-logo-head">
                                        <h1>Login to explore more</h1>
                                        <p>
                                            Log in to access your account and explore personalized features.
                                        </p>
                                    </div>
                                </div>
                                <div id="home_login_email_msg">

                                </div>
                                <div class="login_form">
                                    <form action="{{ route('login.check') }}" method="post" id="login-form">
                                        @csrf
                                        <input type="hidden" name="type" value="telehealth_page">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Email
                                                ID</label>
                                            <input type="text" class="form-control" id="home_login_email"
                                                name="email" aria-describedby="emailHelp">
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="user_type">Select User Type:</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="user_type"
                                                    id="patientRadio" value="patient"
                                                    {{ old('user_type') == 'patient' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="patientRadio">
                                                    Patient
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="user_type"
                                                    id="doctorRadio" value="doctor"
                                                    {{ old('user_type') == 'doctor' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="doctorRadio">
                                                   Medical Staff
                                                </label>
                                            </div>

                                            @if ($errors->has('user_type'))
                                                <span class="text-danger">{{ $errors->first('user_type') }}</span>
                                            @endif
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="txtPassword">Password</label>
                                            <div class="position-relative">
                                                <input type="password" id="txtPassword" class="form-control"
                                                    name="password" name="txtPassword">

                                                <button type="button" class="toggle">
                                                    <i id="eyeIcon-2" class="fa fa-eye-slash toggle"
                                                        toggle="#txtPassword"></i>
                                                </button>
                                            </div>


                                        </div>
                                        <button type="submit" class="btn btn-lg btn-primary btn-block btn-login">
                                            LOGIN
                                        </button>
                                        {{-- <div class="login-text login-text-2 text-center">
                                            <p>
                                                Don’t Have an Account? <a href="{{route('register')}}">Register NOW</a>
                                            </p>
                                        </div> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>
    {{-- Login model end --}}

    {{-- donate --}}
    <div class="modal fade" id="donateModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2" style="color: #2782ff">Make a Difference
                        Today - Donate to MD Global</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- <div>
                    <span>Support MD Global in empowering communities and providing essential aid to those in need. Your contribution helps us make lasting impacts in health, education, and community development. Join us in our mission to bring hope and change. Every dollar counts!</span>
                </div> --}}
                <div class="modal-body">
                    <form role="form" action="{{ route('donation') }}" method="post" class="require-validation"
                        data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                        id="payment-form">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="amount">Enter amount(US$)</label>
                                <input class="form-control" id="amount" name="amount" inputmode="decimal"
                                    value="">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="billing_name">First Name</label>
                                <input class="form-control has-icon" type="text" id="billing-fname"
                                    name="first_name" value="">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="billing_name">Last Name</label>
                                <input class="form-control has-icon" type="text" id="billing-lname"
                                    name="last_name" value="">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="email">Email</label>
                                <input class="form-control has-icon" type="text" id="email" name="email"
                                    value="">
                            </div>
                            <div class="pure-u-1">
                                <legend>Billing info</legend>
                            </div>
                            <hr />
                            <div class="col-lg-6 mb-3">
                                <label for="address">Address</label>
                                <input class="form-control has-icon" type="text" id="address" name="address">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="city">City</label>
                                <input class="form-control" type="text" id="city" name="city">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="country">Country</label>
                                <input class="form-control" type="text" id="country" name="country">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="state">State</label>
                                {{-- <input class="form-control" type="text" id="state" name="state"> --}}
                                <input class="form-control" type="text" id="state" name="state">

                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="postcode">Postcode</label>
                                <input class="form-control" type="text" name="postcode" id="postcode">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="card-element">Credit or debit card</label>
                            </div>
                            <hr />
                            <div class="col-md-12">
                                <label for="card-element">Card Number</label>
                                <div style="position: relative;">
                                    <input class="form-control card-number" aria-hidden="true" aria-label=" "
                                        name="card_number" id="card-number" autocomplete="off">
                                    <img id="card-type-image"
                                        src="{{ asset('frontend_assets/images/unknown.webp') }}" alt="Card Type"
                                        style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); max-height: 24px;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="card-element">Month</label>
                                <select class="form-control form-control--sm card-expiry-month valid card-expiry-month"
                                    name="card_expiry_month" id="card-expiry-month" aria-invalid="false">
                                    <option selected="" value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="card-element">Year</label>
                                <input class="form-control" aria-hidden="true" aria-label=" " id="card-expiry-year"
                                    name="card_expiry_year" autocomplete="false" maxlength="5">
                            </div>
                            <div class="col-md-4">
                                <label for="card-element">CVV</label>
                                <input class="form-control" aria-hidden="true" aria-label=" " name="card_cvc"
                                    id="card-cvc" autocomplete="false" maxlength="4">
                            </div>

                        </div>

                        <div class="mt-4">
                            <div class="pure-u-5-5 centered d-flex">
                                <button type="submit" id="submit-btn"
                                    class="pure-button sub-btn pure-button-primary">Donate
                                    US $0.00</button>
                                <p style="margin-left: 5px;"><b>We Accept </b><img
                                        src="{{ asset('frontend_assets/images/cards.png') }}" alt=""
                                        height="35px"></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- lottie --}}
    {{-- lotty model --}}
    <div class="modal fade" id="lottieSuccessModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <lottie-player src="https://lottie.host/da794aba-0b44-400c-84d7-eeb97e7b3e8f/QIyTvEJVqg.json"
                        background="##fff" speed="1" style="width: 300px; height: 150px; margin: 0 auto;" loop
                        autoplay>
                    </lottie-player>
                    <h4 style="font-size: 16px; line-height: 24px; font-weight: 500;">Try Saying Something</h4>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="desktop-closed-message-avatar"
        style="background: rgb(255, 255, 255);
    display: flex;
    justify-content: center;
    position: fixed;
    bottom: 12px;
    right: 12px;
    height: 80px;
    width: 80px;
    border: 0px;
    border-radius: 50%;
    box-shadow: rgba(0, 0, 0, 0.2) 0px 0px 20px;">
        <img src="{{ asset('frontend_assets/images/chatbot.png') }}"
            style="width: 100%; height: auto; border-radius: 999px;">
    </div> --}}

    {{-- <div id="botmanWidgetRoot" style="display: none;">
        <div class="chatbot-full">
            <div style="background: rgb(39, 130, 255); height: 40px; line-height: 30px; font-size: 20px; display: flex; justify-content: space-between; padding: 5px 0px 5px 20px; font-family: Lato, sans-serif; color: rgb(255, 255, 255); cursor: pointer; box-sizing: content-box;"
                class="header_chatbot">
                <div class="chatbot-title"
                    style="display: flex; align-items: center; padding: 0px 30px 0px 0px; font-size: 25px; font-weight: normal; color: rgb(255, 255, 255);">
                    Chat with us!</div>
                <div>
                    <svg fill="#FFFFFF" height="15" viewBox="0 0 15 15" width="15"
                        xmlns="http://www.w3.org/2000/svg"
                        style="margin-right: 15px; margin-top: 6px; vertical-align: middle;">
                        <line x1="1" y1="15" x2="15" y2="1" stroke="white"
                            stroke-width="1"></line>
                        <line x1="1" y1="1" x2="15" y2="15" stroke="white"
                            stroke-width="1"></line>
                    </svg>
                </div>
            </div>
            <div style="display: block; height: 500px; background: #fff;">
                <div id="botmanChatRoot">
                    <div>
                        <div id="messageArea">
                            <ol class="chat-bot" style="height: 440px; padding: 0;
            margin: 0;">
                                <li data-message-id="2636e716-6791-4d28-a7d5-c3bdaabf7141" class="chatbot"
                                    style="">
                                    <div class="msg">
                                        <div>
                                            <p>Hello! I am your health assistant. How can I help you today?</p>
                                        </div>
                                        <div class="time">16:09</div>
                                    </div>
                                </li>
                            </ol>
                        </div>

                        <div class="d-flex px-3">
                            <div style=" width:90%;"> <input id="userText" class="" type="text"
                                    placeholder="Type your message..." autofocus=""
                                    style="background:#fff; border:none; font-size:15px;"></div>
                            <div> <button class="start-voice-recording"
                                    style="padding: 5px; border: none; z-index: 2; background: #2782ff52; border-radius: 50%;   width: 44px; height: 44px;">
                                    <img src="{{ asset('frontend_assets/images/microphone.gif') }}" alt=""
                                        height="25px" width="25px">
                                </button></div>
                            <div class="ps-2"> <button class="send-message-chabot"
                                    style="padding: 5px; border: none; z-index: 2; background: #88888852; border-radius: 50%;   width: 44px; height: 44px;">
                                    <img src="{{ asset('frontend_assets/images/send.png') }}" alt=""
                                        height="25px" width="25px">
                                </button>
                            </div>



                        </div>

                        <a class="banners" href="https://mdglobal.org/" target="_blank">Powered by
                            MD Global</a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script src="{{ asset('frontend_assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('frontend_assets/js/custom.js') }}"></script>
    <script src="{{ asset('frontend_assets/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.3.7/jquery.jscroll.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.4.1/jquery.payment.min.js"></script>


    <script>
        $(document).ready(function() {
            var cardTypeImages = {
                'visa': '{{ 'frontend_assets/images/visa.png' }}',
                'mastercard': '{{ 'frontend_assets/images/mastercard.png' }}',
                'amex': '{{ 'frontend_assets/images/amex.png' }}',
                'unknown': '{{ 'frontend_assets/images/unknown.webp' }}'
            };

            $('#card-number').on('keyup change', function() {
                var cardNumber = $(this).val();
                var cardType = $.payment.cardType(cardNumber);

                var cardTypeImage = cardTypeImages[cardType] || cardTypeImages['unknown'];
                $('#card-type-image').attr('src', cardTypeImage);

                // Adjust CVV validation based on card type
                var cvvLength = cardType === 'amex' ? 4 : 3;
                $('#card-cvc').attr('maxlength', cvvLength);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            var $form = $(".require-validation");
            $('.require-validation').validate({
                rules: {
                    amount: {
                        required: true
                    },
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    address: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    postcode: {
                        required: true
                    },
                    card_number: {
                        required: true
                    },
                    card_expiry_month: {
                        required: true,
                        number: true
                    },
                    card_expiry_year: {
                        required: true
                    },
                    card_cvc: {
                        required: true
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },



                submitHandler: function(form) {
                    $('#loading').addClass('loading');
                    $('#loading-content').addClass('loading-content');
                    var $form = $(form),
                        inputSelector = ['input[type=email]', 'input[type=password]',
                            'input[type=text]', 'input[type=file]',
                            'textarea'
                        ].join(', '),
                        $inputs = $form.find('.required').find(inputSelector),
                        $errorMessage = $form.find('div.error');

                    $errorMessage.addClass('hide');
                    $('.has-error').removeClass('has-error');

                    $inputs.each(function(i, el) {
                        var $input = $(el);
                        if ($input.val() === '') {
                            $input.parent().addClass('has-error');
                            $errorMessage.removeClass('hide');
                            return false; // Stop processing on the first validation error
                        }
                    });

                    if (!$form.data('cc-on-file')) {
                        // e is not defined here, so remove it
                        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                        Stripe.createToken({
                            number: $('.card-number').val(),
                            cvc: $('#card-cvc').val(),
                            exp_month: $('#card-expiry-month').val(),
                            exp_year: $('#card-expiry-year').val()
                        }, stripeResponseHandler);
                    }
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');
                    toastr.error(response.error.message);

                } else {
                    // $('#loading').removeClass('loading');
                    // $('#loading-content').removeClass('loading-content');
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });
    </script>
    <script>
        $('#card-number').on('input propertychange paste', function() {
            var value = $('#card-number').val();
            var formattedValue = formatCardNumber(value);
            $('#card-number').val(formattedValue);
        });

        function formatCardNumber(value) {
            var value = value.replace(/\D/g, '');
            var formattedValue;
            var maxLength;
            // american express, 15 digits
            if ((/^3[47]\d{0,13}$/).test(value)) {
                formattedValue = value.replace(/(\d{4})/, '$1 ').replace(/(\d{4}) (\d{6})/, '$1 $2 ');
                maxLength = 17;
            } else if ((/^3(?:0[0-5]|[68]\d)\d{0,11}$/).test(value)) { // diner's club, 14 digits
                formattedValue = value.replace(/(\d{4})/, '$1 ').replace(/(\d{4}) (\d{6})/, '$1 $2 ');
                maxLength = 16;
            } else if ((/^\d{0,16}$/).test(value)) { // regular cc number, 16 digits
                formattedValue = value.replace(/(\d{4})/, '$1 ').replace(/(\d{4}) (\d{4})/, '$1 $2 ').replace(
                    /(\d{4}) (\d{4}) (\d{4})/, '$1 $2 $3 ');
                maxLength = 19;
            }

            $('#card-number').attr('maxlength', maxLength);
            return formattedValue;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#asp_ng_button_065e81241e506b').click(function() {
                $('#exampleModal1').modal('hide');
                $('#exampleModalToggle2').modal('show');
            });

            $('#amount').on('keyup', function() {
                var amount = $(this).val();
                if (amount == '') {
                    $('#submit-btn').text('Donate US$ 0.00');
                } else {
                    $('#submit-btn').text('Donate US$ ' + amount);

                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".btn_all_open").on("click", function() {
                var target = $(this).data("target");
                $(target).toggleClass("active");
            });
        });

        function dltFun() {
            $(".box_slae").removeClass("active");
        }
    </script>
    <script>
        var sender_id = @json(Auth::user()->id ?? '');
        var receiver_id;
    </script>
    <script>
        $(document).ready(function() {
            $('#eyeIcon-2').on('click', function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $('.btn-login').on('click', function(e) {
                e.preventDefault();
                var email = $('#home_login_email').val();
                var password = $('#txtPassword').val();
                var user_type = $("input[name='user_type']:checked").val();
                var url = "{{ route('check.validation') }}";
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        'email': email,
                        'password': password,
                        'user_type': user_type
                    },
                    success: function(data) {
                        if (data.status == false) {
                            // show validation error
                            $('#home_login_email_msg').html(
                                '<div class="error-msg d-flex justify-content-between" ><span class="error-text" >' +
                                data.message +
                                '</span><span class="cross-btn-1"><i class="fa-solid fa-xmark"></i></span></div>'
                            );

                        } else {
                            $('#login-form').submit();
                            $('#home_login_email').val('');
                            $('#txtPassword').val('');

                            // form submit
                            $('#myModal').modal('hide');

                        }
                    }
                });
            });
            $(document).on('click', '.cross-btn-1', function() {
                //   don't show the error div
                $('#home_login_email_msg').html('');
            });
        });
    </script>

    <script>
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                // 'closeButton': true,
                // 'debug': false,
                // 'newestOnTop': false,
                // 'progressBar': false,
                'positionClass': 'toast-top-center',
                // 'preventDuplicates': false,
                'showDuration': '10',
                'hideDuration': '10',
                'timeOut': '800',
                'extendedTimeOut': '800',
                // 'showEasing': 'swing',
                // 'hideEasing': 'linear',
                // 'showMethod': 'fadeIn',
                // 'hideMethod': 'fadeOut',
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#form-submit').on('click', function() {
                var name = $('#name').val();
                var email = $('#email').val();
                var message = $('#message').val();
                var url = "{{ route('newsletter') }}";
                if (name == '') {
                    $('#name_msg').text('Name is required');
                    return false;
                }
                if (email == '') {
                    $('#email_msg').text('Email is required');
                    return false;
                }
                if (message == '') {
                    $('#message_msg').text('Message is required');
                    return false;
                }
                // alert(url);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'name': name,
                        'email': email,
                        'message': message,
                    },
                    success: function(data) {
                        if (data.success == true) {
                            $('#name_msg').text(' ');
                            $('#email_msg').text(' ');
                            $('#message_msg').text(' ');
                            $('#name').val('');
                            $('#email').val('');
                            $('#message').val('');
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.error);
                        }
                    }
                });
            });
        });
    </script>
    {{-- <script>
        @if (!Auth::check() && !Session::has('latitude'))
            $(document).ready(function() {
                openNav();
            });
        @endif
    </script> --}}

    {{-- <script>
        /* Set the width of the side navigation to 250px */
        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script> --}}
    <script>
        function geoFindMe() {
            const status = document.querySelector("#status");
            const mapLink = document.querySelector("#map-link");

            mapLink.href = "";
            mapLink.textContent = "";

            function success(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                mapLink.href = `https://www.openstreetmap.org/#map=18/${latitude}/${longitude}`;

                // Get location by latitude and longitude
                $.ajax({
                    type: 'GET',
                    url: `https://maps.googleapis.com/maps/api/geocode/json`,
                    data: {
                        latlng: `${latitude},${longitude}`,
                        key: "{{ env('GOOGLE_CLIENT_KEY') }}"
                    },
                    success: function(data) {
                        console.log('New Geocoding API Response:', data);

                        if (data.status === 'OK') {
                            const address = data.results[0].formatted_address;
                            status.textContent = address.substring(0, 40);
                            status.textContent = status.textContent.substr(0, Math.min(status.textContent
                                .length, status.textContent.lastIndexOf(" ")));

                            // Store the location data
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('store.location') }}",
                                data: {
                                    '_token': "{{ csrf_token() }}",
                                    'latitude': latitude,
                                    'longitude': longitude,
                                    'address': address,
                                    'session_id': '{{ Session::getId() }}',
                                    'ip_address': '{{ Request::ip() }}'
                                },
                                success: function(data) {
                                    console.log('Location Store Response:', data);
                                    if (data.success) {
                                        window.location.reload();
                                    } else {
                                        toastr.error(data.error);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error('Error storing location:', textStatus,
                                        errorThrown);
                                    toastr.error('Failed to store location.');
                                }
                            });
                        } else {
                            console.error('Geocoding failed:', data.status);
                            status.textContent = "Unable to retrieve address.";
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Geocoding API request failed:', textStatus, errorThrown);
                        status.textContent = "Error retrieving location data.";
                    }
                });

                // closeNav();
            }

            function error() {
                status.textContent = "Unable to retrieve your location";
            }

            if (!navigator.geolocation) {
                status.textContent = "Geolocation is not supported by your browser";
            } else {
                status.textContent = "Locating…";
                navigator.geolocation.getCurrentPosition(success, error);
            }
        }

        document.querySelector("#find-me").addEventListener("click", geoFindMe);
    </script>


    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_CLIENT_ID') }}&libraries=places"></script>

    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            const status = document.querySelector("#status");
            var input = document.getElementById('autocomplete1');
            var autocomplete = new google.maps.places.Autocomplete(input);
            // status.textContent = "Please Set Your Location";
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
                // document.getElementById("loc").style.display = "none";
                address = place.formatted_address;
                status.textContent = address.substring(0, 40);
                status.textContent = status.textContent.substr(0, Math.min(status.textContent.length, status
                    .textContent.lastIndexOf(" ")));

                // call ajax to store lat long
                $.ajax({
                    type: 'POST',
                    url: "{{ route('store.location') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'latitude': place.geometry['location'].lat(),
                        'longitude': place.geometry['location'].lng(),
                        'address': address,
                        'session_id': '{{ Session::getId() }}',
                        'ip_address': '{{ Request::ip() }}'
                    },
                    success: function(data) {
                        if (data.success == true) {
                            // toastr.success(data.message);
                            window.location.reload();
                        } else {
                            toastr.error(data.error);
                        }
                    }
                });
                // closeNav();
            });
        }

        function openTelehealth() {
            $("#myModal").modal('show');
        }

        $("#eyeIcon1").click(function() {
            // alert('d')
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>

    <script>
        $(document).ready(function() {
            var sender_id = "{{ Auth::check() ? Auth::user()->id : '' }}";
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            let ip_address = "{{ env('SOCKET_IP_ADDRESS') }}";
            let socket_port = '3000';
            let socket = io(ip_address + ':' + socket_port);

            $(document).on("click", ".user-list", function(e) {
                var getUserID = $(this).attr("data-id");
                var dataQuery = $(this).attr("data-query");
                receiver_id = getUserID;
                if (dataQuery == 0) {
                    $(".chat-first-page").css("display", "none");
                    loadChats();
                }
            });

            function loadChats() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('doctor.chat.load') }}",
                    data: {
                        _token: $("input[name=_token]").val(),
                        reciver_id: receiver_id,
                        sender_id: sender_id,
                    },
                    success: function(resp) {
                        if (resp.status === true) {
                            $(".chat-module").html(resp.view);
                            if (resp.chat_count > 0) {
                                scrollChatToBottom();
                            }

                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + status + "\nError: " + error);
                    }
                });
            }





            function scrollChatToBottom() {
                var messages = document.getElementById("chat-container");
                messages.scrollTop = messages.scrollHeight;
            }


            $(document).on("submit", "#chat-form", function(e) {
                e.preventDefault();

                var message = $("#user-chat").val();
                var receiver_id = $(".reciver_id").val();
                var url = "{{ route('user-chat') }}";

                if (message == "") {
                    return false;
                }

                // Perform Ajax request to send the message to the server
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: $("input[name=_token]").val(),
                        message: message,
                        reciver_id: receiver_id,
                        sender_id: sender_id,
                    },
                    success: function(res) {
                        $("#user-chat").val('');
                        if (res.success) {
                            let chat = res.chat.message;
                            let created_at = res.chat.created_at;
                            let time_format_12 = moment(created_at, "YYYY-MM-DD HH:mm:ss")
                                .format("hh:mm A");

                            let html =
                                `<div class="chat-sec-left chat-sec-right pb-1"><div class="chat-sec-left-wrap d-flex justify-content-end"><div class="chat-sec-left-text-box"><div class="chat-sec-left-text"><p>` +
                                chat +
                                `</p></div><div class="tm-div d-block pt-2 text-end"><h4>` +
                                time_format_12 +
                                `</h4></div></div></div></div>`;
                            if (res.chat_count > 0) {
                                $("#chat-container").append(html);
                                scrollChatToBottom();
                            } else {
                                $("#chat-container").html(html);
                            }

                            var friends = res.friends;
                            $('.group-manage-' + sender_id).html('');
                            var new_html = '';

                            friends.forEach(user => {
                                let time_format_13 = user.last_message && user
                                    .last_message.created_at ?
                                    moment(user.last_message.created_at,
                                        "YYYY-MM-DD HH:mm:ss").format("DD MMM YYYY") :
                                    '';

                                new_html += `   <div class="dr-chat-box-1 mb-3 user-list" id="userList"
                                                        data-id="${user.friend.id}" data-query="0">
                                                        <div
                                                            class="profile-div-box dr-chat mb-3 d-flex justify-content-between align-items-center">
                                                            <div
                                                                class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                                                                <div class="profile-img">`;
                                if (user.friend.profile_picture) {
                                    new_html +=
                                        `<img src="{{ Storage::url('${user.friend.profile_picture}') }}" alt="">`;
                                } else {
                                    new_html +=
                                        `<img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">`;
                                }
                                new_html += `</div><div class="profile-text">
                                                                    <h2>
                                                                        ${user.friend.name}
                                                                    </h2>

                                                                     <p> <span>${user.last_message.message}</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="patient-age">
                                                                <h3><span>
                                                                        ${time_format_13}
                                                                    </span></h3>
                                                            </div>
                                                        </div>
                                                    </div>`;
                            });

                            $('.group-manage-' + sender_id).html(new_html);
                            // Emit chat message to the server
                            socket.emit("chat", {
                                message: message,
                                sender_id: sender_id,
                                receiver_id: receiver_id,
                                receiver_users: res.reciver_users,
                                created_at: res.chat.created_at
                            });
                        }
                    },
                });
            });

            // Socket event handling
            socket.on("chat", function(data) {
                let time_format_13 = data.created_at ?
                    moment(data.created_at, "YYYY-MM-DD HH:mm:ss").format("hh:mm A") :
                    '';
                // Only append chat if receiver_id matches
                if (data.receiver_id == sender_id) {
                    let html = `
            <div class="chat-sec-left pb-1">
                <div class="chat-sec-left-wrap d-flex">
                    <div class="chat-sec-left-text-box">
                        <div class="chat-sec-left-text">
                            <p>${data.message}</p>
                        </div>
                        <div class="tm-div d-block pt-2">
                            <h4>${time_format_13}</h4>
                        </div>
                    </div>
                </div>
            </div>`;

                    // $("#chat-container").append(html);
                    // check the chat container id is exist or not
                    if ($("#chat-container").length) {
                        console.log('chat container exist');
                        $("#chat-container").append(html);
                        scrollChatToBottom();
                    } else {
                        console.log('chat container not exist');
                    }


                    // Update user list
                    var users = data.receiver_users;
                    $('#group-manage-' + sender_id).html('');
                    var new_html = '';

                    users.forEach(user => {
                        let time_format_13 = user.last_message && user.last_message.created_at ?
                            moment(user.last_message.created_at, "YYYY-MM-DD HH:mm:ss").format(
                                "DD MMM YYYY") : '';


                        new_html += `
                <div class="dr-chat-box-1 mb-3 user-list" id="userList" data-id="${user.friend.id}" data-query="0">
                    <div class="profile-div-box dr-chat mb-3 d-flex justify-content-between align-items-center">
                        <div class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                            <div class="profile-img">
                                ${user.friend.profile_picture ?
                                    `<img src="{{ Storage::url('${user.friend.profile_picture}') }}" alt="">` :
                                    `<img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">`}
                            </div>
                            <div class="profile-text">
                                <h2>${user.friend.name}</h2>
                                  <p> <span>${user.last_message.message}</span></p>
                            </div>
                        </div>
                        <div class="patient-age">
                            <h3><span>${time_format_13}</span></h3>
                        </div>
                    </div>
                </div>`;
                    });

                    $('.group-manage-' + sender_id).html(new_html);
                }
            });


            socket.on("videoCall", function(data) {
                var videocall = data.videocall;
                $.ajax({
                    type: "POST",
                    url: "{{ route('patient.open-zoom-modal') }}",
                    data: {
                        _token: $("input[name=_token]").val(),
                        videocall: videocall,
                    },
                    success: function(resp) {
                        if (resp.status == true) {
                            $("#zoom-modal-" + videocall.receiver_id).html(resp.view);
                            $("#Modal1").modal("show");
                        } else {
                            toastr.error(resp.message);
                        }
                    },
                });

            });

            socket.on('connect', () => {
                let userId = '{{ Auth::check() ? Auth::user()->id : '' }}';
                socket.emit('userConnected', userId);
            });

            socket.on('userOnline', function(userId) {
                updateUserStatus(userId, 'online');
            });

            socket.on('userOffline', function(userId) {
                updateUserStatus(userId, 'offline');
            });

            socket.on('onlineUsers', function(userIds) {
                userIds.forEach(userId => {
                    updateUserStatus(userId, 'online');
                });
            });



            socket.on('disconnect', () => {
                console.log('Disconnected from server');
            });

            function updateUserStatus(userId, status) {
                var userStatusElement = $(`#${userId}-userStatus`);
                var userStatusClassElement = $(`#${userId}-status`);
                var userStatus = $("#zoom-video-" + userId);

                if (userStatusElement || userStatusClassElement || userStatus) {
                    if (status === 'online') {
                        userStatusElement.html('<span class="online-user"></span>Online');
                        if (userStatus) {
                            userStatus.removeClass('video-call-deactive');
                            userStatus.addClass('video-call-active');
                        }

                        if (userStatusClassElement) {
                            userStatusClassElement.addClass("active-green", "set-active-green");
                        } else {
                            console.log('User status class element not found for user:', userId);
                        }
                    } else {
                        userStatusElement.html('<span class="offline-user"></span>Offline');
                        if (userStatus) {
                            userStatus.removeClass('video-call-active');
                            userStatus.addClass('video-call-deactive');
                        }
                        if (userStatusClassElement) {
                            userStatusClassElement.removeClass("active-green", "set-active-green");
                        }
                    }
                } else {
                    console.log('User status element not found for user:', userId);
                }
            }

            $(document).on("click", ".pay-now", function(e) {
                var videocall_id = $(this).attr("data-id");
                var receiver_id = $(this).attr("data-receiverid");
                var videocall_price_id = $('.video-call-price').val();
                if (videocall_price_id == '') {
                    toastr.error('Please select a price');
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "{{ route('patient.open-pay-now-modal') }}",
                    data: {
                        _token: $("input[name=_token]").val(),
                        videocall_id: videocall_id,
                        videocall_price_id: videocall_price_id,
                    },
                    success: function(resp) {
                        if (resp.status == true) {
                            $("#zoom-payment-modal-" + receiver_id).html(resp.view);
                            $("#Modal1").modal("hide");
                            $("#Modal3").modal("show");
                        } else {
                            toastr.error(resp.message);
                        }
                    },
                });
            });


        });
    </script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <!-- Botman Widget -->
    <!-- Botman Widget -->


    <script>
        function scrolldown() {
            var chatContainer = document.getElementById('messageArea');
            if (chatContainer) {
                chatContainer.scrollTo({
                    top: chatContainer.scrollHeight,
                    behavior: 'smooth', // Smooth scrolling for better UX
                });
            }
        }

        var random = Math.floor(Math.random() * 1000000);
        var isRecording = false;

        function startVoiceRecording() {
            if (!('webkitSpeechRecognition' in window)) {
                alert("Voice recognition not supported in this browser.");
                return;
            }
            if (!isRecording) {
                isRecording = true;

                // Show the modal when recording starts
                $('#lottieSuccessModal').modal('show');

                var recognition = new webkitSpeechRecognition();
                recognition.lang = 'en-US';
                recognition.interimResults = false;
                recognition.maxAlternatives = 1;

                recognition.start();

                recognition.onresult = function(event) {
                    var transcript = event.results[0][0].transcript;
                    console.log(transcript);

                    sendToBotmanIframe(transcript);
                    recognition.stop();
                };

                recognition.onend = function() {
                    stopVoiceRecording();
                };

                recognition.onerror = function(event) {
                    console.error("Error in recognition: " + event.error);
                    stopVoiceRecording();
                };
            } else {
                stopVoiceRecording();
            }
        }

        function stopVoiceRecording() {
            $('#lottieSuccessModal').modal('hide');
            isRecording = false;
        }

        function sendToBotmanIframe(transcript) {
            // alert(transcript);
            var created_at = new Date().toLocaleTimeString();
            var time_format_12 = moment(created_at, "HH:mm").format("hh:mm A");

            var userMessageHtml = `
                <li data-message-id="${Math.floor(Math.random() * 1000000)}" class="visitor">
                    <div class="msg">
                        <div><p>${transcript}</p></div>
                        <div class="time"><span>${time_format_12}</span></div>
                    </div>
                </li>`;
            var chatContainer = document.querySelector('.chat-bot');
            if (chatContainer) {
                chatContainer.innerHTML += userMessageHtml;
                scrolldown(); // Ensure chat scrolls after user message
            }

            $.ajax({
                type: "POST",
                url: "{{ route('botman') }}",
                data: {
                    driver: "web",
                    userId: random,
                    message: transcript,
                    attachment: null,
                    interactive: 1,
                },
                success: function(data) {
                    if (data && data.messages) {
                        data.messages.forEach(function(message) {
                            var botResponseHtml;

                            if (message.type === 'actions') {
                                botResponseHtml = `
                                    <li data-message-id="${Math.floor(Math.random() * 1000000)}" class="chatbot">
                                        <div class="msg">
                                            <div>
                                                <div>${message.text}</div>
                                                <div>
                                                    <div class="btn">Yes</div>
                                                    <div class="btn">No</div>
                                                </div>
                                            </div>
                                            <div class="time">${time_format_12}</div>
                                        </div>
                                    </li>`;
                            } else {
                                botResponseHtml = `
                                    <li data-message-id="${Math.floor(Math.random() * 1000000)}" class="chatbot">
                                        <div class="msg">
                                            <div>${message.text}</div>
                                            <div class="time">${time_format_12}</div>
                                        </div>
                                    </li>`;
                            }

                            if (chatContainer) {
                                chatContainer.innerHTML += botResponseHtml;
                            }
                        });
                        scrolldown(); // Ensure chat scrolls after bot responses
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error sending message:", status, error);
                    alert("Something went wrong! Please try again.");
                }
            });
        }

        $(document).ready(function() {
            $(".start-voice-recording").on("click", function() {
                startVoiceRecording();
            });

            $(document).on('keydown', '#userText', function(e) {
                var message = $(this).val();
                if (message != '') {
                    if (e.keyCode == 13 && message != '') {
                        sendToBotmanIframe(message);
                        $(this).val('');
                    }

                }

            });

            $(document).on('click', '.reply-mes', function() {
                var message = $(this).data('response');
                if (message != '') {
                    sendToBotmanIframe(message);
                    $(this).val('');
                }

            });

            $(document).on('click', '.send-message-chabot', function(e) {
                var message = $('#userText').val();
                if (message != '') {
                    sendToBotmanIframe(message);
                    $('#userText').val('');
                }
            });


        });
    </script>


    <script>
        $(document).ready(function() {
            $(".desktop-closed-message-avatar").on("click", function() {
                // botmanWidgetRoot
                var botmanWidgetRoot = document.getElementById('botmanWidgetRoot');
                if (botmanWidgetRoot) {
                    botmanWidgetRoot.style.display = 'block';
                }
            });

            // header_chatbot
            $(".header_chatbot").on("click", function() {
                // botmanWidgetRoot
                var botmanWidgetRoot = document.getElementById('botmanWidgetRoot');
                if (botmanWidgetRoot) {
                    botmanWidgetRoot.style.display = 'none';
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
