@php
    use App\Models\User;
    use App\Helpers\Helper;
@endphp
@if (isset($clinic_details))
    <div class="cl-slot-wrap same-size">
        @if ($clinic_details->count() > 0)
            <div class="cl-slot-icon d-flex align-items-center">
                <i class="fa-solid fa-house-chimney-medical"></i>
                <h3>Service Centers Visit Slots</h3>
            </div>
            <div class="dt-slot">
                <div class="row row-cols-xxl-3 row-cols-lg-2 row-cols-1">
                    @foreach ($clinic_details['clinic_slots'] as $slot)
                        <div class="col">
                            <div class="time-pick date-pick">
                                <div class="form-check">
                                    <input class="form-check-input appointment-date" type="radio"
                                        name="appointment_date" value="{{ $slot['slot_date'] }}" data-id="{{ $slot['id'] }}"
                                        id="slot_{{ $slot['id'] }}" @if(Helper::slotAvailable($slot['id']) == 0) disabled @endif>
                                    <label class="form-check-label" for="slot_{{ $slot['id'] }}">
                                        <h3>{{ date('D, d M', strtotime($slot['slot_date'])) }}</h3>
                                        <p class="@if(Helper::slotAvailable($slot['id']) == 0) red-color @endif">@if(Helper::slotAvailable($slot['id']) > 0){{ Helper::slotAvailable($slot['id']) }} slots available @else Not Available @endif</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            No appointment available
        @endif
    </div>
@endif

{{-- <script>
    $('.appointment-date').on('change', function() {
        var slot_id = $(this).data('id');
        $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');
        $.ajax({
            url: "{{ route('clinic.ajax-clinic-visit-slot-time') }}",
            type: 'GET',
            data: {
                slot_id: slot_id
            },
            success: function(resp) {
                // console.log(resp.clinic.slots);

                $('#clinic_visit_slots_time').html(resp.view);
                $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');
            }
        });
    });
</script> --}}
