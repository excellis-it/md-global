@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Edit Service Center Address
@endsection
@push('styles')
@endpush

@section('content')
    @php
        use Illuminate\Support\Str;
    @endphp
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
                                    <h2>Manage Service Center Address</h2>
                                    <h3><a href="{{ route('doctor.dashboard') }}">Dashboard</a> / Manage Service Center Address</h3>
                                </div>
                                <div class="add-address">
                                    <a href="{{ route('doctor.manage-clinic.index') }}"><span>BACK</span></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="clinical-consultation-wrap">
                                        <div class="add-address-wrap">
                                            <div class="add-address-form-box">
                                                <form action="{{ route('doctor.manage-clinic.update') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $clinic->id }}">
                                                    <div class="form-group" id="latitudeArea">
                                                        <label>Latitude</label>
                                                        <input type="text" id="latitude" name="latitude"
                                                            value="{{ $clinic->latitute }}" class="form-control">
                                                    </div>
                                                    <div class="form-group" id="longtitudeArea">
                                                        <label>Longitude</label>
                                                        <input type="text" name="longitude" id="longitude"
                                                            value="{{ $clinic->longitute }}" class="form-control">
                                                    </div>
                                                    <div class="row g-3">
                                                        <div class="form-group col-lg-6 col-md-12">
                                                            <input type="text" class="form-control" id="clinic_name"
                                                                value="{{ $clinic->clinic_name }}" name="clinic_name"
                                                                placeholder="Service Center Name" required="">
                                                            @if ($errors->has('clinic_name'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('clinic_name') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group col-lg-6 col-md-12">
                                                            <input type="text" class="form-control" id="clinic_phone"
                                                                name="clinic_phone" value="{{ $clinic->clinic_phone }}"
                                                                placeholder="Phone Number" required="">
                                                            @if ($errors->has('clinic_phone'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('clinic_phone') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="form-group col-lg-12 col-md-12">
                                                            <input type="text" class="form-control" id="autocomplete"
                                                                name="clinic_address" value="{{ $clinic->clinic_address }}"
                                                                placeholder="Service Center Address" required="">
                                                            @if ($errors->has('clinic_address'))
                                                                <span
                                                                    class="text-danger">{{ $errors->first('clinic_address') }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="time-pick">
                                                            <div class="row align-items-center">
                                                                <div class="col-xl-2">
                                                                    <div class="form-check form-check-1">
                                                                        <label class="form-check-label"
                                                                            for="flexCheckDefault">
                                                                            Choose Your Service Center Open Days
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    @foreach ($days as $day)
                                                                        <div class="time-pick">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input"
                                                                                    type="checkbox" name="day_id[]"
                                                                                    value="{{ $day->id }}"
                                                                                    @if (in_array($day->id, $clinic->clinicOpeningDays->pluck('day_id')->toArray())) checked @endif
                                                                                    id="day{{ $day->id }}">
                                                                                <label class="form-check-label"
                                                                                    for="day{{ $day->id }}">
                                                                                    {{ substr(Str::upper($day->day), 0, 3) }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <!-- <div class="time-pick">
                                                                                        <input type="radio" id="tm1" name="animal" value="">
                                                                                        <label for="tm1">9.00 am</label>
                                                                                     </div> -->
                                                            <div class="slct-date-time">
                                                                <h4>SELECT DATE AND TIME</h4>
                                                            </div>
                                                            <div id="append-add-more">
                                                                <div class="sl-slot-div">
                                                                    <div class="row">
                                                                        <div class="form-group col-lg-5 col-md-12">
                                                                            <input class="form-control" id="slot_date"
                                                                                name="slot_date[]" value=""
                                                                                placeholder="Select Date"
                                                                                class="textbox-n" type="text"
                                                                                onfocus="(this.type='date')"  min="{{ date('Y-m-d') }}"
                                                                                id="date" />
                                                                        </div>
                                                                        <div class="form-group col-lg-6 col-md-12">
                                                                            <div class="row">
                                                                                <div class="col-xl-5 col-lg-5 col-12">
                                                                                    <div class="input-group">
                                                                                        <label for="">Time
                                                                                            Slot</label>
                                                                                        <select class="form-select"
                                                                                            aria-label="Default select example"
                                                                                            name="slot_start_time[]">
                                                                                            <option value="1"
                                                                                                selected>1
                                                                                            </option>
                                                                                            <option value="1">2
                                                                                            </option>
                                                                                            <option value="2">3
                                                                                            </option>
                                                                                            <option value="3">4
                                                                                            </option>
                                                                                            <option value="5">5
                                                                                            </option>
                                                                                            <option value="6">6
                                                                                            </option>
                                                                                            <option value="7">7
                                                                                            </option>
                                                                                            <option value="8">8
                                                                                            </option>
                                                                                            <option value="9">9
                                                                                            </option>
                                                                                            <option value="10">10
                                                                                            </option>
                                                                                            <option value="11">11
                                                                                            </option>
                                                                                            <option value="12">12
                                                                                            </option>
                                                                                        </select>
                                                                                        <select class="form-select"
                                                                                            aria-label="Default select example"
                                                                                            name="first_time_mode[]">
                                                                                            <option value="AM"
                                                                                                selected>AM</option>
                                                                                            <option value="PM">PM
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-5 col-lg-5 col-12">
                                                                                    <div class="input-group">
                                                                                        <label for="">to</label>
                                                                                        <select class="form-select"
                                                                                            aria-label="Default select example"
                                                                                            name="slot_end_time[]">
                                                                                            <option value="1"
                                                                                                selected>1
                                                                                            </option>
                                                                                            <option value="1">2
                                                                                            </option>
                                                                                            <option value="2">3
                                                                                            </option>
                                                                                            <option value="3">4
                                                                                            </option>
                                                                                            <option value="5">5
                                                                                            </option>
                                                                                            <option value="6">6
                                                                                            </option>
                                                                                            <option value="7">7
                                                                                            </option>
                                                                                            <option value="8">8
                                                                                            </option>
                                                                                            <option value="9">9
                                                                                            </option>
                                                                                            <option value="10">10
                                                                                            </option>
                                                                                            <option value="11">11
                                                                                            </option>
                                                                                            <option value="12">12
                                                                                            </option>
                                                                                        </select>
                                                                                        <select class="form-select"
                                                                                            aria-label="Default select example"
                                                                                            name="second_time_mode[]">
                                                                                            <option value="AM"
                                                                                                selected>AM</option>
                                                                                            <option value="PM">PM
                                                                                            </option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- append --}}
                                                        </div>
                                                        <div class="add-more-div">
                                                            <div class="row">
                                                                <div class="col-xl-4 col-lg-4 col-12 text-left">
                                                                    <div class="add-more-btn">
                                                                        <a href="javascript:void(0)"
                                                                            class="add-more"><span> <i
                                                                                    class="fas fa-plus"></i> ADD
                                                                                MORE</span></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-4 col-lg-4 col-12">
                                                                <div class="main-btn-p pt-4">
                                                                    <input type="submit" value="UPDATE" class="sub-btn">
                                                                </div>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(count($slots) > 0)
                            <div class="my-app-div-wrap">
                                <div class="content-head-wrap d-flex justify-content-between align-items-center">
                                    <div class="content-head mb-4">
                                        <h2>Present Scheduled Date</h2>
                                    </div>
                                </div>
                                <div class="my-app-div dr-panel-div mb-3 srl srl-3" id="srl_1">
                                    <div class="booking-history-table past-history">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Day</th>
                                                        <th>Time</th>
                                                        <th>to</th>
                                                        <th>Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($slots as $slot)
                                                    <tr>
                                                        <td>{{ date('d M,Y', strtotime($slot['slot_date'])) }}</td>
                                                        <td>{{ date('D', strtotime($slot['slot_date'])) }}</td>
                                                        <td>{{ $slot['slot_start_time'] }}</td>
                                                        <td>to</td>
                                                        <td>{{ $slot['slot_end_time'] }}</td>
                                                        <td>
                                                            <div class="delet-btn">
                                                                <a href="javascript:void(0);" data-route="{{ route('doctor.manage-clinic.slot-delete', $slot['id']) }}" id="delete"><span><i
                                                                            class="fa-solid fa-trash-can"></i></span></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_CLIENT_ID')}}&libraries=places"></script>
    <script>
        $(document).ready(function() {
            $("#latitudeArea").addClass("d-none");
            $("#longtitudeArea").addClass("d-none");
        });
    </script>
    <script>
        google.maps.event.addDomListener(window, 'load', initialize);

        function initialize() {
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());
                // $("#latitudeArea").removeClass("d-none");
                // $("#longtitudeArea").removeClass("d-none");
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.add-more').on('click', function() {
                $('#append-add-more').append(
                    '<div class="sl-slot-div"><div class="row"><div class="form-group col-lg-5 col-md-12"><input class="form-control" id="slot_date" name="slot_date[] "value="" min="{{ date('Y-m-d') }}" placeholder="Select Date" required="" class="textbox-n" type="date" id="date" /></div><div class="form-group col-lg-6 col-md-12"><div class="row"><div class="col-xl-5 col-lg-5 col-12"><div class="input-group"><label for="">Time Slot</label><select class="form-select"aria-label="Default select example" name="slot_start_time[]"><option value="1" selected>1</option><option value="1">2</option><option value="2">3</option><option value="3">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select><select class="form-select" name="first_time_mode[]" aria-label="Default select example"><option value="AM" selected>AM</option><option value="PM">PM</option></select></div></div><div class="col-xl-5 col-lg-5 col-12"><div class="input-group"><label for="">to</label><select class="form-select"aria-label="Default select example" name="slot_end_time[]"><option value="1" selected>1</option><option value="1">2</option><option value="2">3</option><option value="3">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select><select class="form-select" name="second_time_mode[]" aria-label="Default select example"><option value="AM" selected>AM</option><option value="PM">PM</option></select></div></div><div class="col-xl-2 col-lg-2 col-12"><div class="delet-btn"><a href="javascript:void(0);" class="remove-slot"><span><i class="fa-solid fa-trash"></i></span></a></div></div></div></div></div></div>'
                );

            });

            $(document).on('click', '.remove-slot', function() {
                $(this).closest('.sl-slot-div').remove();
            });
        });
    </script>
    <script>
         $(document).on('click', '#delete', function(e) {
        swal({
                title: "Are you sure?",
                text: "To delete the slot.",
                type: "warning",
                confirmButtonText: "Yes",
                showCancelButton: true
            })
            .then((result) => {
                if (result.value) {
                    window.location = $(this).data('route');
                } else if (result.dismiss === 'cancel') {
                    swal(
                        'Cancelled',
                        'Your stay here :)',
                        'error'
                    )
                }
            })
    });
    </script>
@endpush
