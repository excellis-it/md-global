<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClinicDetails;
use App\Models\ClinicOpeningDay;
use App\Models\Day;
use App\Models\Slot;
use App\Transformers\DayTransformer;
use App\Transformers\ManageClinicEditTransformer;
use App\Transformers\ManageClinicTransformer;
use App\Transformers\PresentSheduleTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Manage Clinic
 */
class ManageClinicController extends Controller
{
    public $successStatus = 200;

    /**
     * Get Service Centers List
     * @authenticated
     * @response 200{
     * *"status": true,
     *    "statusCode": 200,
     *    "message": "Service Centers list",
     *    "data": {
     *            {
     *                "id": 4,
     *                "clinic_name": "The Healing Clinic",
     *                "clinic_address": "Indian Association For The Cultivation Of Science, Poddar Nagar, Jadavpur, Kolkata, West Bengal, India",
     *                "clinic_phone": "7485968695",
     *                "clinic_opening_days": [
     *                    {
     *                        "id": 38,
     *                        "day": "Monday"
     *                    },
     *                    {
     *                        "id": 39,
     *                        "day": "Tuesday"
     *                    },
     *                    {
     *                        "id": 40,
     *                        "day": "Wednesday"
     *                    },
     *                    {
     *                        "id": 41,
     *                        "day": "Thursday"
     *                    }
     *                ]
     *            }
     *    }
     * }
     *
     * @response 201{
     * "status": false,
     * "statusCode": 201,
     * "message": "No clinic found"
     * }
     */

    public function index(Request $request)
    {
        try {
            $clinics = ClinicDetails::where('user_id', auth()->user()->id)->count();
            if ($clinics > 0) {
                $data = ClinicDetails::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->get();
                $clinics = fractal($data, new ManageClinicTransformer())->toArray()['data'];
                return response()->json([
                    'status' => true,
                    'statusCode' => $this->successStatus,
                    'message' => 'Service Centers list',
                    'data' => $clinics
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 201,
                    'message' => 'No clinic found',
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * Create Clinic
     * @authenticated
     * @response 200{
     * "status": true,
     *"statusCode": 200,
     *"message": "Service Centers list",
     *"data": {
     *        {
     *            "id": 1,
     *            "day": "Sunday"
     *        },
     *        {
     *            "id": 2,
     *            "day": "Monday"
     *        },
     *        {
     *            "id": 3,
     *            "day": "Tuesday"
     *        },
     *        {
     *            "id": 4,
     *            "day": "Wednesday"
     *        },
     *        {
     *            "id": 5,
     *            "day": "Thursday"
     *        },
     *        {
     *            "id": 6,
     *            "day": "Friday"
     *        },
     *        {
     *            "id": 7,
     *            "day": "Saturday"
     *        }
     *}
     * }
     * @response 201{
     * "status": false,
     * "statusCode": 201,
     * "error": "No clinic found"
     * }
     */

    public function create(Request $request)
    {
        try {
            $data = Day::all();
            $days = fractal($data, new DayTransformer())->toArray()['data'];
            return response()->json([
                'status' => true,
                'statusCode' => $this->successStatus,
                'message' => 'Service Centers list',
                'data' => $days
            ], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    /**
     * Store clinic details
     * @authenticated
     * @bodyParam clinic_name string required
     * @bodyParam clinic_address string required
     * @bodyParam clinic_phone numeric required
     * @bodyParam day_id array required
     * @bodyParam latitute string required
     * @bodyParam longitute string required
     * @bodyParam slot_date array required Example: 2021-09-01, 2021-09-02
     * @bodyParam slot_start_time array required Example: 10:00, 11:00
     * @bodyParam slot_end_time array required. Example: 10:00, 11:00
     * @bodyParam first_time_mode array required. Example: AM, PM
     * @bodyParam second_time_mode array required. Example: AM, PM
     *
     * @response 200{
     * "status": true,
     * "statusCode": 200,
     * "message": "Service Centers details added successfully"
     * }
     *
     *  @response 201{
     * "status": false,
     * "statusCode": 201,
     * "error": "No clinic found"
     * }
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clinic_name' => 'required',
            'clinic_address' => 'required',
            'clinic_phone' => 'required|numeric|digits_between:10,12',
            'day_id' => 'array|required',
            'latitute' => 'required',
            'longitute' => 'required',
            'slot_date' => 'array|required',
            'slot_start_time' => 'array|required',
            'slot_end_time' => 'array|required',
            'first_time_mode' => 'array|required',
            'second_time_mode' => 'array|required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(),'status'=>false,'statusCode' => 201], 201);
        }

        try {

            $clinicDetail = new ClinicDetails();
            $clinicDetail->user_id = auth()->user()->id;
            $clinicDetail->clinic_name = $request->clinic_name;
            $clinicDetail->clinic_address = $request->clinic_address;
            $clinicDetail->clinic_phone = $request->clinic_phone;
            $clinicDetail->longitute = $request->longitute;
            $clinicDetail->latitute = $request->latitute;
            $clinicDetail->save();

            foreach ($request->day_id as $day) {
                $clinic_opening_days = new ClinicOpeningDay();
                $clinic_opening_days->clinic_details_id = $clinicDetail->id;
                $clinic_opening_days->day_id = $day;
                $clinic_opening_days->save();
            }

            foreach ($request->slot_date as $key => $slot_date) {
                $slot = new Slot();
                $slot->clinic_detail_id = $clinicDetail->id;
                $slot->slot_date = $slot_date;
                $slot->slot_start_time = $request->slot_start_time[$key] . ':00 ' . $request->first_time_mode[$key];
                $slot->slot_end_time = $request->slot_end_time[$key] . ':00 ' . $request->second_time_mode[$key];
                $slot->save();
            }

            return response()->json([
                'status' => true,
                'statusCode' => $this->successStatus,
                'message' => 'Service Centers details added successfully',
            ], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Edit clinic details
     * @authenticated
     * @bodyParam id numeric required. Example: 1
     * @response 200{
     * "status": true,
     * "statusCode": 200,
     * "message": "Service Centers list",
     * "data": {
     *     "id": 4,
     *    "clinic_name": "The Healing Clinic",
     *   "clinic_address": "Indian Association For The Cultivation Of Science, Poddar Nagar, Jadavpur, Kolkata, West Bengal, India",
     *  "clinic_phone": "7485968695",
     * "clinic_opening_days": [
     *    {
     *       "id": 38,
     *      "day": "Monday"
     * },
     * ]
     * }
     * }
     *
     * @response 201{
     * "status": false,
     * "statusCode": 201,
     * "error": "No clinic found"
     * }
     */

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:clinic_details,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(),'status'=>false,'statusCode' => 201], 201);
        }

        try {
            $clinic = ClinicDetails::find($request->id);
            if ($clinic) {
                $clinics = ClinicDetails::findOrFail($request->id);
                $clinics = fractal($clinics, new ManageClinicEditTransformer())->toArray()['data'];
                return response()->json([
                    'status' => true,
                    'statusCode' => $this->successStatus,
                    'message' => 'Service Centers list',
                    'data' => $clinics
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 201,
                    'message' => 'No clinic found',
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update clinic details
     * @authenticated
     * @bodyParam id numeric required
     * @bodyParam clinic_name string required
     * @bodyParam clinic_address string required
     * @bodyParam clinic_phone numeric required
     * @bodyParam day_id array required
     * @bodyParam latitute string required
     * @bodyParam longitute string required
     * @bodyParam slot_date array optional Example: 2021-09-01, 2021-09-02
     * @bodyParam slot_start_time array optional Example: 10:00, 11:00
     * @bodyParam slot_end_time array optional. Example: 10:00, 11:00
     * @bodyParam first_time_mode array optional. Example: AM, PM
     * @bodyParam second_time_mode array optional. Example: AM, PM
     *  @response 200{
     * "status": true,
     * "statusCode": 200,
     * "message": "Service Centers details updated successfully"
     * }
     *
     * @response 201{
     * "status": false,
     *  "statusCode": 201,
     * "error": "No clinic found"
     * }
     */

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:clinic_details,id',
            'clinic_name' => 'required',
            'clinic_address' => 'required',
            'clinic_phone' => 'required|numeric|digits_between:10,12',
            'day_id' => 'array|required',
            'latitute' => 'required',
            'longitute' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(),'status'=>false,'statusCode' => 201], 201);
        }

        try {

            $clinicDetail = ClinicDetails::find($request->id);
            $clinicDetail->user_id = auth()->user()->id;
            $clinicDetail->clinic_name = $request->clinic_name;
            $clinicDetail->clinic_address = $request->clinic_address;
            $clinicDetail->clinic_phone = $request->clinic_phone;
            $clinicDetail->longitute = $request->longitute;
            $clinicDetail->latitute = $request->latitute;
            $clinicDetail->save();

            ClinicOpeningDay::where('clinic_details_id', $request->id)->delete();
            foreach ($request->day_id as $day) {
                $clinic_opening_days = new ClinicOpeningDay();
                $clinic_opening_days->clinic_details_id = $clinicDetail->id;
                $clinic_opening_days->day_id = $day;
                $clinic_opening_days->save();
            }


            foreach ($request->slot_date as $key => $slot_date) {
                if ($slot_date != null) {
                    $slot = new Slot();
                    $slot->clinic_detail_id = $clinicDetail->id;
                    $slot->slot_date = $slot_date;
                    $slot->slot_start_time = $request->slot_start_time[$key] . ':00 ' . $request->first_time_mode[$key];
                    $slot->slot_end_time = $request->slot_end_time[$key] . ':00 ' . $request->second_time_mode[$key];
                    $slot->save();
                }
            }

            return response()->json([
                'status' => true,
                'statusCode' => $this->successStatus,
                'message' => 'Service Centers details updated successfully',
                'clinicDetail' => $clinicDetail,
            ], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Delete clinic details
     * @authenticated
     * @bodyParam id numeric required
     * @response 200{
     * "status": true,
     * "statusCode": 200,
     * "message": "Service Centers deleted successfully"
     * }
     *  @response 201{
     * "status": false,
     * "statusCode": 201,
     * "error": "No clinic found"
     * }
     */

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:clinic_details,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(),'status'=>false,'statusCode' => 201], 201);
        }

        try {
            $clinic = ClinicDetails::find($request->id);
            if ($clinic) {
                $clinic->delete();
                Appointment::where('clinic_id', $request->id)->update(['appointment_status' => 'Cancel']);
                return response()->json([
                    'status' => true,
                    'statusCode' => $this->successStatus,
                    'message' => 'Service Centers deleted successfully',
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 201,
                    'message' => 'No clinic found',
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     *  Present shedule date
     * @authenticated
     * @bodyParam id numeric required
     * @response 200{
     * "status": true,
     *  "statusCode": 200,
     *  "message": "Service Centers list",
     *  "data": {
     *          {
     *              "id": 51,
     *              "slot_start_time": "2:00 PM",
     *              "slot_end_time": "5:00 PM",
     *              "slot_date": "2023-09-21"
     *          },
     *          {
     *              "id": 50,
     *              "slot_start_time": "1:00 PM",
     *              "slot_end_time": "3:00 PM",
     *              "slot_date": "2023-09-19"
     *          },
     *  }
     * }
     * @response 201{
     * "status": false,
     * "statusCode": 201,
     * "error": "No clinic found"
     * }
     */

    public function presentSheduleDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:clinic_details,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(),'status'=>false,'statusCode' => 201], 201);
        }

        try {
            $clinic = ClinicDetails::find($request->id);
            if ($clinic) {
                $data = Slot::where('clinic_detail_id', $request->id)->where('slot_date', '>=', date('Y-m-d'))->orderBy('slot_date', 'desc')->get();
                $data = fractal($data, new PresentSheduleTransformer())->toArray()['data'];
                return response()->json([
                    'status' => true,
                    'statusCode' => $this->successStatus,
                    'message' => 'Service Centers list',
                    'data' => $data
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 201,
                    'message' => 'No clinic found',
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Delete Present shedule date
     * @authenticated
     * @bodyParam id numeric required
     * @response 200{
     * "status": true,
     *  "statusCode": 200,
     * "message": "Slot deleted successfully",
     * }
     * }
     *
     * @response 201{
     * "status": false,
     * "statusCode": 201,
     * "error": "No clinic found"
     * }
     */

    public function deletePresentSheduleDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:slots,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(),'status'=>false,'statusCode' => 201], 201);
        }

        try {
            $clinic = Slot::find($request->id);
            if ($clinic) {
                $clinic->delete();
                return response()->json([
                    'status' => true,
                    'statusCode' => $this->successStatus,
                    'message' => 'Slot deleted successfully',
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 201,
                    'message' => 'No clinic found',
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
