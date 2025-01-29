<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    protected $notifications;

    public function __construct(Notification $notifications) {
        $this->notifications = $notifications;
    }

    
    public function notifications(Request $request)
    {
        $notifications = $this->notifications->where('send_to', 'Patient')->orWhere('send_to', 'All')->orderBy('id','desc')->paginate(5);

        if ($request->ajax()) {
            // return view('frontend.patient.partials.message')->with(compact('notifications'))->render();
            return view('frontend.doctor.partials.message', ['notifications' => $notifications])->render();  
        }

        return view('frontend.doctor.notifications')->with(compact('notifications'));
    }
}
