<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\HelpAndSupport;
use App\Models\PrivacyPolicy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @groupMedical Staff Settings
 */

class SettingsController extends Controller
{
    public $successStatus = 200;

    /**
     * Privacy Policy
     * @response 200{
     *  "status": true,
     * "data": {
     *     "id": 1,
     *     "content": "Why do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).",
     *     "created_at": "2023-06-28T09:40:56.000000Z",
     *     "updated_at": "2023-06-28T09:45:32.000000Z"
     * }
     * }
     */

    public function privacyPolicy(Request $request)
    {
        try {
            $privacyPolicy = PrivacyPolicy::first();
            return response()->json(['status' => true, 'data' => $privacyPolicy], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     *  About Us
     * @response 200{
     * "status": true,
     * "data": {
     *     "id": 1,
     *     "content": "Lorem ipsum dolor sit amet consectetur. Pharetra netus cursus nec facilisis. Quis ultrices morbi maecenas lobortis. Mattis sed nisi amet nisi elit nunc nibh in. Ac convallis fringilla tortor morbi vel massa et et. Elementum pellentesque quis nunc elit. Urna pellentesque venenatis egestas ac neque a. Consequat mi at quis sed tincidunt leo sed sit. Pretium mauris imperdiet ornare nunc ut enim. Erat viverra urna sed quis et varius lectus ipsum mollis. Ullamcorper pellentesque lectus sed tellus fames dolor turpis nibh pharetra. Aliquam tortor nascetur nec neque porttitor molestie quis non arcu. Pretium lectus eu vitae diam sapien pellentesque nisl. Euismod auctor arcu cras facilisi tortor facilisis consectetur.\r\n\r\n        Amet ultrices augue lorem iaculis tortor massa velit. Phasellus sapien non ac tortor convallis fringilla. Sapien massa nunc aliquam platea pulvinar morbi dictum. Quis eget at magna sem mi dui elit. Nisl leo facilisis faucibus non posuere enim senectus. Lorem volutpat ante mollis pulvinar nibh tristique eu. Neque malesuada enim tellus tristique sem senectus ornare pharetra. Ipsum est a bibendum pretium viverra cras turpis massa.\r\n\r\n        Neque id tristique auctor accumsan dolor lorem praesent volutpat cras. Id auctor in tempor egestas ornare faucibus. Viverra nisi quis lacinia lorem sed tellus mattis aliquet. Sed nam nulla sit eu feugiat nisi elementum urna laoreet. Nulla sit interdum amet nisl et. Fames senectus cursus ullamcorper varius feugiat.",
     *     "created_at": "2023-06-28T09:26:19.000000Z",
     *     "updated_at": "2023-06-28T09:35:58.000000Z"
     * }
     * }
     *
     */

    public function aboutUs(Request $request)
    {
        try {
            $aboutUs = AboutUs::first();
            return response()->json(['status' => true, 'data' => $aboutUs], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     *  Help and Support
     * @bodyParam subject string required
     * @bodyParam message string required
     *  @response 200{
     * "status": true,
     * "data": {
     * "id": 1,
     * "user_id": 1,
     * "name": "test doctor",
     * "email": "test@yopmail.com",
     * "phone": "1234567890",
     * "subject": "test",
     * "message": "test",
     * "created_at": "2021-09-28T10:20:00.000000Z",
     * "updated_at": "2021-09-28T10:20:00.000000Z"
     * }
     * }
     *
     */

    public function helpAndSupport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'statusCode' => 201, 'message' => $validator->errors()->first()], 201);
        }

        try {
            $helpAndSupport = new HelpAndSupport();
            $helpAndSupport->user_id = auth()->user()->id;
            $helpAndSupport->name = auth()->user()->name;
            $helpAndSupport->email = auth()->user()->email;
            $helpAndSupport->phone = auth()->user()->phone ?? '';
            $helpAndSupport->message = $request->message;
            $helpAndSupport->subject = $request->subject;
            $helpAndSupport->save();
            return response()->json(['status' => true, 'data' => $helpAndSupport], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Delete Account
     * @response 200{
     * "status": true,
     * "message": "Account deleted successfully."
     * }
     */

    public function deleteAccount(Request $request){
        try {
            User::find($request->user()->id)->delete();
            return response()->json(['status' => true, 'message' => 'Account deleted successfully.'], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
