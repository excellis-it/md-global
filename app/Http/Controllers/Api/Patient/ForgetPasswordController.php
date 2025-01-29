<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Mail\SendOtpMail;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * @group Forget Password
 */
class ForgetPasswordController extends Controller
{
    public $successStatus = 200;
    /**
     * Forget Password Api
     * @bodyparam email string required Email of the Patient. Example: john@yopmail.com
     * @response 200{
     *  "status": true,
     *  "statusCode": 200,
     *  "message": "OTP has been sent to your email"
     * }
     *
     * @response 201{
     * "status": false,
     *  "statusCode": 201,
     * "error": {
     * "email": [
     * "The email field is required."
     * ]
     *  }
     * }
     */
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'statusCode' => 401,
                'error' => $validator->errors()->first()
            ], 201);
        }

        try {
            $user = User::where('email', $request->email)->first();
            if ($user->hasRole('PATIENT')) {
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
                return response()->json([
                    'status' => true,
                    'statusCode' => $this->successStatus,
                    'message' => 'OTP has been sent to your email'
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 201,
                    'error' => 'Admin &Medical Staff can not reset password from here'
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * OTP Verification Api
     *
     * @bodyparam otp numeric required OTP of the Patient. Example: 123456
     * @bodyparam email string required Email of the Patient. Example: john@yopmail.com
     * @response 200{
     * "status": true,
     * "statusCode": 200,
     * "message": "OTP verified successfully"
     * }
     *
     * @response 201{
     * "status": false,
     * "statusCode": 401,
     * "error": "OTP is expired"
     * }
     *
     */

    public function otpVerification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|numeric|digits:6',
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'statusCode' => 201,'status'=>false], 201);
        }

        try {
            $user = User::where('email', $request->email)->first();
            $otp = PasswordReset::where('email', $user->email)->first();
            if ($otp->token == $request->otp) {
                $newtime = date('h:i A', strtotime($otp->created_at->addHour()));
                $currenttime = date('h:i A');
                if ($newtime < $currenttime) {
                    return response()->json([
                        'status' => false,
                        'statusCode' => 201,
                        'error' => 'OTP is expired'
                    ], 201);
                } else {
                    return response()->json([
                        'status' => true,
                        'statusCode' => $this->successStatus,
                        'message' => 'OTP verified successfully'
                    ], $this->successStatus);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'statusCode' => 201,
                    'error' => 'OTP is not valid'
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Reset Password Api
     *
     * @bodyparam password string required Password of the Patient. Example: 123456
     * @bodyparam confirm_password string required Confirm Password of the Patient. Example: 123456
     * @bodyparam email string required Email of the Patient. Example: john@yopmail.com
     * @response 200{
     * "status": true,
     * "statusCode": 200,
     * "message": "Password has been reset successfully"
     * }
     *
     * @response 201{
     * "status": false,
     * "statusCode": 201,
     * "error": {
     * "password": [
     * "The password field is required."
     * ],
     * "confirm_password": [
     * "The confirm password field is required."
     * ],
     * "email": [
     * "The email field is required."
     * ]
     * }
     * }
     *
     */

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(), 'statusCode' => 201,'status'=>false], 201);
        }

        try {
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            PasswordReset::where('email', $request->email)->delete();
            return response()->json([
                'status' => true,
                'statusCode' => $this->successStatus,
                'message' => 'Password reset successfully'
            ], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'statusCode' => 500,
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
