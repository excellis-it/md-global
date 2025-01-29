@if (isset($accept))
    <div class="modal on-modal on-modal-2 fade" id="Modal3" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content membership-title">
                <div class="mdl-cam">
                    <i class="fa-sharp fa-solid fa-video"></i>
                </div>
                <div class="modal-header ">
                    <h5 class="modal-title " id="exampleModalLabel">For Video Consultation Fee <span class="membership-name"></span>
                        <span>Plan $</span><span class="membership-price">{{$videoCallPrice['price']}}</span>
                    </h5>
                    <div class="stripe">
                        <img src="{{ asset('frontend_assets/images/stripe.png') }}" alt="">
                    </div>
                    <div class="stripe-p">
                        <h5>Payment via stripe</h5>
                    </div>
                </div>
                <form action="{{ route('patient.video-consultancy.payment') }}" method="POST" role="form"
                    class="require-validation" data-cc-on-file="false"
                    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">

                    @csrf
                    <div class="modal-body">
                        <div class="payment-form">

                            <input type="hidden" name="videocall_id" id="videocall_id" class="videocall_id" value="{{$videocall_id}}">
                            <div class="form-group pb-3">
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="name"
                                    @if (Auth::check()) value="{{ Auth::user()->name }}" @endif
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
                                                            <input type="text"
                                                                class="form-control me-2 card-expiry-year"
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
@endif

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
