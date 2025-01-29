<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Mail\CancelAppointmentMail;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function myAppointment()
    {
        // return date('h:i A');
        $date =  date('d-m-Y');
        $time = date('h:i A');
        $combinedDT = date('Y-m-d H:i A', strtotime("$date $time"));
        $upcominAppontments = Appointment::where('user_id', Auth::user()->id)->where(DB::raw("concat(appointment_date, ' ', appointment_time)"), '>' , $combinedDT)->where('appointment_status', 'Done')->orderBy('id', 'DESC')->get();
        // dd($upcominAppontments);
        $pastAppontments = Appointment::where('user_id', Auth::user()->id)->where('appointment_date', '<', date('Y-m-d'))->orderBy('id', 'DESC')->get();
        $appointments = Appointment::where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('frontend.patient.my-appointment')->with(compact('appointments','upcominAppontments','pastAppontments'));
    }

    public function myAppointmentCancel($id)
    {
        Appointment::where('id', $id)->update(['appointment_status'=>'Cancel']);
        $appointment = Appointment::where('id', $id)->first();
        $body = [
            'appointment' => $appointment
        ];
        $email = $appointment['doctor']['email'];
        Mail::to($email)->send(new CancelAppointmentMail($body));
        return redirect()->back()->with('messsage', 'Appoinment has been canceled by you.');
    }
}
