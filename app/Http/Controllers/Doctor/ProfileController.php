<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialization;
use App\Models\Specialization;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    use ImageTrait;

    public function profile()
    {
        $specializations = Specialization::orderBy('name', 'asc')->get();
        return view('frontend.doctor.profile')->with(compact('specializations'));
    }

    public function profileUpdate(Request $request)
    {
        // return $request;
        $request->validate([
            'name' => 'required',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' . auth()->user()->id,
            'gender' => 'required',
            'age' => 'required',
            'phone' => 'required|numeric',
            'specialization_id' => 'required',
            'license_number' => 'required',
            'years_of_experience' => 'required|numeric',
            'address' => 'required',
            'education' => 'nullable',
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->phone = $request->phone;
        $user->license_number = $request->license_number;
        $user->year_of_experience = $request->years_of_experience;
        $user->location = $request->address;
        $user->education = $request->education;
        $user->about_yourself = $request->about_yourself;
        if ($request->password != null) {
            $request->validate([
                'password' => 'min:8',
                'confirm_password' => 'min:8|same:password',
            ]);
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('profile_picture')) {
            $request->validate([
                'profile_picture' => 'image|mimes:jpg,png,jpeg,gif,svg,webp',
            ]);
            if ($user->profile_picture) {
                $currentImageFilename = $user->profile_picture; // get current image name
                Storage::delete('app/' . $currentImageFilename);
            }
            $user->profile_picture = $this->imageUpload($request->file('profile_picture'), 'doctor');
        }
        $user->save();

        if ($request->specialization_id) {
            DoctorSpecialization::where('doctor_id', Auth::user()->id)->delete();
            foreach ($request->specialization_id as $specialization_id) {
                $doctorSpecialization = DoctorSpecialization::create([
                    'doctor_id' => Auth::user()->id,
                    'specialization_id' => $specialization_id,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Your profile updated successfully.');
    }

    public function changePassword()
    {
        return view('frontend.doctor.change-password');
    }

    public function changePasswordSubmit(Request $request)
    {
        $request->validate([
            'current_password' => 'required|min:8|current_password|different:new_password|different:confirm_password',
            'new_password' => 'required|min:8|different:current_password|same:confirm_password',
            'confirm_password' => 'required|min:8|different:current_password|same:new_password',
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->password = bcrypt($request->new_password);
        $user->save();
        return redirect()->back()->with('message', 'Your password changed successfully.');
    }

    public function deleteAccount()
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->delete();
        return redirect()->route('home')->with('message', 'Account deleted successfully.');
    }
}
