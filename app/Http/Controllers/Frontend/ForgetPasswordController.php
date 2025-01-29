<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordController extends Controller
{
    public function forgetPassword()
    {
        return view('frontend.auth.forget-password');
    }

    public function forgetPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user->hasRole('ADMIN')) {
            return redirect()->back()->with('error', 'Admin can not reset password from here');
        } else {
            PasswordReset::where('email', $request->email)->delete();
            $otp = rand(100000, 999999);
            PasswordReset::create([
                'email' => $request->email,
                'token' => $otp,
                'created_at' => Carbon::now(),
            ]);

            $details = [
                'id' => base64_encode($user->id),
                'otp' => $otp,
            ];

            Mail::to($request->email)->send(new SendOtpMail($details));
            return redirect()->route('otp.verification', base64_encode($user->id))->with('message', 'OTP has been sent to your email');
        }
    }

    public function otpVerification($id)
    {
        return view('frontend.auth.otp-verification', compact('id'));
    }

    public function otpVerificationSubmit(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = User::find(base64_decode($request->id));
        $otp = PasswordReset::where('email', $user->email)->first();
        if ($otp->token == $request->otp) {
            // add 1 hour with created_at date and time
            $newTime = Carbon::parse($otp->created_at)->addHour();
            // newtime to date time string
            $newTime = $newTime->toDateTimeString();
            // current date and time carbon parse
            $now_time = Carbon::now()->toDateTimeString();
            if ($newTime >= $now_time) {
                return redirect()->back()->with('error', 'OTP has been expired');
            } else {
                return redirect()->route('reset.password', base64_encode($user->id))->with('message', 'OTP verified successfully');
            }
        } else {
            return redirect()->back()->with('error', 'OTP does not match');
        }
    }

    public function resetPassword($id)
    {
        return view('frontend.auth.reset-password', compact('id'));
    }

    public function resetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::find(base64_decode($request->id));
        $user->password = bcrypt($request->password);
        $user->save();
        PasswordReset::where('email', $user->email)->delete();
        return redirect()->route('login')->with('message', 'Password reset successfully');
    }
}
