<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

/**
 * @groupMedical Staff Notification
 */
class NotificationController extends Controller
{
    public $successStatus = 200;

    /**
     * Get Notification
     *
     * @response 200{
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "send_to": "doctor",
     * "message": "Your appointment is booked with patient name: test patient",
     * "created_at": "2021-09-28T10:20:00.000000Z",
     * "updated_at": "2021-09-28T10:20:00.000000Z"
     * },
     * {
     * "id": 2,
     * "send_to": "doctor",
     * "message": "Your appointment is booked with patient name: test patient",
     * "created_at": "2021-09-28T10:20:00.000000Z",
     *  "updated_at": "2021-09-28T10:20:00.000000Z"
     * }
     * ]
     * }
     *
     *
     */

    public function notifications(Request $request)
    {
        try {
            $notifications = Notification::where('send_to', 'doctor')->orderBy('id', 'desc')->get();
            return response()->json(['status' => true, 'data' => $notifications], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
