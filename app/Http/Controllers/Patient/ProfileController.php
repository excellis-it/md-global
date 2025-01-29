<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use ImageTrait;
    public function profile()
    {
        return view('frontend.patient.profile');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,' . auth()->user()->id,
            'gender' => 'required',
            'age' => 'required',
            'phone' => 'required|numeric',
        ]);

        $user = User::findOrFail(auth()->user()->id);
        $user->name = $request->name;
        $user->gender = $request->gender;
        $user->age = $request->age;
        $user->phone = $request->phone;
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
                Storage::delete('app/'.$currentImageFilename);
            }
            $user->profile_picture = $this->imageUpload($request->file('profile_picture'), 'patient');
        }
        $user->save();
        return redirect()->back()->with('message', 'Profile updated successfully.');
    }


}
