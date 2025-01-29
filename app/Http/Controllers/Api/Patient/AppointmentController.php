<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Mail\CancelAppointmentMail;
use App\Models\Appointment;
use App\Transformers\AppointmentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * @group  Patient Appointment
 */
class AppointmentController extends Controller
{
    private $successStatus = 200;

    /**
     * Upcoming appointment
     * @authenticated
     * @response 200{
     * "status": true,
     * "data": {
     *         {
     *             "id": 11,
     *             "patient_name": "John Does",
     *             "patient_profile_picture": "patient/NJr51HG9dfGvIIfpJVSuHgI7Ps4NkQJdOPLWqSLy.jpg",
     *             "doctor_name": "James Bond",
     *             "doctor_profile_picture": "doctor/V0pUwsFgvg2bMGnRLx3ctmEhxaRLIIXE7SS3g5BJ.jpg",
     *             "appointment_date": "2023-09-11",
     *             "appointment_time": "01:00 PM",
     *             "clinic_name": "ORM Medicle",
     *             "clinic_address": "Rajarhat Main Road, Chinar Park, Kalipark, Tegharia, Newtown, Kolkata, West Bengal, India",
     *             "duration": "30 min",
     *             "appointment_status": "Done"
     *         }
     * }
     * }
     */

    public function upcomingAppointment(Request $request)
    {
        try {
            $date =  date('d-m-Y');
            $time = date('h:i A');
            $combinedDT = date('Y-m-d H:i A', strtotime("$date $time"));
            $upcominAppontments = Appointment::where('user_id', Auth::user()->id)->where(DB::raw("concat(appointment_date, ' ', appointment_time)"), '>', $combinedDT)->where('appointment_status', 'Done')->orderBy('id', 'DESC')->get();
            if ($upcominAppontments->count() > 0) {
                $data = fractal($upcominAppontments, new AppointmentTransformer())->toArray()['data'];
                return response()->json(['status' => true, 'data' => $data], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'No upcoming appointment'], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Appointment History
     * @authenticated
     * @response 200{
     *"status": true,
     *"appointment": {
     *        {
     *            "id": 10,
     *            "patient_name": "John Does",
     *            "patient_profile_picture": "patient/NJr51HG9dfGvIIfpJVSuHgI7Ps4NkQJdOPLWqSLy.jpg",
     *            "doctor_name": "Derick Veliz",
     *            "doctor_profile_picture": "doctor/hkt0RnyhO4wSDMEpVrdNGdXYayxmjTaepELsZnu8.png",
     *            "appointment_date": "2023-07-25",
     *            "appointment_time": "01:30 PM",
     *            "clinic_name": "Christan Medical Collage(CMS)",
     *            "clinic_address": "Saltlake Sector V, Street Number 18, DP Block, Sector V, Bidhannagar, Kolkata, West Bengal, India",
     *            "duration": "30 min",
     *            "appointment_status": "Done"
     *        },
     *}
     *}
     */

    public function appointmentHistory(Request $request)
    {
        try {
            $pastAppontments = Appointment::where('user_id', Auth::user()->id)->where('appointment_date', '<', date('Y-m-d'))->orderBy('id', 'DESC')->get();
            if ($pastAppontments->count() > 0) {
                $appointment = fractal($pastAppontments, new AppointmentTransformer())->toArray()['data'];
                return response()->json(['status' => true, 'appointment' => $appointment], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'No appointment history'], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Cancel Appointment
     * @authenticated
     * @bodyParam appointment_id integer required
     * @response 200{
     * "status": true,
     * "message": "Appointment cancel successfully"
     * }
     * @response 201{
     * "status": false,
     * "message": "The selected appointment id is invalid."
     * }
     */
    public function cancelAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|exists:appointments,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 201);
        }

        try {
            $appointment = Appointment::find($request->appointment_id);
            $appointment->appointment_status = 'Cancel';
            $appointment->save();
            $email = $appointment['doctor']['email'];
            $body = [
                'appointment' => $appointment
            ];
            Mail::to($email)->send(new CancelAppointmentMail($body));
            return response()->json(['status' => true, 'message' => 'Appointment cancel successfully'], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
