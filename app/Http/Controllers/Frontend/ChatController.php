<?php

namespace App\Http\Controllers\Frontend;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\ChatRequestEvent;
use App\Models\Friends;

class ChatController extends Controller
{
    public function userChat(Request $request)
    {
        try {
            // count chat
            $sender_id = $request->sender_id;
            $reciver_id = $request->reciver_id;
            $chat_count = Chat::where(function ($query) use ($request) {
                $query->where('sender_id', $request->sender_id)->where('reciver_id', $request->reciver_id);
            })->orWhere(function ($query) use ($request) {
                $query->where('sender_id', $request->reciver_id)->where('reciver_id', $request->sender_id);
            })->count();

            $chatData = Chat::create([
                'sender_id' => $request->sender_id,
                'reciver_id' => $request->reciver_id,
                'message' => $request->message
            ]);
            // get chat data with sender and reciver
            $chat = Chat::with('sender', 'reciver')->find($chatData->id);
            $user = User::find(Auth::user()->id);
            if ($user->hasRole('PATIENT')) {
                $friends = Friends::where('user_id', $request->reciver_id)->where('status', 1)->with('friend')->get()->toArray();
                $friends = array_map(function ($user) use ($reciver_id) {
                    $user['last_message'] = Chat::where(function ($query) use ($user, $reciver_id) {
                        $query->where('sender_id', $user['friend_id'])->where('reciver_id', $reciver_id);
                    })->orWhere(function ($query) use ($user , $reciver_id) {
                        $query->where('sender_id', $reciver_id)->where('reciver_id', $user['friend_id']);
                    })->orderBy('created_at', 'desc')->first();

                    return $user;
                }, $friends);
            } else {
                $friends = Friends::where('user_id', Auth::user()->id)->where('status', 1)->with('friend')->get()->toArray();
                $friends = array_map(function ($user) {
                    $user['last_message'] = Chat::where(function ($query) use ($user) {
                        $query->where('sender_id', $user['friend_id'])->where('reciver_id', auth()->id());
                    })->orWhere(function ($query) use ($user) {
                        $query->where('sender_id', auth()->id())->where('reciver_id', $user['friend_id']);
                    })->orderBy('created_at', 'desc')->first();

                    return $user;
                }, $friends);
            }

            // dd($friends);
            // return user orderBy latest message


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

            if ($user->hasRole('PATIENT')) {
                $reciver_users = Friends::where('user_id', $request->reciver_id)->where('status', 1)->with('friend')->get()->toArray();

                // Sort users based on the latest message
                $reciver_users = array_map(function ($user) use ($reciver_id) {
                    $user['last_message'] = Chat::where(function ($query) use ($user, $reciver_id) {
                        $query->where('sender_id', $user['friend_id'])->where('reciver_id', $reciver_id);
                    })->orWhere(function ($query) use ($user , $reciver_id) {
                        $query->where('sender_id', $reciver_id)->where('reciver_id', $user['friend_id']);
                    })->orderBy('created_at', 'desc')->first();

                    return $user;
                }, $reciver_users);
            } else {
                $reciver_users = Friends::where('friend_id', $request->reciver_id)->where('status', 1)->with('user')->get()->toArray();

                $reciver_users = array_map(function ($user) {
                    $user['last_message'] = Chat::where(function ($query) use ($user) {
                        $query->where('sender_id', $user['user_id'])->where('reciver_id', auth()->id());
                    })->orWhere(function ($query) use ($user) {
                        $query->where('sender_id', auth()->id())->where('reciver_id', $user['user_id']);
                    })->orderBy('created_at', 'desc')->first();

                    return $user;
                }, $reciver_users);
            }


            usort($reciver_users, function ($a, $b) {
                if ($a['last_message'] === null) {
                    return 1; // Move users with no messages to the end
                }
                if ($b['last_message'] === null) {
                    return -1; // Move users with no messages to the end
                }

                return $b['last_message']->created_at <=> $a['last_message']->created_at; // Sort by latest message timestamp
            });


            return response()->json(['msg' => 'Message sent successfully', 'chat' => $chat, 'success' => true, 'chat_count' => $chat_count, 'friends' => $friends, 'reciver_users' => $reciver_users]);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage(), 'success' => false]);
        }
    }

    public function sendChatRequest(Request $request)
    {
        try {
            if ($request->ajax()) {
                // return $request->all();
                // check if chat request already sent
                $chatRequest = Friends::where('friend_id', $request->sender)->where('status', 0)->where('user_id', $request->recipient)->first();
                if ($chatRequest) {
                    return response()->json(['status' => false, 'message' => 'Chat request already sent.']);
                }

                $countFriends = Friends::where('user_id', $request->recipient)->where('friend_id', $request->sender)->count();
                if ($countFriends > 0) {
                    $chat = Friends::where('user_id', $request->recipient)->where('friend_id', $request->sender)->update(['status' => 0]);
                } else {
                    $chat = Friends::create([
                        'user_id' => $request->recipient, // recipient
                        'friend_id' => $request->sender, // sender
                        'status' => 0
                    ]);
                }


                $friendRequest = Friends::with('user', 'friend')->where('friend_id', $request->sender)->latest()->first();
                // pending chat request count
                $pendingChatRequest = Friends::where('friend_id', $request->sender)->where('status', 0)->count();
                return response()->json(['status' => true, 'message' => 'Chat request sent successfully.', 'pendingChatRequest' => $pendingChatRequest, 'friendRequest' => $friendRequest]);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }
}
