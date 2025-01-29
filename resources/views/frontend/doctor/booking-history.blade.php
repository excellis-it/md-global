@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
   Medical Staff Profile
@endsection
@push('styles')
@endpush

@section('content')
    <section class="sidebar-sec" id="body-pd">
        <div class="container-fluid">
            <div class="sidebar-wrap d-flex justify-content-between">
                @include('frontend.doctor.partials.sidebar')

                <!-- Content -->
                <div class="sidebar-right height-100">
                    <div class="content">
                        <div class="my-app-div-wrap">
                            <div class="content-head-wrap d-flex justify-content-between align-items-center">
                                <div class="content-head mb-4">
                                    <h2>Booking History</h2>
                                    <h3>Dashboard / Booking History</h3>
                                </div>
                                <?php
                                $status = request()->status;
                                $arr['status'] = explode(',', $status);
                                ?>
                                <div class="funel_box me-2">
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
                                                    @if (in_array('Done', $arr['status'])) checked @endif value="Done">
                                                <label for="superstockiest">Done</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" id="stockiest" class="status-result" value="Pending"
                                                    @if (in_array('Pending', $arr['status'])) checked @endif>
                                                <label for="stockiest">Pending</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" id="substockiest" class="status-result"
                                                    @if (in_array('Cancel', $arr['status'])) checked @endif value="Cancel">
                                                <label for="substockiest">Cancel</label>
                                            </div>
                                            <h5 class="">Clinic</h5>
                                            <?php
                                            $clinic_id = request()->clinic_id;
                                            $arr['clinic_id'] = explode(',', $clinic_id);
                                            ?>
                                            @foreach ($clinics as $clinic)
                                                <div class="form-group">
                                                    <input type="checkbox" id="Active-{{ $clinic->id }}"
                                                        @if (in_array($clinic->id, $arr['clinic_id'])) checked @endif
                                                        data-id="{{ $clinic->id }}" class="clinic_name">
                                                    <label
                                                        for="Active-{{ $clinic->id }}">{{ $clinic->clinic_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="btn-group date-btn">
                                        <!-- <button type="button"  id="datepicker" class="btn btn-light dropdown-toggle"> <i class="fa-solid fa-calendar-days"></i> </button> -->
                                        <input placeholder="" class="textbox-n" type="date" id="date" name="date"
                                            value="{{ request()->date }}">
                                    </div>
                                </div>

                            </div>
                            <div class="my-app-div dr-panel-div mb-3" id="ajax-booking-history">
                                @include('frontend.doctor.ajax-booking-history')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
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
                // add loader
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                var url = "{{ route('doctor.booking-history-ajax') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        date: date,
                        clinic_id: clinic_id,
                        status: status
                    },
                    success: function(response) {
                        $('#ajax-booking-history').html(response.view);
                        // remove loader
                        $('#loading').removeClass('loading');
                        $('#loading-content').removeClass('loading-content');
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
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                var date = $('#date').val();
                var url = "{{ route('doctor.booking-history-ajax') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        clinic_id: clinic_id,
                        date: date,
                        status: status
                    },
                    success: function(response) {
                        $('#ajax-booking-history').html(response.view);

                        $('#loading').removeClass('loading');
                        $('#loading-content').removeClass('loading-content');
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
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                var date = $('#date').val();
                var url = "{{ route('doctor.booking-history-ajax') }}";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        status: status,
                        date: date,
                        clinic_id: clinic_id
                    },
                    success: function(response) {
                        $('#ajax-booking-history').html(response.view);

                        $('#loading').removeClass('loading');
                        $('#loading-content').removeClass('loading-content');
                    }
                });
            });
        });
    </script>
@endpush
