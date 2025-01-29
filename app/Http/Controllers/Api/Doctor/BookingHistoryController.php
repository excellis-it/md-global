<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Transformers\AppointmentTransformer;
use App\Transformers\ClinicTransformer;
use Illuminate\Http\Request;

/**
 * @groupMedical Staff Booking History
 */
class BookingHistoryController extends Controller
{
    /**
     * Get Booking History
     * @Authenticated
     * @bodyParam date string optional Date of appointment. Example: 2021-09-11
     * @bodyParam clinic_id array optional Service Centers id. Example: [1,2]
     * @bodyParam status array optional appointment_status. Example: ["Pending","Done", "Cancelled"]
     * @response 200{
     * "status": true,
     *    "data": {
     *        "appointments": {
     *                {
     *                    "id": 11,
     *                    "patient_name": "John Doe",
     *                    "patient_profile_picture": "patient/07y44Yk7Fgs2DF7v5ErJtbwceKDFIlLpP3mrYkn6.jpg",
     *                    "appointment_date": "2023-09-11",
     *                    "appointment_time": "01:00 PM",
     *                    "clinic_name": "ORM Medicle",
     *                    "clinic_address": "Rajarhat Main Road, Chinar Park, Kalipark, Tegharia, Newtown, Kolkata, West Bengal, India",
     *                    "duration": "30 min",
     *                    "appointment_status": "Done"
     *                }
     *        },
     *        "clinics": {
     *                {
     *                    "id": 4,
     *                    "clinic_name": "The Healing Clinic"
     *                },
     *                {
     *                    "id": 8,
     *                    "clinic_name": "ORM Medicle"
     *                }
     *        }
     *    }
     *}
     *
     */
    public function listWithFilter(Request $request)
    {
        try {
            // return $request->all();
            $query = Appointment::where('doctor_id', $request->user()->id)->orderBy('appointment_date', 'desc');

            if ($request->date) {
                $query->where('appointment_date',  date('Y-m-d', strtotime($request->date)));
            }
            if ($request->clinic_id) {
                $query->whereIn('clinic_id', $request->clinic_id);
            }

            if ($request->appointment_status) {
                $query->whereIn('appointment_status', $request->appointment_status);
            }

            $appointments = $query->get();

            $clinics = $request->user()->clinicDetails()->orderBy('clinic_name', 'desc')->get();
            $data['appointments'] = fractal($appointments, new AppointmentTransformer())->toArray()['data'];
            $data['clinics'] = fractal($clinics, new ClinicTransformer())->toArray()['data'];

            return response()->json(['status' => true, 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
