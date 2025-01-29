@extends('admin.layouts.master')
@section('title')
    All Appointment List - {{env('APP_NAME')}} admin
@endsection
@push('styles')
{{-- <link href=    "{{ asset('frontend_assets/css/style.css') }}" rel="stylesheet" /> --}}
<style>
    .dataTables_filter{
        margin-bottom: 10px !important;
    }
</style>
@endpush

@section('content')
    @php
        use App\Models\User;
    @endphp
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Appointment Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('contact-us.index') }}">Appointments</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-0">AppointmentDetails</h4>
                            </div>
                            <div class="col-md-6" >
                                <div class="funel_box me-2" style="float: right">
                                    <div class="btn-group">
                                        <button type="button" id="btn" class="btn btn-light dropdown-toggle"> <i
                                                class="fas fa-filter"></i> </button>
                                        <div class=" " id="box">
                                            <h6><i class="fas fa-filter"></i> Filter</h6>
                                            <div id="deletebtn" onclick="dltFun();"><i class="fas fa-times"></i>
                                            </div>
                                            <h5 class="">Satus</h5>
                                            <div class="form-group">
                                                <input type="checkbox" id="superstockiest" class="status-result"
                                                    value="Done">
                                                <label for="superstockiest">Done</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" id="stockiest" class="status-result" value="Pending">
                                                <label for="stockiest">Pending</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" id="substockiest" class="status-result"
                                                    value="Cancel">
                                                <label for="substockiest">Cancel</label>
                                            </div>
                                            <h5 class="">Clinic</h5>
                                            @foreach ($clinics as $clinic)
                                                <div class="form-group">
                                                    <input type="checkbox" id="Active-{{ $clinic->id }}"
                                                        data-id="{{ $clinic->id }}" class="clinic_name">
                                                    <label
                                                        for="Active-{{ $clinic->id }}">{{ $clinic->clinic_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="btn-group date-btn">
                                        <!-- <button type="button"  id="datepicker" class="btn btn-light dropdown-toggle"> <i class="fa-solid fa-calendar-days"></i> </button> -->
                                        <input placeholder="" class="textbox-n" type="date" id="date" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <hr />
                   
                    <div id="pagination-list">
                        @include('admin.appointment.pagination-list')
                    </div>
                </div>
            </div>

        </div>

    </div>
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
                     $('#pagination-list').html(data);
                 }).fail(function () {
                     alert('Notifications could not be loaded.');
                 });
             }
         });
       
     </script>
     <script>
        var x = document.getElementById("btn");
        x.addEventListener("click", myFunction, false);

        function myFunction() {
            var y = document.getElementById("box");
            if (y.className === "active") {
                y.className = "";
            } else {
                y.className = "active";
            }

        };

        function dltFun() {
            var z = document.getElementById("box");

            if (z.className === "active") {
                z.className = "";
            } else {
                z.className = "active";
            }

        }
    </script>

    <script>
        $(document).ready(function() {
            $('#date').change(function() {
                var clinic_id = [];
                var status = [];
                var date = $(this).val();
                $('.clinic_name:checked').each(function() {
                    clinic_id.push($(this).data('id'));
                });
                $('.status-result:checked').each(function() {
                    status.push($(this).val());
                });
                var url = "{{ route('appointments.booking-history-ajax') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        date: date,
                        clinic_id: clinic_id,
                        status: status
                    },
                    success: function(response) {
                        $('#pagination-list').html(response.view);
                    }
                });
            });

            $('.clinic_name').change(function() {
                var clinic_id = [];
                var status = [];
                
                $('.clinic_name:checked').each(function() {
                    clinic_id.push($(this).data('id'));
                });
                $('.status-result:checked').each(function() {
                    status.push($(this).val());
                });
                var date = $('#date').val();
                var url = "{{ route('appointments.booking-history-ajax') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        clinic_id: clinic_id,
                        date: date,
                        status: status
                    },
                    success: function(response) {
                        $('#pagination-list').html(response.view);
                    }
                });
            });

            $('.status-result').change(function() {
                var status = [];
                var clinic_id = [];
                $('.clinic_name:checked').each(function() {
                    clinic_id.push($(this).data('id'));
                });
                $('.status-result:checked').each(function() {
                    status.push($(this).val());
                });
                var date = $('#date').val();
                var url = "{{ route('appointments.booking-history-ajax') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        status: status,
                        date: date,
                        clinic_id: clinic_id
                    },
                    success: function(response) {
                        $('#pagination-list').html(response.view);
                    }
                });
            });
        });
    </script>
   
@endpush
