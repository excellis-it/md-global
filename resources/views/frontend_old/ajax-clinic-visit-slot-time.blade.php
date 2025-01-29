@php
    use App\Models\User;
    use App\Helpers\Helper;
@endphp
@if (isset($slot_times))
    <div class="cl-slot-wrap same-size">
        <div class="cl-slot-icon d-flex align-items-center">
            <i class="fa-solid fa-calendar-days"></i>
            <h3>{{ date('D, d M', strtotime($slot_times['slot_date'])) }}</h3>
        </div>
        <div class="dt-slot">
            <div class="row row-cols-xxl-3 row-cols-lg-3 row-cols-md-2 row-cols-1">
                @foreach (Helper::slotSlice($slot_times['id']) as $key => $time)
                    <div class="col">
                        <div class="time-pick date-pick size-fix">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="appointment_time"
                                    value="{{ $time }}" id="time_{{ $key }}" @if(Helper::countSlotTimeAvailability($slot_times['clinic_detail_id'],$slot_times['slot_date'], $time) > 0) disabled @endif>
                                <label class="form-check-label" for="time_{{ $key }}">
                                    <h3>{{ $time }}</h3>
                                    <p class="@if(Helper::countSlotTimeAvailability($slot_times['clinic_detail_id'],$slot_times['slot_date'], $time) > 0) red-color @endif">@if(Helper::countSlotTimeAvailability($slot_times['clinic_detail_id'],$slot_times['slot_date'], $time) > 0) Not Available @else Available @endif</p>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
