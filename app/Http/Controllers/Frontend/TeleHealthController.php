<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Blog;
use App\Models\Specialization;
use App\Models\ClinicDetails;
use App\Models\User;
use App\Models\Symptoms;
use App\Models\TelehealthCms;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\View;

class TeleHealthController extends Controller
{
    public function telehealth()
    {
        $telehealth=TelehealthCms::orderBy('id', 'desc')->first();
        $specilization = Specialization::orderBy('id', 'desc')->first();
        $blogs = Blog::orderBy('id', 'desc')->get();
        $blog = Blog::orderBy('id', 'desc')->first();
        $symptoms = Symptoms::orderBy('id', 'desc')->where('symptom_status', 1)->get();
        $speciliaztions = Specialization::orderBy('id', 'desc')->where('status', 1)->get();
        return view('frontend.telehealth')->with(compact('blogs', 'blog', 'symptoms', 'speciliaztions','telehealth'));
    }

    public function  viewAllSpecializations()
    {
        $specilization = Specialization::orderBy('id', 'desc')->first();
        $speciliaztions = Specialization::where('status', 1)->get();
        return view('frontend.all-specialist')->with(compact('speciliaztions','specilization'));
    }

    public function searchSpecialization(Request $request)
    {
        if ($request->ajax()) {
            if ($request->search == null) {
                $speciliaztions = Specialization::orderBy('id', 'desc')->where('status', 1)->get();
                return response()->json(['view' => (string)View::make('frontend.search-specilzation')->with(compact('speciliaztions'))]);
            } else {
                $speciliaztions = Specialization::orderBy('id', 'desc')->where('name', 'LIKE', '%' . $request->search . '%')->get();
                return response()->json(['view' => (string)View::make('frontend.search-specilzation')->with(compact('speciliaztions'))]);
            }
        }
    }

    public function doctors($type, $slug)
    {
        if ($type == 'symptoms') {
            $data = Symptoms::where('symptom_slug', $slug)->where('symptom_status', 1)->first();
            $symptom_id = $data->id;
            // get clinics within 10km radius
            $latitude = AutH::user()->locations->latitude;
            $longitude = Auth::user()->locations->longitude;
            $radius = 10;
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
                ->where('symptoms.id', $symptom_id)
                ->get()
                ->groupBy('user_id');
            // get doctors from clinics
            $doctors_array = [];
            foreach ($clinics as $key => $clinic) {

                $doctors_array[] =  $key;
            }
            $doctors = User::whereIn('id', $doctors_array)->get();
            $status = 1;
            // @dd($doctors);
            $type = 'symptoms';

            return view('frontend.doctors')->with(compact('doctors', 'data', 'type', 'status'));
        } else {
            $data = Specialization::where('slug', $slug)->first();
            $specialization_id = $data->id;
            // $doctors = $data->doctors()->where('status', 1)->get();
            // get clinics within 10km radius
            // dd(Auth::user());
            $latitude = Auth::user()->locations->latitude;
            $longitude = Auth::user()->locations->longitude;
            $radius = 10;
            $all_doctors = DB::table('users')
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
                ->where('doctor_specializations.specialization_id', $specialization_id)
                ->get()
                ->groupBy('user_id');
            // dd($clinics);
            // get doctors from clinics
            $doctors_array = [];
            foreach (
                $all_doctors
                as $key => $clinic
            ) {
                $doctors_array[] =  $key;
            }
            $doctors = User::whereIn('id', $doctors_array)->get();
            $status = 1;
            $type = 'specialization';


            return view('frontend.doctors')->with(compact('doctors', 'data', 'type', 'status'));
        }
    }

    public function doctorFilter(Request $request)
    {
        $data_slug = $request->slug;
        $type = $request->type;

        if ($type == 'symptoms') {

            $data = Symptoms::where('symptom_slug', $data_slug)->where('symptom_status', 1)->first();

            $symptom_id = $data->id;
            // get clinics within 10km radius
            $latitude = AutH::user()->locations->latitude;
            $longitude = Auth::user()->locations->longitude;
            $radius = 10;
            if ($request->clinic == 1) {
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
                    ->where('symptoms.id', $symptom_id)
                    ->having('distance', '<', $radius)
                    ->get()
                    ->groupBy('user_id');

                // get doctors from clinics
                $doctors_array = [];
                foreach ($clinics as $key => $clinic) {

                    $doctors_array[] =  $key;
                }

                $query = User::whereIn('id', $doctors_array);

                if ($request->doctor) {
                    $query->where('name', 'like', '%' . $request->doctor . '%');
                }

                if ($request->alphabet == 1) {
                    $query->orderBy('name');
                } elseif ($request->alphabet == 2) {
                    $query->orderByDesc('name');
                }

                $doctors = $query->get();
            } else {

                $all_doctors = DB::table('users')
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
                    ->where('symptoms.id', $symptom_id)
                    ->get()
                    ->groupBy('user_id');

                $doctors_array = [];
                foreach ($all_doctors as $key => $clinic) {

                    $doctors_array[] =  $key;
                }
                if ($request->alphabet == 1) {
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->orderBy('name')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->orderBy('name')
                            ->get();
                    }
                } else if ($request->alphabet == 2) {
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->orderByDesc('name')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->orderByDesc('name')
                            ->get();
                    }
                } else {
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)->get();
                    }
                }
            }
            $type = 'symptoms';
            return response()->json(['view' => (string)View::make('frontend.ajax-doctor-list')->with(compact('doctors', 'data', 'type'))]);
        } else {
            // return $request->all();
            $data = Specialization::where('slug', $data_slug)->first();
            $specialization_id = $data->id;
            $latitude = Auth::user()->locations->latitude;
            $longitude = Auth::user()->locations->longitude;
            $radius = 10;
            if ($request->clinic == 1) {
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
                    ->where('doctor_specializations.specialization_id', $specialization_id)
                    ->having('distance', '<', $radius)
                    ->get()
                    ->groupBy('user_id');

                // get doctors from clinics
                $doctors_array = [];
                foreach ($clinics as $key => $clinic) {

                    $doctors_array[] =  $key;
                }

                if ($request->alphabet == 1) { // Ascending order
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->orderBy('name')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->orderBy('name')
                            ->get();
                    }
                } elseif ($request->alphabet == 2) { // Descending order
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->orderByDesc('name')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->orderByDesc('name')
                            ->get();
                    }
                } else { // Default case
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->get();
                    }
                }
            } else {
                $all_doctors = DB::table('users')
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
                    ->where('doctor_specializations.specialization_id', $specialization_id)
                    ->get()
                    ->groupBy('user_id');

                $doctors_array = [];
                foreach ($all_doctors as $key => $clinic) {

                    $doctors_array[] =  $key;
                }

                if ($request->alphabet == 1) { // Alphabetical ascending
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->orderBy('name')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->orderBy('name')
                            ->get();
                    }
                } else if ($request->alphabet == 2) { // Alphabetical descending
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->orderByDesc('name')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->orderByDesc('name')
                            ->get();
                    }
                } else { // Default case
                    if ($request->doctor) {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->where('name', 'like', '%' . $request->doctor . '%')
                            ->get();
                    } else {
                        $doctors = User::whereIn('id', $doctors_array)
                            ->get();
                    }
                }
            }
            $type = 'specialization';

            return response()->json(['view' => (string)View::make('frontend.ajax-doctor-list')->with(compact('doctors', 'data', 'type'))]);
        }
    }
}
