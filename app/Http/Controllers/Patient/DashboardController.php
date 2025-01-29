<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClinicDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // return date('h:i A');
        $date =  date('Y-m-d');
        $time = date('h:i A');
        $combinedDT = date('Y-m-d H:i A', strtotime("$date $time"));
        $upcominAppontment = Appointment::where(['user_id' => Auth::user()->id, 'appointment_status' => 'Done'])->where(DB::raw("concat(appointment_date, ' ', appointment_time)"), '>=', $combinedDT)->orderBy('id', 'DESC')->first();
        //  random doctor
        $radius = 10; //in KM
        $lat = Auth::user()->locations->latitude;
        $lng = Auth::user()->locations->longitude;
        $clinics = ClinicDetails::select(
            'user_id',
            DB::raw("id, ( 6371 * acos( cos( radians($lat) ) *
                cos( radians( latitute ) )
                * cos( radians( longitute ) - radians($lng)
                ) + sin( radians($lat) ) *
                sin( radians( latitute ) ) )
            ) AS distance")
        )
            ->having("distance", "<", $radius)
            ->orderBy("distance")
            ->get()
            ->groupBy('user_id');
            // dd($clinics);
        $doctors_array = [];
        foreach ($clinics as $key => $clinic) {

            $doctors_array[] =  $key;
        }
        $doctors = DB::table('users')->whereIn('id', $doctors_array)->inRandomOrder()->limit(5)->get();
        return view('frontend.patient.dashboard')->with(compact('upcominAppontment', 'doctors'));
    }
}
