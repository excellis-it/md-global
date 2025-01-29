<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

/**
 * @group  Patient Notification
 */
class NotificationController extends Controller
{
    private $successStatus = 200;

    /**
     * Get Patient Notification
     * @authenticated
     * @response 200{
     *  "status": true,
     *"data": [
     *    {
     *        "id": 5,
     *        "send_to": "Patient",
     *        "message": "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
     *        "created_at": "2023-06-26T10:51:59.000000Z",
     *        "updated_at": "2023-06-26T10:51:59.000000Z"
     *    },
     *]
     * }
     */
    public function notifications(Request $request)
    {
        try {
            $notifications = Notification::where('send_to', 'patient')->orderBy('id', 'desc')->get();
            return response()->json(['status' => true, 'data' => $notifications], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
