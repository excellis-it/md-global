<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\VideoCallDetails;
use App\Models\VideoCallPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Patient Video Calling
 */
class VideoCallingController extends Controller
{
    protected $successStatus = 200;

    public function showRequest(Request $request)
    {

        /**
         * Check video call requst is created or not
         * @response 200{
         *"status": true,
         *  "message": "Metting created successfully",
         *  "start_url": {
         *      "id": 40,
         *      "sender_id": 4,
         *      "receiver_id": 3,
         *      "meeting_id": "81211397496",
         *      "start_url": "https://us05web.zoom.us/s/81211397496?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6InI2eVpFNVBQUnVHZE5wWEluUGVMeWciLCJpc3MiOiJ3ZWIiLCJzayI6IjM5MTg1MDQ1NjAyMDA5NjEyNDUiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTIxMTM5NzQ5NiIsImV4cCI6MTY5OTYxNzIwNSwiaWF0IjoxNjk5NjEwMDA1LCJhaWQiOiJJWHhJcG10LVJOYVRmT0ZDR1R3OHNnIiwiY2lkIjoiIn0.HCAG29EStdpzj2MtWFBN4wcFvi64nNSGXIdUdmS1DbE",
         *      "join_url": "https://us05web.zoom.us/j/81211397496?pwd=DOa4DEKfxOCQw2Em6aSPdGpSYlsbqh.1",
         *      "created_at": "2023-11-10T09:53:25.000000Z",
         *      "updated_at": "2023-11-10T09:53:25.000000Z",
         *      "price": "200"
         *  }
         * }
         * @response 201{
         * "status": false,
         * "message": "Metting not created"
         * }
         */
        try {
            // get the video call details what is created 5 sec ago
            $videoCallDetails = VideoCallDetails::where('receiver_id', Auth::user()->id)->where('created_at', '>=', now()->subSeconds(5))->orderBy('created_at', 'desc')->first();
            if ($videoCallDetails) {
                $videoCallDetails['price'] = VideoCallPrice::first()->price;
                return response()->json([
                    'status' => true,
                    'message' => 'Metting created successfully',
                    'start_url' => $videoCallDetails,
                ], $this->successStatus);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Metting not created',
                ], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     *  Video Payment Api
     * @bodyParam videocall_id integer required
     * @bodyParam payment_id string required
     * @bodyParam response json required
     * @response {
     * "status": true,
     * "message": "Payment successfully",
     * "join_url": "https://us05web.zoom.us/j/81211397496?pwd=DOa4DEKfxOCQw2Em6aSPdGpSYlsbqh.1"
     * }
     *
     * @response 201{
     * "status": false,
     * "message": "The videocall id field is required."
     * }
     */

    public function videoPayment(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'videocall_id' => 'required|exists:video_call_details,id',
            'payment_id' => 'required',
            'response' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 201);
        }
        try {
            $videoCallPrice = VideoCallPrice::first();
            $video = VideoCallDetails::find($request->videocall_id);

            $payment = new Payment();
            $payment->patient_id = Auth::user()->id;
            $payment->doctor_id = $video->sender_id;
            $payment->amount = $videoCallPrice->price;
            $payment->meeting_id = $video->meeting_id;
            $payment->payment_id = $request->payment_id;
            $payment->currency = 'usd';
            $payment->payment_response = json_encode($request->response);
            $payment->start_url = $video->start_url;
            $payment->join_url = $video->join_url;
            $payment->call_duration = '30';
            $payment->save();

            return response()->json([
                'status' => true,
                'message' => 'Payment successfully',
                'join_url' => $video->join_url,
            ], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
