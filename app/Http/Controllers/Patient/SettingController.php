<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\HelpAndSupport;
use App\Models\PrivacyPolicy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function setting()
    {
        $aboutUs = AboutUs::orderBy('id', 'desc')->first();
        $privacyPolicy = PrivacyPolicy::orderBy('id', 'desc')->where('type', 'Patient')->first();
        return view('frontend.patient.setting')->with(compact('aboutUs', 'privacyPolicy'));
    }

    public function helpAndSupport(Request $request)
    {

        if ($request->ajax()) {
            $request->validate([
                'subject' => 'required',
                'message' => 'required',
            ]);

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
        return view('frontend.auth.patient-delete-account');
    }

    public function deleteAccountPermission()
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->delete();
        return redirect()->back()->with('message', 'Your account has been deleted successfully.');
    }
}
