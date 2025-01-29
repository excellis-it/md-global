<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $bookingHistory = Appointment::where(['doctor_id'=> Auth::user()->id, 'appointment_status' => 'Done'])->orderBy('appointment_date', 'DESC')->paginate(10);
        $chat_request_array = Auth::user()->friends()->where('status', 0)->pluck('friend_id')->toArray();
        $chat_requests = User::whereIn('id', $chat_request_array)->select('id', 'profile_picture', 'gender', 'name', 'age')->get();
        $clinics = Auth::user()->clinicDetails()->get();
        // dd($clinics);
        return view('frontend.doctor.dashboard')->with(compact('bookingHistory','chat_requests','clinics'));
    }
}
