<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Events\ZoomRequestEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VideoCallDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jubaer\Zoom\Zoom;

/**
 * @groupMedical Staff Video Calling
 */
class VideoCallingController extends Controller
{
    protected $successStatus = 200;

    /**
     * Send Video Request
     * @bodyParam reciver_id integer required
     * @response {
     * {
     *     "status": true,
     *     "message": "Metting created successfully",
     *     "start_url": "https://us05web.zoom.us/s/89209152434?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InI2eVpFNVBQUnVHZE5wWEluUGVMeWciLCJpc3MiOiJ3ZWIiLCJzayI6IjM5MTg1MDQ1NjAyMDA5NjEyNDUiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTIwOTE1MjQzNCIsImV4cCI6MTY5OTYxMzU4NCwiaWF0IjoxNjk5NjA2Mzg0LCJhaWQiOiJJWHhJcG10LVJOYVRmT0ZDR1R3OHNnIiwiY2lkIjoiIn0.fFz0IUs9Tt64ec3ytltR6Hmi2fjB6B_ggrvEnZPqRnY"
     *   }
     * }
     */

    public function sendVideoRequest(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'reciver_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 201);
        }
        try {
            $reciver_id = $request->reciver_id;
            $sender_id = Auth::user()->id;

            $metting = Zoom::createMeeting([
                "agenda" => 'Video Calling',
                "topic" => 'Video Calling',
                "type" => 2, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
                "duration" => 30, // in minutes
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
                $videocall->receiver_id = $reciver_id;
                $videocall->meeting_id = $metting['data']['id'];
                $videocall->start_url = $metting['data']['start_url'];
                $videocall->join_url = $metting['data']['join_url'];
                $videocall->save();

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
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
