@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Patient Notifications
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
                    <div class="my-app-div-wrap">
                        <div class="content-head">
                            <h2>Notification</h2>
                        </div>
                    </div>
                    <div class="notice-div-wrap" id="item-lists">
                        @include('frontend.patient.partials.message')
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('scripts')
<script type="text/javascript">
   $(function() {
            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();

                // $('#load a').css('color', '#dfecf6');
                // $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

                var url = $(this).attr('href');
                getArticles(url);
                window.history.pushState("", "", url);
            });

            function getArticles(url) {
                $.ajax({
                    url : url
                }).done(function (data) {
                    $('#item-lists').html(data);
                }).fail(function () {
                    alert('Notifications could not be loaded.');
                });
            }
        });
      
    </script>
@endpush
