@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Patient Settings
@endsection
@push('styles')
@endpush

@section('content')
    <section class="sidebar-sec" id="body-pd">
        <div class="container-fluid">
            <div class="sidebar-wrap d-flex justify-content-between">
                @include('frontend.patient.partials.sidebar')

                <!-- Content -->
                <div class="sidebar-right height-100">
                    <div class="content">
                        <div class="my-app-div-wrap d-flex justify-content-between align-item-center">
                            <div class="content-head">
                                <h2>Settings</h2>
                            </div>
                            <a href="{{route('patient.delete-account')}}">
                                <div class="delete-account">
                                    <h2><span><i class="fa-solid fa-trash"></i></span> Delete Account</h2>
                                </div>
                            </a>
                        </div>
                        <div class="settings-div">
                            <div class="msn-tab">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-home" type="button" role="tab"
                                            aria-controls="nav-home" aria-selected="true">About MD Global</button>
                                        <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-profile" type="button" role="tab"
                                            aria-controls="nav-profile" aria-selected="false">Privacy
                                            Policy</button>
                                        <button class="nav-link" id="nav-help-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-help" type="button" role="tab"
                                            aria-controls="nav-help" aria-selected="false">Help & Support</button>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                        aria-labelledby="nav-home-tab">
                                        <p>{!! nl2br($aboutUs['content']) !!}</p>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                        aria-labelledby="nav-profile-tab">
                                        <p> {!! nl2br($privacyPolicy['content']) !!}</p>
                                    </div>

                                    <div class="tab-pane fade" id="nav-help" role="tabpanel"
                                        aria-labelledby="nav-help-tab">
                                        <div class="help-frm">
                                            <form action="javascript:void(0);" name="submit-form" id="submit-form">
                                                <div class="row">
                                                    <div class="form-group col-lg-4 col-md-12">
                                                        <input type="text" class="form-control" id="subject"
                                                            value="" placeholder="Subject" name="subject"
                                                            required="">
                                                        <span class="text-danger" id="subjectErrorMsg"></span>
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12">
                                                        <textarea class="form-control" id="message" placeholder="Message" name="message" rows="6"></textarea>
                                                        <span class="text-danger" id="messageErrorMsg"></span>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <div class="main-btn-p">
                                                            <input type="submit" value="send" class="sub-btn btn-submit">
                                                        </div>
                                                    </div>
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
    </section>
@endsection

@push('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".btn-submit").click(function(e) {
            e.preventDefault();
            var subject = $("input[name=subject]").val();
            var message = $("#message").val();

            $.ajax({
                type: 'POST',
                url: "{{ route('patient.help-and-support') }}",
                data: {
                    subject: subject,
                    message: message
                },
                success: function(data) {
                    $("#subject").val('');
                    $("#message").val('');
                    toastr.success(
                        'Your message has been sent successfully.Please wait for our response.');
                },
                error: function(response) {
                    $('#subjectErrorMsg').text(response.responseJSON.errors.subject);
                    $('#messageErrorMsg').text(response.responseJSON.errors.message);
                },
            });
        });
    </script>
@endpush
