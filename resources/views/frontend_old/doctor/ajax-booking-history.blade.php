<div class="booking-history-table">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th><span><i class="fa-regular fa-clock"></i></span>Appointment
                        time</th>
                    <th><span><i class="fa-regular fa-clock"></i></span>Duration
                    </th>
                    <th><span><i class="fa-solid fa-calendar-days"></i></span>Appointment
                        Date</th>
                    <th><span><i class="fa-solid fa-house-chimney-medical"></i></span>Clinic
                        Details</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
                @if (count($bookingHistory) > 0)
                    @foreach ($bookingHistory as $booking)
                        <tr>
                            <td>
                                <div class="profile-div profile-div-2 profile-div-3 d-flex align-items-center">
                                    <div class="profile-img">
                                        @if ($booking->user->profile_picture)
                                            <img src="{{ Storage::url($booking->user->profile_picture) }}"
                                                alt="">
                                        @else
                                            <img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="profile-text">
                                        <h2>{{ $booking->user->name }}</h2>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $booking['appointment_time'] }}</td>
                            <td>30min</td>
                            <td>{{ date('D, d M Y', strtotime($booking['appointment_date'])) }}</td>
                            <td>{{ $booking['clinic_name'] }}
                                {{ $booking['clinic_address'] }}</td>
                            <td
                                class="@if ($booking['appointment_status'] == 'Done') status-1 @elseif($booking['appointment_status'] == 'Pending') status-2 @else status-3 @endif">
                                {{ $booking['appointment_status'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">No Booking History Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="pagi_1 justify-content-center">
            <nav aria-label="Page navigation example">
                @if (method_exists($bookingHistory, 'links'))
                    @if (count($bookingHistory) > 0)
                        <div class="">
                            {{ $bookingHistory->links() }}

                        </div>
                    @endif
                @endif
            </nav>
        </div>
    </div>
</div>
