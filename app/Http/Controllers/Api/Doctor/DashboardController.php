<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ClinicDetails;
use App\Models\ClinicOpeningDay;
use App\Models\Day;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
/**
 *  @groupMedical Staff Dashboard
 */
class DashboardController extends Controller
{
    public $successStatus = 200;

    /**
     *Medical Staff Dashboard
     * @authenticated
     * @response 200{
     * "status": true,
     * "message": "Dashboard",
     * "data": {
     * "chat_request_count": 0,
     * "booking_history_count": 0,
     * "clinic_count": 0,
     * "chat_request": []
     * }
     * }
     * @response 500{
     * "status": false,
     * "message": "Something went wrong",
     * "error": "..."
     * }
     */

    public function dashboard(Request $request)
    {
        try {
            $dashboard['chat_request_count'] = Auth::user()->friends()->where('status', 0)->count();
            $dashboard['booking_history_count'] = Auth::user()->doctorAppointments()->count();
            $dashboard['clinic_count'] = Auth::user()->clinicDetails()->count();
            $chat_request_array = Auth::user()->friends()->where('status', 0)->pluck('friend_id')->toArray();
            $dashboard['chat_request'] = Auth::user()->whereIn('id', $chat_request_array)->select('id', 'name', 'profile_picture', 'age', 'gender')->get();
            return response()->json([
                'status' => true,
                'message' => 'Dashboard',
                'data' => $dashboard
            ], $this->successStatus);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $th->getMessage()
            ], 500);
        }
    }


}
