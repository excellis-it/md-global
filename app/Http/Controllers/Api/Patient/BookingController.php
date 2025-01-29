<?php

namespace App\Http\Controllers\Api\Patient;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\ClinicDetails;
use App\Models\Slot;
use App\Models\Appointment;
use App\Mail\ThankYouMail;
use App\Transformers\DateSlotTransformer;
use App\Transformers\TimeSlotTransformer;
use App\Transformers\UserTransformer;
use Carbon\Carbon;

/**
 * @group Patient Booking
 * */

class BookingController extends Controller
{

    /**
     *Medical Staff details Api
     * @bodyParam doctor_id string required The id of the doctor.
     * @response 200{
     *  "status": true,
     *   "statusCode": 200,
     *   "data": {
     *       "doctor": {
     *           "id": 4,
     *           "name": "James Bond",
     *           "email": "james@yopmail.com",
     *           "phone": "7485968695",
     *           "gender": "Male",
     *           "age": "2000-02-10",
     *           "license_number": "DKM-74859686",
     *           "profile_picture": "doctor/V0pUwsFgvg2bMGnRLx3ctmEhxaRLIIXE7SS3g5BJ.jpg",
     *           "specializations": [
     *               {
     *                   "id": 2,
     *                   "name": "Dentist",
     *               }
     *           ]
     *       },
     *       "clinic": [
     *           {
     *               "id": 5,
     *               "user_id": 4,
     *               "clinic_name": "Christan Medical Collage (CMC)",
     *               "clinic_address": "Rajarhat, Rajarhat Main Road, Chinar Park, Kalipark, Tegharia, Gopalpur I, Kolkata, West Bengal, India",
     *               "clinic_phone": "7412589635",
     *               "longitute": "88.4528608",
     *               "latitute": "22.6343954",
     *               "distance": 6.830848254188763
     *           },
     *
     *       ]
     *   }
     * }
     *
     *
     */

    public function doctorDetails(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'doctor_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'statusCode' => 201, 'status' => false], 201);
        }

        try {
            $doctor_id = $request->doctor_id;
            /**
             * An empty array to hold data for the booking controller.
             *
             * @var array
             */
            $data = [];
            $doctor = User::where('id', $doctor_id)->first();
            $data['doctor'] = fractal($doctor, new UserTransformer())->toArray()['data'];
            // get clinic details for the doctor
            $latitude = Auth::user()->locations->latitude;
            $longitude = Auth::user()->locations->longitude;
            $radius = 10;
            $data['clinic'] = ClinicDetails::where('user_id', $doctor_id)->select('id', 'user_id', 'clinic_name', 'clinic_address', 'clinic_phone', 'longitute', 'latitute', DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance'))->having('distance', '<', $radius)->get();



            return response()->json(['status' => true, 'statusCode' => 200, 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()]);
        }
    }


    /**
     * Service Centers Date and Time Slot
     *
     * @response 200{
     *   "message": "Service Centers Details",
     * "status": true,
     * "data": [
     *     {
     *         "id": 46,
     *         "slot_date": "2023-09-11",
     *         "slot_available": 2
     *     },
     *     {
     *         "id": 48,
     *         "slot_date": "2023-09-14",
     *         "slot_available": 5
     *     }
     *     ]
     *  }
     *
     * @response 201{
     *  "error": "The clinic id field is required."
     * }
     *
     */
    public function visitDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clinic_id' => 'required|exists:clinic_details,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'statusCode' => 201, 'status' => false], 201);
        }

        try {
            $slot_details = Slot::where('clinic_detail_id', $request->clinic_id)->where('slot_date', '>=', date('Y-m-d'))->get();
            $slots = fractal($slot_details, new DateSlotTransformer())->toArray()['data'];
            return response()->json(['message' => 'Service Centers Details', 'status' => true, 'data' => $slots]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Something went wrong!', 'status' => false, 'data' => $th->getMessage()], 500);
        }
    }

    /**
     * Service Centers Visit available Slot Time
     *  @bodyParam slot_id string required The id of the slot.
     * @response 200{
     *   {
     *    "message": "Service Centers Details",
     *    "status": true,
     *    "data": [
     *        {
     *            "id": 46,
     *            "slot_date": "2023-09-11",
     *            "slot_available": 2
     *        },
     *        {
     *            "id": 48,
     *            "slot_date": "2023-09-14",
     *            "slot_available": 5
     *        },
     *    ]
     *}
     * }
     */
    public function clinicVisitSlot(Request $request)
    {
        try {
            $slot_times = Helper::slotSliceWithDate($request->slot_id);
            $slots = fractal($slot_times, new TimeSlotTransformer())->toArray()['data'];
            return response()->json(['message' => 'Service Centers Details!', 'status' => true, 'data' => $slots]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Something went wrong!', 'status' => false, 'data' => $th->getMessage()], 500);
        }
    }

    /**
     * Store Appointment
     *
     * @response 200{
     *    "message": "Appointment booked successfully!",
     *   "status": true,
     *     "data": {
     *          "user_id": 1,
     *          "doctor_id": 4,
     *          "clinic_id": 7,
     *          "appointment_id": "000000",
     *          "appointment_date": "2021-08-02",
     *          "appointment_time": "11:00 AM",
     *           "appointment_status": "Done",
     *           "booking_time": "2021-08-02 12:00:00",
     *           "clinic_name": "Life Medical",
     *            "clinic_address": "Park Street, Mullick Bazar, Beniapukur, Kolkata, West Bengal, India",
     *          "clinic_phone": "7894561230",
     *          "updated_at": "2021-08-02T12:00:00.000000Z",
     *          "created_at": "2021-08-02T12:00:00.000000Z",
     *          "id": 1,
     *          "user": {
     *              "id": 1,
     *              "name": "Shilpi Chaki",
     *              "email": "shilpi@mailinator.com",
     *              "email_verified_at": null,
     *              "profile_picture": "user/5HiPk9oN9cQCNNKdzmBgvNLHSL8u7bbHncdrPE91.png",
     *              "phone": "7894561230",
     *              "year_of_experience": "4",
     *              "license_number": "UPS74856963",
     *              "location": "Kolkata",
     *              "gender": "female",
     *              "age": "2001-01-30",
     *              "status": 1,
     *              "fcm_token": "fTcKacaIV3mJaU4VbJ_4Ib:APA91bHgCcot6OOpAlysNgDKq54K9PnU6PjDM3tHdiWFm5KpPXDnVVfcfTJV2C4Q6wKk056fIp6zgOLbEU1DhAvN5SQqZGg0ew7qjKN_FAXyd9ORER4vMhjf1qLc9pY32gI7ZGIJLAaI",
     *              "created_at": "2021-07-25T08:53:27.000000Z",
     *              "updated_at": "2021-07-25T08:53:27.000000Z",
     *              "deleted_at": null
     *          }
     *     }
     * }
     */
    public function storeAppointment(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'clinic_id' => 'required',
            'appointment_date' => 'required',
            'appointment_time' => 'required',
            // Add other validation rules for your fields
        ], [
            'clinic_id.required' => 'Please Select Service Centers for booking slot.',
            'appointment_date.required' => 'Please Select Appointment Date for booking slot.',
            'appointment_time.required' => 'Please Select Appointment Time for booking slot.',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first(), 'status' => false, 'statusCode' => 201], 201);
        }

        try {
            $count = Appointment::where(['user_id' => Auth::user()->id, 'appointment_time' => $request->appointment_time, 'appointment_date' => $request->appointment_date, 'appointment_status' => 'Done'])->count();
            if ($count > 0) {
                return response()->json(['message' => 'You have already booked an appointment on this date and time!!', 'status' => false, 'statusCode' => 201], 201);
            }

            $clinic_details = ClinicDetails::where('id', $request->clinic_id)->first();

            $appointment = new Appointment();
            $appointment->user_id  = Auth::User()->id;
            $appointment->doctor_id  = $request->doctor_id;
            $appointment->clinic_id  = $request->clinic_id;
            $appointment->appointment_id = rand(000000, 999999);
            $appointment->appointment_date  = $request->appointment_date;
            $appointment->appointment_time  = $request->appointment_time;
            $appointment->appointment_status = 'Done';
            $appointment->booking_time  = Carbon::now();
            $appointment->clinic_name  = $clinic_details->clinic_name;
            $appointment->clinic_address = $clinic_details->clinic_address;
            $appointment->clinic_phone = $clinic_details->clinic_phone;
            $appointment->save();
            Session::put('remember', 1);
            $body = [
                'appointment' => $appointment
            ];
            $email = Auth::user()->email;
            Mail::to($email)->send(new ThankYouMail($body));

            return response()->json(['message' => 'Appointment booked successfully!', 'status' => true, 'data' => $appointment], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Something went wrong!', 'status' => false, 'data' => $th->getMessage()]);
        }
    }
}
