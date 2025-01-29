@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Membership Plans
@endsection
@push('styles')
<style>
    .hide {
        display: none;
    }
</style>
@endpush

@section('content')
    <section class="inr-bnr">
        <div class="inr-bnr-img">
            <img src="{{ 'frontend_assets/images/blog-bg.jpg' }}" alt="" />
            <div class="inr-bnr-text">
                <h1>Membership</h1>
            </div>
        </div>
    </section>
    <section class="mem-sec">
        <div class="container">
            <div class="mem-sec-wrap">
                <div class="row justify-content-center align-items-center">
                    @foreach ($plans as $key => $plan)
                        <div class="col-xl-3 col-lg-6 col-12">
                            <div class="mem-box-wrap">
                                <div
                                    class="mem-box @if ($key == 1) mem-box-2 @endif @if ($key == 2) mem-box-3 @endif">
                                    <h3>{{ $plan['plan_name'] }}</h3>
                                </div>
                                <div class="price-box">
                                    <h2><span>USD</span>${{ $plan['plan_price'] }}<span>({{ $plan['plan_type'] }})</span>
                                    </h2>
                                </div>
                                <div class="mem-list">
                                    <ul>
                                        @foreach ($plan->specifications as $specification)
                                            <li>{{ $specification['specification_name'] }}</li>
                                        @endforeach
                                    </ul>
                                    <div class="main-btn pt-4">
                                        <a href="javascript:void(0);" tabindex="0" class="payment_now"
                                            data-id="{{ $plan['id'] }}"><span>buy now</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Start 2-->
    <div class="modal on-modal on-modal-2 fade" id="Modal2" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content membership-title">
                <!-- <div class="mdl-img">
                                         <div class="find-doc-slide-img">
                                             <img src="{{ asset('frontend_assets/images/fd-2.png') }}" alt="">
                                         </div>
                                     </div> -->
                <div class="mdl-cam">
                    <i class="fa-sharp fa-solid fa-user"></i>
                </div>
                <div class="modal-header ">
                    <h5 class="modal-title " id="exampleModalLabel">For Membership <span class="membership-name"></span>
                        <span>Plan $</span><span class="membership-price">9.9</span>
                    </h5>
                    <div class="stripe">
                        <img src="{{ asset('frontend_assets/images/stripe.png') }}" alt="">
                    </div>
                    <div class="stripe-p">
                        <h5>Payment via stripe</h5>
                    </div>
                </div>
                <form action="{{ route('membership.payment') }}" method="POST" role="form" class="require-validation"
                    data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">

                    @csrf
                    <div class="modal-body">
                        <div class="payment-form">

                            <input type="hidden" name="plan_id" id="plan_id" class="plan_id">
                            <div class="form-group pb-3">
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="name" @if (Auth::check())
                                    value="{{ Auth::user()->name }}"
                                @endif
                                    placeholder="Full Name">
                            </div>
                            <div class="form-group pb-3">
                                <input type="text" class="form-control card-number" id="card-number"
                                    placeholder="Debit/ Credit Card Number">
                            </div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="cvv-div d-flex justify-content-center align-items-center">
                                        <div class="form-group">
                                            <input type="text" class="form-control card-cvc"
                                                id="exampleFormControlInput1" placeholder="CVV">
                                        </div>
                                        <div class="cvv-icon ms-2">
                                            <a href="#" data-toggle="tooltip" title="Example tooltip">
                                                <i class="fa-solid fa-info"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 cvv-date">
                                    <div class="row">
                                        <div class="form-group d-flex pb-3">
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-xl-5">
                                                    <label for="exampleFormControlInput1" class="form-label">Expiry
                                                        Date:</label>
                                                </div>
                                                <div class="col-xl-7">
                                                    <div class="row justify-content-center align-items-center">
                                                        <div class="col-xl-5">
                                                            <input type="text"
                                                                class="form-control me-2 card-expiry-month"
                                                                id="exampleFormControlInput1" placeholder="MM">
                                                        </div>
                                                        <div class="col-xl-7">
                                                            <input type="text" class="form-control me-2 card-expiry-year"
                                                                id="exampleFormControlInput1" placeholder="YYYY">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group pb-3">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='form-row row'>
                                <div class='col-md-12 error form-group hide'>
                                    <div class='alert-danger alert'></div>
                                </div>
                            </div>
                        </div>
                        <div class="mdl-btn">
                            <button type="submit"><span>Pay now</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Start-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".payment_now").click(function() {
                var id = $(this).data('id');
                // $("#Modal2").modal('show');
                $.ajax({
                    url: "{{ route('membership.model') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        if (response.status == true) {
                            $('.membership-name').text(response.data.plan_name);
                            $('.membership-price').text(response.data.plan_price);
                            $('#plan_id').val(response.data.id);
                            $("#Modal2").modal('show');
                        } else {
                            toastr.error(response.message, 'Error Alert', {
                                timeOut: 8000
                            });
                            window.location.href = "{{ route('login') }}";
                        }
                    }
                });
            });
        });
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

    <script type="text/javascript">
        $(function() {

            /*------------------------------------------
            --------------------------------------------
            Stripe Payment Code
            --------------------------------------------
            --------------------------------------------*/

            var $form = $(".require-validation");

            $('form.require-validation').bind('submit', function(e) {
                var $form = $(".require-validation"),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');

                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }

            });

            /*------------------------------------------
            --------------------------------------------
            Stripe Response Handler
            --------------------------------------------
            --------------------------------------------*/
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('hide')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    /* token contains id, last4, and card type */
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
@endpush
