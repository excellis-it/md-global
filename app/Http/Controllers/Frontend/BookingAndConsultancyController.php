<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\ThankYouMail;
use App\Models\Appointment;
use App\Models\Chat;
use App\Models\ClinicDetails;
use App\Models\Slot;
use App\Models\User;
use App\Models\UserMembership;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class BookingAndConsultancyController extends Controller
{
    public function bookingAndConsultancy($id)
    {
        // return date('Y-m-d', strtotime('+' . 7 . 'days'));
        $id = decrypt($id);
        $doctor = User::find($id);
        // get clinics within 10km radius
        $latitude = Auth::user()->locations->latitude;
        $longitude = Auth::user()->locations->longitude;
        $radius = 10;
        $clinics = ClinicDetails::where('user_id', $id)->select('id', 'user_id', 'clinic_name', 'clinic_address', 'clinic_phone', 'longitute', 'latitute', DB::raw('( 6371 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitute ) ) * cos( radians( longitute ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitute ) ) ) ) AS distance'))->having('distance', '<', $radius)->get();
        // dd($clinics);
        return view('frontend.booking-and-consultancy')->with(compact('doctor', 'clinics'));
    }

    public function doctorChat(Request $request)
    {
        try {
            if ($request->ajax()) {
                if (Auth::check() && Auth::user()->membership_status == true) {
                    $userMembership = UserMembership::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('membership_expiry_date', '>=', date('Y-m-d'))->first();
                    if ($userMembership) {
                        $chat_call = 1;
                        $chats = Chat::where(function ($query) use ($request) {
                            $query->where('sender_id', Auth::user()->id)->where('reciver_id', $request->doctor_id);
                        })->orWhere(function ($query) use ($request) {
                            $query->where('sender_id', $request->doctor_id)->where('reciver_id', Auth::user()->id);
                        })->get();
                        $doctor = User::find($request->doctor_id);
                        $chat_count = count($chats);
                        $friendRequestStatus = Auth::user()->friendsRequest->where('user_id', $request->doctor_id)->first()['status'] ?? '' ;
                        // dd($friendRequestStatus);
                        return response()->json(['message'=>'Show Chat', 'status'=>true,'chat_count'=>$chat_count,'view' => (string)View::make('frontend.chat')->with(compact('chats','chat_call','doctor','chat_count','friendRequestStatus'))]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Your membership has been expired.']);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'You are not a member.']);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    public function visitSlotAjax(Request $request)
    {
        if ($request->ajax()) {
            $clinic_details = ClinicDetails::with(array('clinic_slots' => function ($query) {
                $query->where('slot_date', '>=', date('Y-m-d'))->take(9);
            }))->where('id', $request->clinic_id)->first();
            return response()->json(['view' => (string)View::make('frontend.ajax-clinic-visit')->with(compact('clinic_details'))]);
        }
    }

    public function clinicVisitSlotAjax(Request $request)
    {
        if ($request->ajax()) {
            $slot_times = Slot::where('id', $request->slot_id)->first();
            return response()->json(['view' => (string)View::make('frontend.ajax-clinic-visit-slot-time')->with(compact('slot_times'))]);
        }
    }

    public function storeAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'clinic_id' => 'required',
            'appointment_date' => 'required',
            'appointment_time' => 'required',
            // Add other validation rules for your fields
        ], [
            'clinic_id.required' => 'Please Select Service Centers for booking slot.',
            'appointment_date.required' => 'Please Select Appointment Date for booking slot.',
            'appointment_time.required' => 'Please Select Appointment Time for booking slot.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $count = Appointment::where(['user_id' => Auth::user()->id, 'appointment_date' => $request->appointment_date, 'appointment_status' => 'Done'])->count();
        if ($count > 0) {
            return redirect()->back()->with('error', 'You have already booked a appointment in this date !!');
        }

        $clinic_details = ClinicDetails::where('id', $request->clinic_id)->first();

        $appointment = new Appointment();
        $appointment->user_id  = Auth::User()->id;
        $appointment->doctor_id  = $request->doctor_id;
        $appointment->clinic_id  = $request->clinic_id;
        $appointment->appointment_id = rand(000000, 999999);
        $appointment->appointment_date  = $request->appointment_date;
        $appointment->appointment_time  = $request->appointment_time;
        $appointment->appointment_status = 'Done';
        $appointment->booking_time  = Carbon::now();
        $appointment->clinic_name  = $clinic_details->clinic_name;
        $appointment->clinic_address = $clinic_details->clinic_address;
        $appointment->clinic_phone = $clinic_details->clinic_phone;
        $appointment->save();
        Session::put('remember', 1);
        $body = [
            'appointment' => $appointment
        ];
        $email = Auth::user()->email;
        Mail::to($email)->send(new ThankYouMail($body));
        return redirect()->route('thank-you')->with('message', 'Appointment booked successfully!');
    }

    public function thankYou()
    {
        return view('frontend.thanks');
    }

    public function createChat(Request $request)
    {
        $input = $request->all();
        $message = $input['message'];

        $chat = new Chat([
            'sender_id' => Auth::user()->id,
            'reciver_id' => $input['reciver_id'],
            'message' => $input['message']
        ]);

        $chat->save();

        return redirect()->back();
    }
}
