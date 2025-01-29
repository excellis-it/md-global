<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VideoCallPrice;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    public function openZoomModel(Request $request)
    {
        try {
            if ($request->ajax()) {
                $videocall_id = $request->videocall['id'];
                $doctor = User::where('id', $request->videocall['sender_id'])->first();
                $accept = true;
                return response()->json([
                    'view' => view('frontend.includes.accept-zoom-request-modal', compact('doctor', 'accept', 'videocall_id'))->render(), 'status' => true
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function openPayNowModel(Request $request)
    {
        try {
            if ($request->ajax()) {
                $videocall_id = $request->videocall_id;
                $videocall_price_id = $request->videocall_price_id;
                $videoCallPrice = VideoCallPrice::where('id', $videocall_price_id)->first();
                $accept = true;
                return response()->json([
                    'view' => view('frontend.includes.zoom-payment-modal', compact('videoCallPrice', 'accept', 'videocall_id'))->render(), 'status' => true
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
