<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @group Authentication
 */
class AuthController extends Controller
{
    public $successStatus = 200;

    /**
     * Login Api
     * @bodyParam email string required The email of the user. Example: john@yopmail.com
     * @bodyParam password string required The password of the user. Example: 12345678
     * @bodyParam type string required The type of the user. Example:Medical Staff,Patient
     * @response 200{
     *  "status": true,
     *  "statusCode": 200,
     *  "message": "Login successfully",
     *      "data": {
     *     "auth_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMzEyNTk2OWIyYjU0MzQzNjAzOGMzMzdiMGQ0NmU1YjIyYzBjYmNmMDRiOTUxNDc4NzA5YTc2NGQ5YTU4NDcwNmM1MWRhNDBmYjcwMTg2ODciLCJpYXQiOjE2ODYxMjIxNTEuODYxNjA2LCJuYmYiOjE2ODYxMjIxNTEuODYxNjEyLCJleHAiOjE3MTc3NDQ1NTEuODM5MTIxLCJzdWIiOiIzIiwic2NvcGVzIjpbXX0.oD9hpcugxOhepc-dbeXf94itOJz5G9OXnV2ZQB05FU80cvwOALpEwuCUC30mczb8tnvKdWxOKK0EPOyUZKv6Y9TXkYCfH0BTpQaikKaomZL_4TqnCrJ9ToZSMjpaSWdVdqoyG5Voakw__nehoNUMup_tcFaGh4IxoFQLGZEIbsmQKOxQvQx9doJo6oU6aY2Nvoetk7GmH4XIPX_D4ThQZF5GWdmQ-H6T4Cv9OfnLL5B5aBJbYHcszkJh_HZ4FJ6ViKt61UlPI6ymYUTpC_lmroXigUkQ5Lw5_a7NxgNbd8NHY-893jLMNry5l51vdSG4m9tmcFY1T7WxPTQZ_WjT2I6YAJrxS3tvJaycI7UqPrhRaWtDW3jMYn-Drn1NaUkawzBO7yLsfDQd_WvPu2zFiw6uKvN9ChN_vs551ssx1mF400sx7sx6O194VswDkstNEoSRbKqbxdSISkJSVmSeVwqwt3fSTf0QGFIJxssBI4psyUWcbu-i64g0E_6gPfQ6PELIJN1H7vCdNZbGxjlcW6xGql0D1vXlL307QMLKdhXbmkQhUKHpjaKvgi430K9m16AxOm3QfJr5fguU7AHTHafpeDxaTEgsLiK2Zo7ZovTzEJKj898gA0btJF2LrAtllB4BzYr9Mc4H2oJ49mA9swqjqbCobTosdTcb7NIoThM",
     *     "user": {
     *         "id": 3,
     *         "name": "John Doe",
     *         "email": "john@yopmail.com",
     *         "status": 1
     *     }
     * }
     *
     * @response 201{
     * "status": false,
     * "statusCode": 201,
     * "error": {
     *    "message": [
     *       "The email field is required.",
     *      "The password field is required."
     *   ]
     * }
     * }
     *
     * @response 201{
     *  "status": false,
     *  "statusCode": 201,
     *  "error": "Email id & password was invalid!"
     * }
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|exists:users,email',
            'password' => 'required',
            'type' => 'required|in:Doctor,Patient',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'error' => $validator->errors()->first(), 'statusCode'=> 201], 201);
        }

        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = User::where('email', $request->email)->select('id', 'name', 'email', 'status')->first();
                if ($request->type == 'Doctor') {
                    if ($user->status == 1 && $user->hasRole('DOCTOR')) {
                        $data['auth_token'] = $user->createToken('accessToken')->accessToken;
                        $data['user'] = $user->makeHidden('roles');
                        return response()->json(['status' => true, 'statusCode' => 200, 'message' => 'Login successfully', 'data' => $data], $this->successStatus);
                    } else {
                        return response()->json(['status' => false, 'statusCode' => 201, 'error' => 'Email id & password was invalid!'], 201);
                    }
                } else if ($request->type == 'Patient') {
                    if ($user->status == 1 && $user->hasRole('PATIENT')) {
                        $data['auth_token'] = $user->createToken('accessToken')->accessToken;
                        $data['user'] = $user->makeHidden('roles');
                        $data['user']['isLocation'] = (($user->locations) ? true : false);
                        return response()->json(['status' => true, 'statusCode' => 200, 'message' => 'Login successfully', 'data' => $data], $this->successStatus);
                    } else {
                        return response()->json(['status' => false, 'statusCode' => 201, 'error' => 'Email id & password was invalid!'], 201);
                    }
                } else {
                    return response()->json(['status' => false, 'statusCode' => 201, 'error' => 'Email id & password was invalid!'], 201);
                }
            } else {
                return response()->json(['status' => false, 'statusCode' => 201, 'error' => 'Email id & password was invalid!'], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()], 500);
        }
    }

    /**
     * Register Api
     * @bodyParam name string required The name of the user. Example: John Doe
     * @bodyParam email string required The email of the user. Example: john@yopmail.com
     * @bodyParam gender string required. Example: Male,Female,Other
     * @bodyParam phone numeric required The phone of the user. Example: 9876543210
     * @bodyParam location string The name of the user. Example: John Doe
     * @bodyParam password string required The password of the user. Example: 12345678
     * @bodyParam confirm_password string required The confirm_password of the user. Example: 12345678
     * @bodyParam type string required The type of the user. Example:Medical Staff,Patient
     *
     * @response 200 {
     *   "status": true,
     *  "statusCode": 200,
     *  "data": {
     *   "auth_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYWVkZWJjZWQ5MzE4OGFjM2YwNGQ1ZTgwYjdhZmFiNjE2N2Q5ZjgzYmM4Zjc0OGI3MDQyNDkzOTJlZTdkYjIzYzUwZTFhODdlMGY0ZTJiYjIiLCJpYXQiOjE2ODYxMjY1MTEuNzkxNDc2LCJuYmYiOjE2ODYxMjY1MTEuNzkxNDgxLCJleHAiOjE3MTc3NDg5MTEuNzczMjE4LCJzdWIiOiI1Iiwic2NvcGVzIjpbXX0.R6_pNkfP_tbzdV0J9grl1nPXrjjaaBriTIyKSEvfFoFgupAGNSBZm7Z1e7yRsDowh5PWpXs5eHGBBvD06S1sh9YgF5kE9j4JopVntNgG1Ksnugn6UXQXIW2el5jAWRAQCH_MKByrkw3ktZ1_PGz7gsnmC0PWGI53YtEN3cOleU26e9EiHAS5-8uaU7mwQGlU8C_SGF7rS--QsX9_PX3eRWekJ9ssPkysdabZRWeD1WD4xEJUMuG7x_8vckF4k6zsiykJa43ZCRxAQmqJ81rma1leBZ8Li9wtkk3u5lrmPGq1NI3CZB0PMaC0koH2MyiZvAsM-zB_LaALpkLxpWuPR1xu1UxF7LKfFJ8Qw-2Bnelblh1hdu5Iie5vEVQsV2n6kjXNCPLRRaKYEZIWixAyOZQkJiunyuCskgfcPaBZLLMCPZ80by9OoMhPQTMI1FmSJU6gEse8YuN-P33F4TE9QKcCkUh8ATSUeOUN65auQ2h-cEnACxcB2O5k90ohyISDvBQrUp3EN32OLuJHJUWchISGtVvAhL9Ui5iwXDNrnPMQVqMHpHANwK90jpBQ68t8vwmAoKY_pvVDmnzRdx2CwPEtgNfvyXP6k5lUsi6BsFyKJ83mqOMPdF8XbotN0bpyWOA6tw14lR-SHS3IeIk0doMbqAiseuHlZqzaFQ6Uaa0",
     *    "user": {
     *        "name": "Shilpi Chaki",
     *        "email": "shilpi@yopmail.com",
     *        "gender": "Male",
     *        "phone": "7485968600",
     *        "status": 1,
     *        "updated_at": "2023-06-07T08:28:31.000000Z",
     *        "created_at": "2023-06-07T08:28:31.000000Z",
     *        "id": 5
     *   }
     *  }
     * }
     *
     * @response 401 {
     *  "status": false,
     * "statusCode": 401,
     * "error": "Email id & password was invalid!"
     * }
     *
     */


     public function register(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|numeric|min:10|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'type' => 'required',
            'age' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false, 'error' => $validator->errors()->first(), 'statusCode'=> 201], 201);
        }

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->gender = $request->gender;
            $user->phone = $request->phone;
            $user->age = $request->age;
            $user->status = 1;
            $user->save();
            // $user->assignRole('PATIENT');
            if ($request->type == 'Doctor') {
                $user->assignRole('DOCTOR');
            } else {
                $user->assignRole('PATIENT');
            }
            $data['auth_token'] = $user->createToken('accessToken')->accessToken;
            $data['user'] = $user->makeHidden('roles');
            return response()->json(['status' => true, 'statusCode' => 200, 'data' => $data], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'statusCode' => 500, 'error' => $th->getMessage()], 500);
        }
    }

}
