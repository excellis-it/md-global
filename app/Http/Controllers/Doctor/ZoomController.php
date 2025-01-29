<?php

namespace App\Http\Controllers\Doctor;

use App\Events\ZoomRequestEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VideoCallDetails;
use App\Models\ZoomCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Jubaer\Zoom\Zoom;

class ZoomController extends Controller
{
    public function zoomSetting()
    {
        return view('frontend.doctor.zoom.create');
    }

    public function zoomCrdentialUpdate(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'client_secret' => 'required',
            'account_id' => 'required',
        ]);

        $user = ZoomCredential::where('user_id', auth()->user()->id)->first();
        if (!$user) {
            $user = new ZoomCredential();
            $user->user_id = auth()->user()->id;
        }
        $user->client_id = $request->client_id;
        $user->client_secret = $request->client_secret;
        $user->account_id = $request->account_id;
        $user->save();

        return redirect()->back()->with('message', 'Zoom credential updated successfully');
    }

    public function videoCall(Request $request)
    {
        try {
            if ($request->ajax()) {
                $receiver_id = $request->receiver_id;
                $sender_id = $request->sender_id;

                $metting = Zoom::createMeeting([
                    "agenda" => 'Video Calling',
                    "topic" => 'Video Calling',
                    "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
                    "duration" => 2, // in minutes
                    "timezone" => 'UTC', // set your timezone
                    "password" => '',
                    "pre_schedule" => false,  // set true if you want to create a pre-scheduled meeting
                    // "schedule_for" => 'azharuddin@excellisit.net', // set your schedule for
                    "settings" => [
                        'join_before_host' => false, // if you want to join before host set true otherwise set false
                        'host_video' => false, // if you want to start video when host join set true otherwise set false
                        'participant_video' => false, // if you want to start video when participants join set true otherwise set false
                        'mute_upon_entry' => false, // if you want to mute participants when they join the meeting set true otherwise set false
                        'waiting_room' => false, // if you want to use waiting room for participants set true otherwise set false
                        'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
                        'auto_recording' => 'none', // values are 'none', 'local', 'cloud'. default is none.
                        'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
                    ],

                ]);
                // return $metting;
                $sender_details = User::where('id', $sender_id)->first();
                $sender_profile_picture =  ($sender_details->profile_picture) ? Storage::url($sender_details->profile_picture) : asset('frontend_assets/images/profile.png');
                if ($metting) {
                    $videocall = new VideoCallDetails();
                    $videocall->sender_id = $sender_id;
                    $videocall->receiver_id = $receiver_id;
                    $videocall->meeting_id = $metting['data']['id'];
                    $videocall->start_url = $metting['data']['start_url'];
                    $videocall->join_url = $metting['data']['join_url'];
                    $videocall->save();

                    // event(new ZoomRequestEvent($videocall));
                    return response()->json([
                        'status' => true,
                        'message' => 'Metting created successfully',
                        'videocall' => $videocall,
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Metting not created',
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }
    }
}
