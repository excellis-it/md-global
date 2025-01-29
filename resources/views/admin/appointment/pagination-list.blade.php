<div class="table-responsive">
    <table id="myTable" class="dd table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th> Patient Name</th>
                <th> Patient Email</th>
                <th>Medical Stuff Name</th>
                <th>Medical Stuff Email</th>
                <th>Appointment Time</th>
                <th>Check Up Time</th>
                <th>Appointment Date</th>
                <th>Service Centers Name</th>
                <th>Service Centers Address</th>
                <th>Service Centers Phone</th>
                <th>Appointment Status</th>
                <th>Bookin Date</th>
            </tr>
        </thead>
        <tbody>
            @if(count($appointments) > 0)
            @foreach ($appointments as $appointment)
            <tr>
                <td>
                    {{ $appointment->user->name }}
                </td>
                <td>
                    {{ $appointment->user->email }}
                </td>
                <td>
                    {{ $appointment->doctor->name }}
                </td>
                <td>
                    {{ $appointment->doctor->email }}
                </td>

                <td>{{$appointment['appointment_time']  }}</td>
                <td>30min</td>
                <td>{{ date('D, d M Y',strtotime($appointment['appointment_date'])) }}</td>
                <td>
                    {{ $appointment->clinic_name }}
                </td>
                <td>
                    {{ $appointment->clinic_address }}
                </td>
                <td>
                    {{ $appointment->clinic_phone }}
                </td>
                <td class="@if($appointment['appointment_status'] == 'Done') status-1 @elseif($appointment['appointment_status'] == 'Pending') status-2 @else status-3  @endif">{{ $appointment['appointment_status'] }}</td>
                <td>{{ date('D, d M Y',strtotime($appointment['created_at'])) }}</td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="11" class="text-center">No Appointment Found</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {!! $appointments->render() !!}
    </div>
</div>
