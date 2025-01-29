<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Friends;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @groupMedical Staff Chat
 */
class ChatController extends Controller
{
    public $successStatus = 200;

    /**
     *Medical Staff Chat Request
     * @authenticated
     * @response 200{
     * "status": true,
     * "message": "Chat Request List",
     * "data": [
     *     {
     *         "id": 2,
     *         "profile_picture": null,
     *         "gender": "Male",
     *         "name": "Chatrapati Shivaji",
     *         "age": "1978-10-10"
     *     }
     *   ]
     * }
     *
     */

    public function requestList(Request $request)
    {
        try {
            $chat_request_array = Auth::user()->friends()->where('status', 0)->pluck('friend_id')->toArray();
            $chat_requests = User::whereIn('id', $chat_request_array)->select('id', 'profile_picture', 'gender', 'name', 'age')->get();
            return response()->json([
                'status' => true,
                'message' => 'Chat Request List',
                'data' => $chat_requests
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
     *Medical Staff Chat Request Accept
     * @authenticated
     * @bodyParam friend_id integer required
     * @response 200{
     * "status": true,
     * "message": "Chat Request Accepted",
     * "data": []
     * }
     */

    public function requestAccept(Request $request)
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
            $friend = Friends::with('user', 'friend')->where('friend_id', $request->friend_id)->where('user_id', Auth::user()->id)->where('status', 0)->first();
            if ($friend) {
                $friend->status = 1;
                $friend->save();

                $chat = Chat::create([
                    'sender_id' => $friend->user_id,
                    'reciver_id' => $friend->friend_id,
                    'message' =>  $friend->user->name . ' accepted your chat request.'
                ]);
                $chat = Chat::with('sender', 'reciver')->find($chat->id);

                return response()->json([
                    'status' => true,
                    'message' => 'Chat Request Accepted',
                    'data' => []
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Chat Request Not Found',
                    'error' => 'Chat Request Not Found'
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
     *Medical Staff Chat Request Reject
     * @authenticated
     * @bodyParam friend_id integer required
     * @response 200{
     * "status": true,
     * "message": "Chat Request Rejected",
     * "data": []
     * }
     */

    public function requestReject(Request $request)
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

            $friend = Friends::where('friend_id', $request->friend_id)->where('user_id', Auth::user()->id)->where('status', 0)->first();
            if ($friend) {
                $friend->status = 2;
                $friend->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Chat Request Rejected',
                    'data' => []
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Chat Request Not Found',
                    'error' => 'Chat Request Not Found'
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
     *Medical Staff Chat
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
     * Friend List
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
     *           "friend": {
     *               "id": 3,
     *               "name": "John Does",
     *               "email": "john@yopmail.com",
     *               "phone": "8596769586",
     *               "email_verified_at": null,
     *               "profile_picture": "patient/NJr51HG9dfGvIIfpJVSuHgI7Ps4NkQJdOPLWqSLy.jpg",
     *               "year_of_experience": null,
     *               "license_number": null,
     *               "location": "Kolkata",
     *               "gender": "Male",
     *               "age": "2000-01-06",
     *               "fcm_token": "eyo_Z9a_EQkcwF1y_TjA-U:APA91bFvEyoQw3XaMNheNcHlQMQISc-sB2b3RWySS515RaMauTX1RCKrinBcf5-4FhZeLtoB-BYV4K0khjO8pD1ZTi257s3A6_sH36SZGN4tBdS1AlUo3L2sBaXKpZoI0gwq-MWETDfN",
     *               "status": 1,
     *               "deleted_at": null,
     *               "created_at": "2023-05-30T04:51:16.000000Z",
     *               "updated_at": "2023-09-05T08:47:47.000000Z"
     *           }
     *       }
     *   ]
     * }
     */

    public function friends(Request $request)
    {
        try {
            $friends = Friends::where('user_id', Auth::user()->id)->where('status', 1)->with('friend')->get()->toArray();
            // dd($friends);
            // return user orderBy latest message
            $friends = array_map(function ($user) {
                $user['last_message'] = Chat::where(function ($query) use ($user) {
                    $query->where('sender_id', $user['friend_id'])->where('reciver_id', auth()->id());
                })->orWhere(function ($query) use ($user) {
                    $query->where('sender_id', auth()->id())->where('reciver_id', $user['friend_id']);
                })->orderBy('created_at', 'desc')->first();

                return $user;
            }, $friends);

            // Sort users based on the latest message
            usort($friends, function ($a, $b) {
                if ($a['last_message'] === null) {
                    return 1; // Move users with no messages to the end
                }
                if ($b['last_message'] === null) {
                    return -1; // Move users with no messages to the end
                }

                return $b['last_message']->created_at <=> $a['last_message']->created_at; // Sort by latest message timestamp
            });

            // dd($friends);

            $requests = Friends::where('user_id', Auth::user()->id)->where('status', 0)->with('friend')->get();

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
}
