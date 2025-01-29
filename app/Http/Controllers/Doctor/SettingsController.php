<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\HelpAndSupport;
use App\Models\PrivacyPolicy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SettingsController extends Controller
{
    public function settings()
    {
        $privacyPolicy = PrivacyPolicy::orderBy('id', 'desc')->where('type', 'Doctor')->first();
        $aboutUs = AboutUs::orderBy('id', 'desc')->first();
        return view('frontend.doctor.settings')->with(compact('privacyPolicy', 'aboutUs'));
    }

    public function helpAndSupport(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($request->ajax()) {
            $helpAndSupport = new HelpAndSupport;
            $helpAndSupport->user_id = auth()->user()->id;
            $helpAndSupport->name = Auth::user()->name;
            $helpAndSupport->email = Auth::user()->email;
            $helpAndSupport->phone = Auth::user()->phone;
            $helpAndSupport->subject = $request->subject;
            $helpAndSupport->message = $request->message;
            $helpAndSupport->save();
            return response()->json(['status' => 'success', 'message' => 'Your message has been sent successfully.']);
        }
    }

    public function deleteAccount()
    {
        return view('frontend.auth.doctor-delete-account');
    }

    public function deleteAccountPermission()
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->delete();
        return redirect()->back()->with('message', 'Your account has been deleted successfully.');
    }
}
