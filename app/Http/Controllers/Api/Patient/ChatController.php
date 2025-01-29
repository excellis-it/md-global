<?php

namespace App\Http\Controllers\Api\Patient;

use App\Events\ChatRequestEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Friends;
use App\Models\User;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @group Patient Chat
 */
class ChatController extends Controller
{
    private $successStatus = 200;

    /**
     * Chat Request api
     * @authenticated
     * @bodyParam doctor_id integer requiredMedical Staff Id. Example: 1
     * @response 200{
     *  "status": true,
     *  "message": "Friend request sent successfully",
     *  "data": {
     *      "id": 25,
     *      "user_id": 4,
     *      "friend_id": 3,
     *      "status": 1,  // 0 = pending, 1 = accepted, 2 = rejected
     *      "created_at": "2023-08-28T11:02:45.000000Z",
     *      "updated_at": "2023-08-28T13:12:02.000000Z"
     *  }
     * }
     */

    public function chatRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'statusCode' => 201, 'status' => false], 401);
        }

        try {
            $user = User::find(auth()->user()->id);
            $data = $user->friendsRequest()->where('user_id', $request->doctor_id)->first();
            if ($data) {
                return response()->json(['status' => true, 'message' => 'Friend request status fetch', 'data' => $data], $this->successStatus);
            } else {
                return response()->json(['status' => false, 'message' => 'No friend request found', 'data' => []], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Send Chat Request api
     * @authenticated
     * @bodyParam doctor_id integer requiredMedical Staff Id. Example: 1
     */

    public function chatRequestSend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'statusCode' => 201, 'status' => false], 401);
        }

        try {
            $countFriends = Friends::where('user_id', $request->doctor_id)->where('friend_id', Auth::user()->id)->count();


            if ($countFriends > 0) {
                $chat = Friends::where('user_id', $request->doctor_id)->where('friend_id', Auth::user()->id)->update(['status' => 0]);
            } else {
                $chat = Friends::create([
                    'user_id' => $request->doctor_id, // recipient
                    'friend_id' => Auth::user()->id, // sender
                    'status' => 0
                ]);
            }
            $friendRequest = Friends::with('user', 'friend')->where('friend_id', Auth::user()->id)->latest()->first();
            $pendingChatRequest = Friends::where('friend_id', Auth::user()->id)->where('status', 0)->count();

            return response()->json(['status' => true, 'message' => 'Friend request sent successfully', 'pendingChatRequest' => $pendingChatRequest, 'friendRequest' => $friendRequest], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Patient Chat
     * @authenticated
     * @bodyParam friend_id integer required
     * @response 200{
     * "status": true,
     *  "message": "Chat List",
     *  "data": [
     *      {
     *          "id": 12,
     *          "sender_id": "4",
     *          "reciver_id": "3",
     *          "message": "James Bond accepted your chat request.",
     *          "created_at": "2023-08-28T13:12:02.000000Z",
     *          "updated_at": "2023-08-28T13:12:02.000000Z"
     *      }
     *  ]
     * }
     *
     * @response 201{
     * "status": false,
     * "message": "Validation Error",
     * "error": {
     *    "friend_id": [
     *       "The friend id field is required."
     *   ]
     * }
     */

    public function chat(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'friend_id' => 'required|exists:users,id'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'error' => $validator->errors()
                ], 201);
            }
            $chat = Chat::where('sender_id', Auth::user()->id)->where('reciver_id', $request->friend_id)->orWhere('sender_id', $request->friend_id)->where('reciver_id', Auth::user()->id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Chat List',
                'data' => $chat
            ], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     *  Friend List
     * @authenticated
     * @response 200{
     * "status": true,
     *   "message": "Friend List",
     *   "data": [
     *       {
     *           "id": 25,
     *           "user_id": 4,
     *           "friend_id": 3,
     *           "status": 1,
     *           "created_at": "2023-08-28T11:02:45.000000Z",
     *           "updated_at": "2023-09-28T06:17:47.000000Z",
     *           "user": {
     *               "id": 4,
     *               "name": "Nicolas Bond",
     *               "email": "james@yopmail.com",
     *               "phone": "7485968695",
     *               "email_verified_at": null,
     *               "profile_picture": "doctor/ZwlPxPwI5mQsgrhFlrSwxeiZTQXS0JS5mDqaEX4b.jpg",
     *               "year_of_experience": "4",
     *               "license_number": "DKM-74859686",
     *               "location": "Kolkata, West Bengal, India",
     *               "gender": "Male",
     *               "age": "2000-02-10",
     *               "fcm_token": "eyo_Z9a_EQkcwF1y_TjA-U:APA91bFvEyoQw3XaMNheNcHlQMQISc-sB2b3RWySS515RaMauTX1RCKrinBcf5-4FhZeLtoB-BYV4K0khjO8pD1ZTi257s3A6_sH36SZGN4tBdS1AlUo3L2sBaXKpZoI0gwq-MWETDfN",
     *               "status": 1,
     *               "deleted_at": null,
     *               "created_at": "2023-06-06T08:40:43.000000Z",
     *               "updated_at": "2023-09-28T11:02:14.000000Z"
     *           }
     *       }
     *   ]
     * }
     *
     * @response 201{
     *  "status": false,
     * "message": "No friends found",
     * }
     */

    public function friends(Request $request)
    {
        try {
            $friends = Auth::user()->friendsRequest()->where('status', 1)->with('user')->get();
            if ($friends) {
                return response()->json([
                    'status' => true,
                    'message' => 'Friend List',
                    'data' => $friends
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'No friends found',
                    'data' => []
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Send Chat Request toMedical Staff
     * @authenticated
     */

    public function sendRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|exists:users,id'
        ]);
        try {
            $countFriends = Friends::where('user_id', $request->doctor_id)->where('friend_id', Auth::user()->id)->count();
            if ($countFriends > 0) {
                $chat = Friends::where('user_id', $request->doctor_id)->where('friend_id', Auth::user()->id)->update(['status' => 0]);
            } else {
                $chat = Friends::create([
                    'user_id' => $request->doctor_id, // recipient
                    'friend_id' => Auth::user()->id, // sender
                    'status' => 0
                ]);
            }


            $friendRequest = Friends::with('user', 'friend')->where('friend_id', Auth::user()->id)->latest()->first();
            $friendProfilePicture = ($friendRequest->friend->profile_picture) ? Storage::url($friendRequest->friend->profile_picture) : asset('frontend_assets/images/profile.png');

            return response()->json(['status' => true, 'message' => 'Friend request sent successfully', 'data' => $chat], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Chat permission api
     * @authenticated
     * @response 200{
     * "status": true,
     * "message": "You are a member."
     * }
     * @response 201{
     * "status": false,
     * "message": "Your membership has been expired."
     * }
     */

    public function permission(Request $request)
    {
        try {
            if (Auth::check() && Auth::user()->membership_status == true) {
                $userMembership = UserMembership::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('membership_expiry_date', '>=', date('Y-m-d'))->first();
                if ($userMembership) {
                    return response()->json(['status' => true, 'message' => 'You are a member.'], 200);
                } else {
                    return response()->json(['status' => false, 'message' => 'Your membership has been expired.'], 201);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'You are not a member.'], 201);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
