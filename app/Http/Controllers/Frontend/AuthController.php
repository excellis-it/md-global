<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Models\Location;
use App\Models\DoctorSpecialization;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('frontend.auth.login');
    }

    public function register()
    {
        return view('frontend.auth.register');
    }

    //doctor login

    public function doctorLogin()
    {
        return view('frontend.auth.doctor-login');
    }

    public function registerDoctor()
    {
        $specializations = Specialization::orderBy('name', 'asc')->get();
        return view('frontend.auth.doctor-register')->with(compact('specializations'));
    }

    public function loginCheck(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8|max:20',
        ]);

            $checkExistorNor = User::role('PATIENT')->where('email', $request->email)->first();
            if (!$checkExistorNor) {
                // Redirect back with error and input
                return redirect()->back()
                    ->withInput() // Keeps the form input
                    ->withErrors(['email' => 'Invalid email or password']); // Sends error for the email field
            }



        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // dd(session()->all());
            $user = Auth::user();
            $location = Location::where('user_id', $user->id)->latest('id')->first();
            if ($user->status == true) {
                if ($user->hasRole('PATIENT')) {
                    if ($location || session()->has('latitude')) {
                        if (Session::has('session_id')) {
                            // Location::where('user_id', $user->id)->delete();
                            Location::where('session_id', Session::get('session_id'))->update(['user_id' => Auth::user()->id]);
                        }

                        if ($request->type == 'telehealth_page') {
                            return redirect()->route('telehealth')->with('message', 'Login successful');
                        } else {
                            return redirect()->route('patient.dashboard');
                        }
                    } else {
                        Auth::logout();
                        return redirect()->route('home')->with('error', 'Add your location first to login');
                    }
                } else {
                    Auth::logout();
                    return redirect()->back()->with('error', 'Your account is not active. Please contact with admin');
                }
            } else {
                Auth::logout();
                return redirect()->route('home');
            }
        } else {
            Auth::logout();
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    //doctor login

    public function loginDoctor(Request $request){
        // dd($request->all());
        $request->validate([
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8|max:20'
        ]);

        $checkExistorNor = User::role('DOCTOR')->where('email', $request->email)->first();
        if (!$checkExistorNor) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Invalid email or password']);
        }


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // dd(session()->all());
            $user = Auth::user();
            $location = Location::where('user_id', $user->id)->latest('id')->first();
            if ($user->status == true) {
                if ($user->hasRole('DOCTOR')) {
                    if (Session::has('session_id')) {
                        // return Session::get('session_id');
                        // Location::where('user_id', $user->id)->delete();
                        Location::where('session_id', Session::get('session_id'))->update(['user_id' => Auth::user()->id]);
                    }
                    return redirect()->route('doctor.dashboard');
                } else {
                    Auth::logout();
                    return redirect()->back()->with('error', 'Your account is not active. Please contact with admin');
                }
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Your account is not active. Please contact with admin');
            }
        } else {
            Auth::logout();
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }



    public function registerStore(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'phone' => 'required|numeric',
            // 'type' => 'required',
            'email' => 'required|unique:users,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8|max:20',
            'confirm_password' => 'required|min:8|max:20|same:password',
        ], [
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last last name',
            'gender.required' => 'Please select a gender',
            'age.required' => 'Please enter date of birth',
            'phone.required' => 'Please enter phone number',
            'phone.numeric' => 'Phone number must be numeric',
            // 'type.required' => 'Please select a type',
            'email.required' => 'Please enter email address',
            'email.unique' => 'Email address already exists',
            'email.regex' => 'Please enter valid email address',
            'password.required' => 'Please enter password',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must be at most 20 characters',
            'confirm_password.required' => 'Please enter confirm password',
            'confirm_password.min' => 'Confirm password must be at least 8 characters',
            'confirm_password.max' => 'Confirm password must be at most 20 characters',
            'confirm_password.same' => 'Confirm password does not match',
        ]);

        $user = new User();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = true;
        $user->save();

        // if ($request->type == 'Doctor') {
        //     $user->assignRole('DOCTOR');
        // } else {
            $user->assignRole('PATIENT');
        // }


        $maildata = [
            'name' => $request->name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
        ];
        Mail::to($request->email)->send(new WelcomeMail($maildata));

        return redirect()->route('login')->with('message', 'Registration successful. Please login');
    }

    //RegisterMedical Staff

    public function doctorRegister(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'phone' => 'required|numeric',
            'specialization_id' => 'required',
            'license_number' => 'required',
            'years_of_experience' => 'required|numeric',
            'address' => 'required',
            'education' => 'required',
            // 'type' => 'required',
            'email' => 'required|unique:users,email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8|max:20',
            'confirm_password' => 'required|min:8|max:20|same:password',
        ], [
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last last name',
            'gender.required' => 'Please select a gender',
            'age.required' => 'Please enter date of birth',
            'phone.required' => 'Please enter phone number',
            'phone.numeric' => 'Phone number must be numeric',
            'specialization_id.required' => 'Please select a specialization',
            'license_number.required' => 'Please enter license number',
            'years_of_experience.required' => 'Please enter years of experience',
            'years_of_experience.numeric' => 'Years of experience must be numeric',
            'address.required' => 'Please enter address',
            'education.required' => 'Please enter education',
            // 'type.required' => 'Please select a type',
            'email.required' => 'Please enter email address',
            'email.unique' => 'Email address already exists',
            'email.regex' => 'Please enter valid email address',
            'password.required' => 'Please enter password',
            'password.min' => 'Password must be at least 8 characters',
            'password.max' => 'Password must be at most 20 characters',
            'confirm_password.required' => 'Please enter confirm password',
            'confirm_password.min' => 'Confirm password must be at least 8 characters',
            'confirm_password.max' => 'Confirm password must be at most 20 characters',
            'confirm_password.same' => 'Confirm password does not match',
        ]);

        $user = new User();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->license_number = $request->license_number;
        $user->year_of_experience = $request->years_of_experience;
        $user->location = $request->address;
        $user->education = $request->education;
        $user->password = bcrypt($request->password);
        $user->status = true;
        $user->save();

        // if ($request->type == 'Doctor') {
        //     $user->assignRole('DOCTOR');
        // } else {
            $user->assignRole('DOCTOR');
        // }

        if ($request->specialization_id) {
            DoctorSpecialization::where('doctor_id', $user->id)->delete();
            foreach ($request->specialization_id as $specialization_id) {
                $doctorSpecialization = DoctorSpecialization::create([
                    'doctor_id' => $user->id,
                    'specialization_id' => $specialization_id,
                ]);
            }
        }

        $maildata = [
            'name' => $request->name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
        ];
        Mail::to($request->email)->send(new WelcomeMail($maildata));

        return redirect()->route('medical-stuff.register')->with('message', 'Registration successful. Please login');
    }

    public function patientLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function doctorLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function checkValidation(Request $request)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'email' => [
            'required',
            'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'exists:users,email',
        ],
        'password' => 'required|min:8|max:20',
    ]);

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ]);
    }

    // Check if the user with the role "PATIENT" exists
    $user = User::role('PATIENT')->where('email', $request->email)->first();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password',
        ]);
    }

    return response()->json([
        'status' => true,
        'message' => 'Email is valid',
    ]);
}

}
