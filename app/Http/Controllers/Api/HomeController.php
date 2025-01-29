<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClinicDetails;
use App\Models\FooterCms;
use App\Models\HomePage;
use App\Models\Specialization;
use App\Models\Symptoms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Location;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * @group Home Page Api's
 */

class HomeController extends Controller
{
    public $successStatus = 200;

    /**
     * Symptoms Api
     * @response 200{
     * "status": true,
     * "statusCode": 200,
     * "data": [
     *     {
     *         "id": 2,
     *         "specialization_id": 2,
     *         "symptom_name": "Oral Piercing Infection",
     *         "symptom_description": "<p>Visit your medical stuff for joint pain, sprains, arthritis, and other bone pains.</p>",
     *         "symptom_image": "symptoms/J1Qbab05PP4gVTbBJ3bJ5bW6up46R99VaXpp4uXi.png",
     *         "symptom_status": 1,
     *         "created_at": "2023-06-06T07:13:51.000000Z",
     *         "updated_at": "2023-06-06T07:13:51.000000Z"
     *     }
     *   ]
     * }
     *
     * @response 201{
     * "status": false,
     * "statusCode": 201,
     * "message": "No Symptoms Found"
     * }
     */

    public function symptoms(Request $request)
    {
        try {
            $limit = $request->limit ? $request->limit : 10;
            $offset = $request->offset ? $request->offset : 0;
            $count = Symptoms::where('symptom_status', 1)->count();
            if ($count > 0) {
                $data = Symptoms::query();

                if ($request->search) {
                    $data->where('symptom_name', 'like', '%' . $request->search . '%');
                }
                $symptoms = $data->where('symptom_status', 1)->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();
                return response()->json(['status' => true, 'statusCode' => 200, 'data' => $symptoms]);
            } else {
                return response()->json(['status' => false, 'statusCode' => 201, 'message' => 'No Symptoms Found'], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()]);
        }
    }

    /**
     * Specialization Api
     * @response 200{
     *  "status": true,
     *  "statusCode": 200,
     *  "data": [
     *      {
     *          "id": 3,
     *          "name": "Dermatologist",
     *          "slug": "dermatologist",
     *          "image": "specializations/V2TlHIoJvN7dL2bYdkUoh2GYhwitQotuohwGNqKe.png",
     *          "description": "Visit your medical stuff for joint pain, sprains, arthritis, and other bone pains.",
     *          "status": 1,
     *          "created_at": "2023-06-06T10:55:47.000000Z",
     *          "updated_at": "2023-06-06T10:55:47.000000Z"
     *      }
     *    ]
     * }
     *
     * @response 201{
     * "status": false,
     *  "statusCode": 201,
     *  "message": "No Specialization Found"
     * }
     */

    public function specializations(Request $request)
    {
        try {
            $count = Specialization::where('status', 1)->count();
            $limit = $request->limit ? $request->limit : 10;
            $offset = $request->offset ? $request->offset : 0;
            if ($count > 0) {
                $data = Specialization::query();
                if ($request->search) {
                    $data->where('name', 'like', '%' . $request->search . '%');
                }
                $specializations = $data->where('status', 1)->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();
                return response()->json(['status' => true, 'statusCode' => 200, 'data' => $specializations]);
            } else {
                return response()->json(['status' => false, 'statusCode' => 201, 'message' => 'No Specialization Found'], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()]);
        }
    }


    /**
     * Location Store Api
     * @bodyParam latitude string required The latitude of the location.
     * @bodyParam longitude string required The longitude of the location.
     * @response 200{
     *  "status": true,
     *  "statusCode": 200,
     *  "data": [
     *      {
     *          "id": 23,
     *          "user_id": 14,
     *          "session_id": null,
     *          "ip_address": "127.0.0.1",
     *          "address": "J92M+P72, Kolkata Station Rd, Belgachia, Kolkata, West Bengal 700004, India",
     *          "latitude": "22.5764753",
     *          "longitude": "88.4306861",
     *          "created_at": "2023-06-06T10:55:47.000000Z",
     *          "updated_at": "2023-06-06T10:55:47.000000Z"
     *      }
     *    ]
     * }
     *
     *
     */

    public function storeLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'statusCode' => 201, 'status' => false], 201);
        }

        try {
            $location = new Location();
            $location->user_id = auth()->user()->id;
            $location->session_id = null;
            $location->ip_address = $request->ip();
            $location->address = $request->address;
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->save();

            return response()->json(['status' => true, 'statusCode' => 200, 'data' => $location], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()], 500);
        }
    }


    /**
     * All doctors Api
     * @response 200{
     *  "status": true,
     *  "statusCode": 200,
     *  "data": [
     *      {
     *          "id": 13,
     *          "name": "Shreeja Sadhukhan",
     *          "email": "shreeja@yopmail.com",
     *          "phone": "7475850123",
     *          "email_verified_at": "null",
     *          "profile_picture": "medical stuff/Vd1tp4kQptLxMkCVW5M0q8F9hE2KpEEedIi9LxNz.jpg",
     *          "year_of_experience": "3",
     *          "license_number": "null",
     *          "location": "Purba Bardhaman",
     *          "gender": "Female",
     *          "age": "22",
     *          "status": 1,
     *          "fcm_token": null,
     *          "created_at": "2023-06-06T10:55:47.000000Z",
     *          "updated_at": "2023-06-06T10:55:47.000000Z",
     *          "deleted_at": null
     *      }
     *    ]
     * }
     *
     * @response 201{
     * "status": false,
     *  "statusCode": 201,
     *  "message": "NoMedical Staff Found in your area!"
     * }
     */

    public function allDoctorsByLocation(Request $request)
    {
        try {
            // get clinics within 10km radius
            $latitude = Auth::user()->locations->latitude;
            $longitude = Auth::user()->locations->longitude;
            $radius = 10;
            // $doctors = User::Role('DOCTOR')->where('status', 1)->orderBy('id', 'desc')->get();
            $limit = $request->limit ? $request->limit : 10;
            $offset = $request->offset ? $request->offset : 0;

            $clinics = DB::table('clinic_details')
                ->join('users', 'clinic_details.user_id', '=', 'users.id')
                ->select(
                    'clinic_details.id',
                    'clinic_details.user_id',
                    'clinic_name',
                    'clinic_address',
                    'clinic_phone',
                    'longitute',
                    'latitute',
                    DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance')
                )
                ->having('distance', '<', $radius)
                ->get()
                ->groupBy('user_id');
            // get doctors from clinics
            $doctors_array = [];
            foreach ($clinics as $key => $clinic) {
                $doctors_array[] =  $key;
            }

            $allDotor = User::whereIn('id', $doctors_array)->where('status', 1)->orderBy('id', 'desc')->offset($offset)->limit($limit)->get();
            if (count($allDotor) > 0) {
                $doctors = fractal($allDotor, new UserTransformer)->toArray()['data'];
                return response()->json(['status' => true, 'statusCode' => 200, 'data' => $doctors]);
            } else {
                return response()->json(['status' => false, 'statusCode' => 201, 'message' => 'NoMedical Staff Found in your area!'], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()]);
        }
    }



    /**
     *Medical Stuff List as per symptoms/specializations Api
     * @bodyParam type string required The type of the search. example - symptoms, specializations, all
     * @bodyParam slug string required The slug of the search. example - dermatologist, oral-piercing-infection
     * @bodyParam filter string required The filter of the search. example - all, clinic
     *
     * @response 200{
     *  "status": true,
     *  "statusCode": 200,
     *  "data": [
     *      {
     *          "id": 13,
     *          "name": "Shreeja Sadhukhan",
     *          "email": "shreeja@yopmail.com",
     *          "phone": "7475850123",
     *          "email_verified_at": "null",
     *          "profile_picture": "medical stuff/Vd1tp4kQptLxMkCVW5M0q8F9hE2KpEEedIi9LxNz.jpg",
     *          "year_of_experience": "3",
     *          "license_number": "null",
     *          "location": "Purba Bardhaman",
     *          "gender": "Female",
     *          "age": "22",
     *          "status": 1,
     *          "fcm_token": null,
     *          "created_at": "2023-06-06T10:55:47.000000Z",
     *          "updated_at": "2023-06-06T10:55:47.000000Z",
     *          "deleted_at": null
     *      }
     *    ]
     * }
     *
     * @response 201{
     * "status": false,
     *  "statusCode": 201,
     *  "message": "NoMedical Staff Found"
     * }
     */


    public function doctorsList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'slug' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 201);
        }

        try {
            $type = $request->type;
            $slug = $request->slug;
            $limit = $request->limit ? $request->limit : 10;
            $offset = $request->offset ? $request->offset : 0;
            $latitude = Auth::user()->locations->latitude;
            $longitude = Auth::user()->locations->longitude;
            $radius = 10;

            if ($type == 'symptoms') {
                $symptom_id = Symptoms::whereIn('symptom_slug', $slug)->where('symptom_status', 1)->pluck('id')->toArray();
                if ($request->filter == 'all') {
                    $clinics = DB::table('users')
                        ->join('doctor_specializations', 'users.id', '=', 'doctor_specializations.doctor_id')
                        ->leftJoin('symptoms', 'symptoms.specialization_id', '=', 'doctor_specializations.specialization_id')
                        ->leftJoin('locations', 'locations.user_id', '=', 'users.id')
                        ->select(
                            'users.id as user_id',
                            'users.name',
                            'users.email',
                            'users.phone',
                            'users.year_of_experience',
                            'users.license_number',
                            'users.profile_picture',
                            'users.gender',
                            'users.fcm_token',
                            'locations.address as address',
                            'locations.latitude as latitude',
                            'locations.longitude as longitude',
                            DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) AS distance')
                        )
                        ->whereIn('symptoms.id', $symptom_id)
                        ->get()
                        ->groupBy('user_id');
                } else {
                    $clinics = DB::table('clinic_details')
                        ->join('users', 'clinic_details.user_id', '=', 'users.id')
                        ->join('doctor_specializations', 'users.id', '=', 'doctor_specializations.doctor_id')
                        ->leftJoin('symptoms', 'symptoms.specialization_id', '=', 'doctor_specializations.specialization_id')
                        ->select(
                            'clinic_details.id',
                            'clinic_details.user_id',
                            'clinic_name',
                            'clinic_address',
                            'clinic_phone',
                            'longitute',
                            'latitute',
                            DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance')
                        )
                        ->whereIn('symptoms.id', $symptom_id)
                        ->having('distance', '<', $radius)
                        ->get()
                        ->groupBy('user_id');
                }
                $result['type'] = 'symptoms';
            } else if ($type == 'specialization') {
                $specialization_id = Specialization::whereIn('slug', $slug)->pluck('id')->toArray();;
                // get doctors within 10km radius
                if ($request->filter == 'all') {
                    $clinics = DB::table('users')
                        ->join('doctor_specializations', 'users.id', '=', 'doctor_specializations.doctor_id')
                        ->leftJoin('symptoms', 'symptoms.specialization_id', '=', 'doctor_specializations.specialization_id')
                        ->leftJoin('locations', 'locations.user_id', '=', 'users.id')
                        ->select(
                            'users.id as user_id',
                            'users.name',
                            'users.email',
                            'users.phone',
                            'users.year_of_experience',
                            'users.license_number',
                            'users.profile_picture',
                            'users.gender',
                            'users.fcm_token',
                            'locations.address as address',
                            'locations.latitude as latitude',
                            'locations.longitude as longitude',
                            DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) AS distance')
                        )
                        ->whereIn('doctor_specializations.specialization_id', $specialization_id)
                        ->having('distance', '<', $radius)
                        ->get()
                        ->groupBy('user_id');
                } else {
                    $clinics = DB::table('clinic_details')
                        ->join('users', 'clinic_details.user_id', '=', 'users.id')
                        ->join('doctor_specializations', 'users.id', '=', 'doctor_specializations.doctor_id')
                        ->select(
                            'clinic_details.id',
                            'clinic_details.user_id',
                            'clinic_name',
                            'clinic_address',
                            'clinic_phone',
                            'longitute',
                            'latitute',
                            DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance')
                        )
                        ->whereIn('doctor_specializations.specialization_id', $specialization_id)
                        ->having('distance', '<', $radius)
                        ->get()
                        ->groupBy('user_id');
                }
                $result['type'] = 'specialization';
            } else {
                if ($request->filter == 'all') {
                    if ($request->symptoms_slug) {
                        $clinics = User::where('status', 1)->whereHas('symptoms', function ($query) use ($request) {
                            $query->whereIn('symptom_slug', $request->symptoms_slug);
                        })->whereHas('roles', function ($query) {
                            $query->where('name', 'DOCTOR');
                        })->orderBy('id', 'desc')->get()->groupBy('id');
                    } elseif ($request->specialization_slug) {
                        $clinics = User::where('status', 1)->whereHas('specializations', function ($query) use ($request) {
                            $query->whereIn('slug', $request->specialization_slug);
                        })->orderBy('id', 'desc')->get()->groupBy('id');
                    } else {
                        $clinics = User::whereHas('roles', function ($query) {
                            $query->where('name', 'DOCTOR');
                        })->where('status', 1)->orderBy('id', 'desc')->get()->groupBy('id');
                        // Role wise medical stuff

                    }
                } else {
                    if ($request->symptoms_slug) {
                        $clinics = DB::table('clinic_details')
                            ->join('users', 'clinic_details.user_id', '=', 'users.id')
                            ->join('doctor_specializations', 'users.id', '=', 'doctor_specializations.doctor_id')
                            ->leftJoin('symptoms', 'symptoms.specialization_id', '=', 'doctor_specializations.specialization_id')
                            ->select(
                                'clinic_details.id',
                                'clinic_details.user_id',
                                'clinic_name',
                                'clinic_address',
                                'clinic_phone',
                                'longitute',
                                'latitute',
                                DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance')
                            )
                            ->whereIn('symptoms.symptom_slug', $request->symptoms_slug)
                            ->having('distance', '<', $radius)
                            ->get()
                            ->groupBy('user_id');
                    } elseif ($request->specialization_slug) {
                        $clinics = DB::table('clinic_details')
                            ->join('users', 'clinic_details.user_id', '=', 'users.id')
                            ->join('doctor_specializations', 'users.id', '=', 'doctor_specializations.doctor_id')
                            ->select(
                                'clinic_details.id',
                                'clinic_details.user_id',
                                'clinic_name',
                                'clinic_address',
                                'clinic_phone',
                                'longitute',
                                'latitute',
                                DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance')
                            )
                            ->whereIn('doctor_specializations.slug', $request->specialization_slug)
                            ->having('distance', '<', $radius)
                            ->get()
                            ->groupBy('user_id');
                    } else {
                        $clinics = DB::table('clinic_details')
                            ->join('users', 'clinic_details.user_id', '=', 'users.id')
                            ->select(
                                'clinic_details.id',
                                'clinic_details.user_id',
                                'clinic_name',
                                'clinic_address',
                                'clinic_phone',
                                'longitute',
                                'latitute',
                                DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance')
                            )
                            ->having('distance', '<', $radius)
                            ->get()
                            ->groupBy('user_id');
                    }
                }
                $result['type'] = 'all';
            }

            // get doctors from clinics
            $doctors_array = [];
            foreach ($clinics as $key => $clinic) {
                $doctors_array[] =  $key;
            }
            $result = [];
            $doctors = User::whereIn('id', $doctors_array)->where('status', 1);

            if ($request->search) {
                $doctors->where('name', 'like', '%' . $request->search . '%');
            } elseif ($request->sortBy == 'asc') {
                $doctors->orderBy('name', 'asc');
            } elseif ($request->sortBy == 'desc') {
                $doctors->orderBy('name', 'desc');
            } else {
                $doctors->orderBy('name', 'desc');
            }

            $result['doctorList'] = fractal($doctors->offset($offset)->limit($limit)->get(), new UserTransformer)->toArray()['data'];

            return response()->json(['status' => true, 'statusCode' => 200, 'data' => $result]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()]);
        }
    }


    /**
     *Medical Stuff/Service Centers List as per search Api
     * @response 200{
     *  "status": true,
     *  "statusCode": 200,
     *  "data": [
     *      {
     *          "id": 13,
     *          "name": "Shreeja Sadhukhan",
     *          "email": "shreeja@yopmail.com",
     *          "phone": "7475850123",
     *          "email_verified_at": "null",
     *          "profile_picture": "medical stuff/Vd1tp4kQptLxMkCVW5M0q8F9hE2KpEEedIi9LxNz.jpg",
     *          "year_of_experience": "3",
     *          "license_number": "null",
     *          "location": "Purba Bardhaman",
     *          "gender": "Female",
     *          "age": "22",
     *          "status": 1,
     *          "fcm_token": null,
     *          "created_at": "2023-06-06T10:55:47.000000Z",
     *          "updated_at": "2023-06-06T10:55:47.000000Z",
     *          "deleted_at": null
     *      }
     *    ]
     * }
     *
     * @response 404{
     * "status": false,
     *  "statusCode": 404,
     *  "message": "NoMedical Staff or Service Centers Found"
     * }
     */


    public function searchDoctorOrClinic(Request $request)
    {

        // get clinics within 10km radius
        $latitude = Auth::user()->locations->latitude;
        $longitude = Auth::user()->locations->longitude;
        $radius = 10;
        $clinics = DB::table('clinic_details')
            ->join('users', 'clinic_details.user_id', '=', 'users.id')
            ->join('doctor_specializations', 'users.id', '=', 'doctor_specializations.doctor_id')
            ->select(
                'clinic_details.id',
                'clinic_details.user_id',
                'clinic_name',
                'clinic_address',
                'clinic_phone',
                'longitute',
                'latitute',
                DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance')
            )
            ->having('distance', '<', $radius)
            ->get()
            ->groupBy('user_id');

        // get doctors from clinics
        $doctors_array = [];
        $clinics_array = [];
        foreach ($clinics as $key => $clinic) {
            $doctors_array[] =  $key;
            $clinics_array[] = $clinic->id;
        }

        $doctors = User::whereIn('id', $doctors_array)->where('name', 'like', '%', $request->search)->get();
        $clinics = ClinicDetails::whereIn('id', $clinics_array)->where('clinic_name', 'like', '%', $request->search)->get();

        $results = $doctors->union($clinics)->get();

        return response()->json(['status' => true, 'statusCode' => 200, 'data' => $results]);
    }


    /**
     *  Banner Api
     */

    public function banner(Request $request)
    {
        try {
            $banners = HomePage::where('type', 1)->orderBy('id', 'desc')->get();
            return response()->json(['status' => true, 'statusCode' => 200, 'data' => $banners]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()]);
        }
    }

    /**
     * Footer Details Api
     */

    public function footerDetails(Request $request)
    {
        try {
            $footer = FooterCms::orderBy('id', 'desc')->first();
            return response()->json(['status' => true, 'statusCode' => 200, 'data' => $footer]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()]);
        }
    }
}
