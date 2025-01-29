<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClinicDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AppointmentController extends Controller
{
    protected $appointments;

    public function __construct(Appointment $appointments) {
        $this->appointments = $appointments;
    }

    public function index(Request $request)
    {
        $appointments = $this->appointments->orderBy('appointment_date', 'DESC')->paginate(20);
        $clinics = ClinicDetails::orderBy('clinic_name','desc')->get();

        if ($request->ajax()) {
            // return view('frontend.patient.partials.message')->with(compact('notifications'))->render();
            return view('admin.appointment.pagination-list', ['appointments' => $appointments])->render();  
        }

        return view('admin.appointment.list')->with(compact('appointments','clinics'));
    }

    public function bookingHistoryAjax(Request $request)
    {
        // return $request->all();
       if ($request->ajax()) {
          $query = Appointment::orderBy('appointment_date', 'DESC');
            if ($request->date) {
                 $query->where('appointment_date',  date('d-m-Y', strtotime($request->date)));
            }
            if ($request->clinic_id) {
                 $query->whereIn('clinic_id', $request->clinic_id);
            }

            if ($request->status) {
                 $query->whereIn('appointment_status', $request->status);
            }
          
             $appointments = $query->paginate(20);
            return response()->json(['view'=>(String)View::make('admin.appointment.pagination-list')->with(compact('appointments'))]);
       }
    }
}
