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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
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



    <div class="float-btn" style="{{ Auth::check() && Auth::user()->hasRole('DOCTOR') ? 'display:none;' : '' }}">
        <a href=""><span><i class="fa-regular fa-comment"></i></span>Chat With Us</a>
    </div>
    <!-- Modal -->
    <div class="modal_1" style="{{ Auth::check() && Auth::user()->hasRole('DOCTOR') ? 'display:none;' : '' }}">
        <div class="mn-btn">
            <a href="#"><span>Ask a Question</span></a>
        </div>
    </div>

    {{-- modal for login --}}
    {{-- <div class="modal modal-2" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                    <!-- <span aria-hidden="true">&times;</span> -->
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Please Login!!</h4>

                    <form class="" action="{{ route('login.check') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Email ID</label>
                            <input type="text" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" value="{{ old('email') }}" name="email" />
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="txtPassword">Password</label>
                            <div class="position-relative">
                                <input type="password" id="password-field" class="form-control" name="password" />
                                <button type="button" id="btnToggle" class="toggle toggle-1">
                                    <i id="eyeIcon1" toggle="#password-field" class="fa fa-eye-slash toggle"></i>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                            <div class="login-text text-right">
                                <p>
                                    <a href="{{ route('forget.password') }}">Forgot Password?</a>
                                </p>
                            </div>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block btn-login">
                            LOGIN
                        </button>
                        <div class="login-text login-text-2 text-center">
                            <p>
                                Don’t Have an Account? <a href="{{ route('register') }}">Register NOW</a>
                            </p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}
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
                                            Lorem ipsum dolor sit amet, consectetur adipiscing
                                            elit.
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

                                            <div class="login-text text-right">
                                                <p>
                                                    <a href="#">Forgot Password?</a>
                                                </p>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-lg btn-primary btn-block btn-login">
                                            LOGIN
                                        </button>
                                        <div class="login-text login-text-2 text-center">
                                            <p>
                                                Don’t Have an Account? <a href="register.html">Register NOW</a>
                                            </p>
                                        </div>
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
                var url = "{{ route('check.validation') }}";
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        'email': email,
                        'password': password,
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
    <script>
        @if (!Auth::check() && !Session::has('latitude'))
            $(document).ready(function() {
                openNav();
            });
        @endif
    </script>

    <script>
        /* Set the width of the side navigation to 250px */
        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        /* Set the width of the side navigation to 0 */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>
    <script>
        function geoFindMe() {
            const status = document.querySelector("#status");
            const mapLink = document.querySelector("#map-link");

            mapLink.href = "";
            mapLink.textContent = "";

            function success(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // status.textContent = "Please Set Your Location";
                mapLink.href = `https://www.openstreetmap.org/#map=18/${latitude}/${longitude}`;
                // mapLink.textContent = `Latitude: ${latitude} °, Longitude: ${longitude} °`;
                console.log(latitude, longitude);

                // get location by lat long
                $.ajax({
                    type: 'GET',
                    url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyAtdLUrYOZEPTIwBYj82DR13s4MU2ngtrE`,
                    success: function(data) {
                        if (data.status == 'OK') {
                            // $('#status').text(data.results[0].formatted_address);
                            // document.getElementById("loc").style.display = "none";
                            var address = data.results[0].formatted_address;
                            status.textContent = address.substring(0, 40);
                            status.textContent = status.textContent.substr(0, Math.min(status.textContent
                                .length, status.textContent.lastIndexOf(" ")));
                            console.log(status.textContent);

                            // call ajax to store lat long
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
                                    // if (data.success == true) {
                                    //     toastr.success(data.message);
                                    // } else {
                                    //     toastr.error(data.error);
                                    // }
                                }
                            });
                        }
                    }
                });
                // end get location by lat long
                //call closenav function
                closeNav();
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
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtdLUrYOZEPTIwBYj82DR13s4MU2ngtrE&libraries=places"></script>

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
                        // if (data.success == true) {
                        //     toastr.success(data.message);
                        // } else {
                        //     toastr.error(data.error);
                        // }
                    }
                });
                closeNav();
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

    @stack('scripts')
</body>

</html>
