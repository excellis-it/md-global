<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialization;
use App\Models\Specialization;
use App\Models\User;
use App\Traits\ImageTrait;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @group  Patient Profile
 */
class ProfileController extends Controller
{
    use ImageTrait;
    public $sucessStatus = 200;

    /**
     * Get Patient Profile
     * @authenticated
     * @response 200{
     *   "status": true,
     *  "statusCode": 200,
     *  "message": "Profile fetched successfully",
     *  "data": {
     *      "id": 3,
     *      "name": "John Doe",
     *      "gender": "Male",
     *      "age": "2008-01-26",
     *      "email": "john@yopmail.com",
     *      "phone": "8596769586",
     *      "profile_picture": "patient/07y44Yk7Fgs2DF7v5ErJtbwceKDFIlLpP3mrYkn6.jpg",
     *      "status": 1
     *  }
     * }
     */

    public function getProfile(Request $request)
    {
        $user = User::where('id', auth()->user()->id)->select('id', 'name', 'gender', 'age', 'email', 'phone', 'profile_picture', 'status')->first();
        return response()->json([
            'status' => true,
            'statusCode' => $this->sucessStatus,
            'message' => 'Profile fetched successfully',
            'data' => $user
        ]);
    }



    /**
     * Update Patient Profile
     * @authenticated
     * @response 200{
     *"status": true,
     * "statusCode": 200,
     * "message": "Profile fetched successfully",
     * }
     * @bodyParam name string optional The name of the Patient.
     * @bodyParam email string optional The email of the Patient.
     * @bodyPara  gender string optional. Example: Male, Female, Other.
     * @bodyParam age date optional The age of the Patient.
     * @bodyParam phone numeric optional The phone of the Patient.
     *
     * @response 201{
     * "error": "The email has already been taken."
     * }
     * @response 201{
     * "error": "The phone has already been taken."
     * }
     */

    public function updateProfile(Request $request)
    {

        $user = auth()->user();
        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->email) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(),'statusCode' => 201,'status'=>false], 201);
            }
            $user->email = $request->email;
        }

        if ($request->phone) {
            $validator = Validator::make($request->all(), [
                'phone' => 'required|numeric|unique:users,phone,' . $user->id,
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first(),'statusCode' => 201,'status'=>false], 201);
            }
            $user->phone = $request->phone;
        }
        if ($request->gender) {
            $user->gender = $request->gender;
        }

        if ($request->age) {
            $user->age = $request->age;
        }
        $user->save();

        return response()->json([
            'status' => true,
            'statusCode' => $this->sucessStatus,
            'message' => 'Profile updated successfully',
        ]);
    }

    /**
     *  Upload profile image
     * @authenticated
     * @bodyParam profile_picture file required The profile_picture of the Patient.
     * @response 200{
     *"status": true,
     * "statusCode": 200,
     * "message": "Profile updated successfully"
     * }
     * @response 201{
     * "error": "The profile_picture filled is required."
     * }
     */

    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(),'statusCode' => 201,'status'=>false], 201);
        }

        try {
            $user = auth()->user();
            $user->profile_picture = $this->imageUpload($request->profile_picture, 'patient');
            $user->save();

            return response()->json([
                'status' => true,
                'statusCode' => $this->sucessStatus,
                'message' => 'Profile updated successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Change Password
     * @authenticated
     * @bodyParam current_password string required The old_password of the Patient.
     * @bodyParam new_password string required The password of the Patient.
     * @bodyParam confirm_password string required The password_confirmation of the Patient.
     * @response 200{
     *"status": true,
     * "statusCode": 200,
     * "message": "Password changed successfully"
     * }
     *
     * @response 201{
     * "error": "The old_password and password must be different."
     * }
     */

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|min:8|current_password|different:new_password|different:confirm_password',
            'new_password' => 'required|min:8|different:current_password|same:confirm_password',
            'confirm_password' => 'required|min:8|different:current_password|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first(),'statusCode' => 201,'status'=>false], 201);
        }

        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->password = bcrypt($request->new_password);
            $user->save();
            $data =  fractal($user, new UserTransformer())->toArray()['data'];
            return response()->json([
                'status' => true,
                'statusCode' => $this->sucessStatus,
                'message' => 'Password changed successfully',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
