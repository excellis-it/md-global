<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\ContactPageCms;
use App\Models\ContactUs;
use App\Models\HomeContent;
use App\Models\Testimonial;
use App\Models\Service;
use App\Models\HomePage;
use App\Models\Plan;
use App\Models\Qna;
use App\Models\Location;
use App\Models\PrivacyPolicy;
use App\Models\TermsAndCondition;
use App\Models\VideoCallPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jubaer\Zoom\Zoom;

class CmsController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->get();
        $banners = HomePage::orderBy('id', 'desc')->where('type', 1)->get();
        $homeBodies = HomePage::orderBy('id', 'desc')->where('type', 2)->get();
        $homeContents = HomeContent::orderBy('id', 'desc')->first();
        $testimonial= Testimonial::orderBy('id','desc')->first();
        $service= Service::orderBy('id','desc')->get();
        return view('frontend.home')->with(compact('blogs', 'banners', 'homeBodies','homeContents','testimonial','service'));
    }

    public function aboutUs()
    {
        return view('frontend.about');
    }

    public function services()
    {
        $service = Service::orderBy('id', 'desc')->first();
        $services = Service::orderBy('id', 'desc')->get();
        $topService = Service::orderBy('id', 'desc')->take(5)->get();
        return view('frontend.services')->with(compact('services','topService','service'));
    }
    public function serviceDetails($service_slug)
    {
        $service = Service::where('slug', $service_slug)->first();
        $topService = Service::orderBy('id', 'desc')->take(5)->get();
        if (!$service) {
            abort(404);
        }
        return view('frontend.service-details')->with(compact('service', 'topService'));
    }

    public function contactUs()
    {
        $detail = ContactPageCms::first();
        return view('frontend.contact-us')->with(compact('detail'));
    }

    public function contactUsSubmit(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',
        ]);

        $contactUs = new ContactUs();
        $contactUs->first_name = $request->first_name;
        $contactUs->last_name = $request->last_name;
        $contactUs->email = $request->email;
        $contactUs->phone = $request->phone;
        $contactUs->message = $request->message;
        $contactUs->save();

        return redirect()->back()->with('message', 'Thank you for contacting us. We will get back to you soon.');
    }

    public function qna()
    {
        $qnas = Qna::where('status', true)->get();
        return view('frontend.qna')->with(compact('qnas'));
    }

    public function membershipPlans()
    {
        $plans = Plan::with('specifications')->orderBy('id', 'asc')->get();
        $video_call_prices = VideoCallPrice::orderBy('id', 'desc')->get();
        return view('frontend.membership-plans')->with(compact('plans', 'video_call_prices'));
    }

    public function mobileHealthCoverage()
    {
        return view('frontend.mobile-health-coverage');
    }

    public function storeLocation(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $location = new Location();
        if(auth()->check()) {
            $location->user_id = auth()->user()->id;
            $location->session_id = null;
        } else {
            $session_id = Session::getId();
            $location->user_id = null;
            $location->session_id = $session_id;
            $request->session()->put('session_id', $session_id);
        }
        $location->ip_address = $request->ip_address;
        $location->address = $request->address;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->save();


        $request->session()->put('latitude', $request->latitude);
        $request->session()->put('longitude', $request->longitude);
        $request->session()->put('address', $request->address);

        session()->flash('message', 'Location saved successfully');
        return response()->json(['success' => true]);
        // return response()->json(['session' => $request->session()->all()]);
    }

    public function privacyPolicy()
    {
        $privacyPolicy = PrivacyPolicy::where('type', 'Frontend')->first();
        return view('frontend.privacy-policy')->with(compact('privacyPolicy'));
    }

    public function termsAndConditions()
    {
        $terms = TermsAndCondition::where('type', 'Frontend')->first();
        return view('frontend.terms-and-conditions')->with(compact('terms'));
    }

    public function doctorTermsAndConditions()
    {
        $terms = TermsAndCondition::where('type', 'Doctor')->first();
        return view('frontend.doctor.terms-and-conditions')->with(compact('terms'));
    }

    public function doctorPrivacyPolicy()
    {
        $privacyPolicy = PrivacyPolicy::where('type', 'Doctor')->first();
        return view('frontend.doctor.privacy-policy')->with(compact('privacyPolicy'));
    }

    public function patientTermsAndConditions()
    {
        $terms = TermsAndCondition::where('type', 'Patient')->first();
        return view('frontend.patient.terms-and-conditions')->with(compact('terms'));
    }

    public function patientPrivacyPolicy()
    {
        $privacyPolicy = PrivacyPolicy::where('type', 'Patient')->first();
        return view('frontend.patient.privacy-policy')->with(compact('privacyPolicy'));
    }

    // public function meeting()
    // {
    //     $meetings = Zoom::createMeeting([
    //         "agenda" => 'Video Call',
    //         "topic" => 'Video Call',
    //         "type" => 1, // 1 => instant, 2 => scheduled, 3 => recurring with no fixed time, 8 => recurring with fixed time
    //         "duration" => 30, // in minutes
    //         "timezone" => 'Asia/Dhaka', // set your timezone
    //         "password" => null,
    //         "start_time" => '2021-06-10T10:00:00', // if you are scheduling a meeting and type is 2
    //         "template_id" => null,
    //         "pre_schedule" => false,  // set true if you want to create a pre-scheduled meeting
    //         "schedule_for" => 'swarnadwip@excellisit.net', // set your schedule for
    //         "settings" => [
    //             'join_before_host' => false, // if you want to join before host set true otherwise set false
    //             'host_video' => false, // if you want to start video when host join set true otherwise set false
    //             'participant_video' => false, // if you want to start video when participants join set true otherwise set false
    //             'mute_upon_entry' => false, // if you want to mute participants when they join the meeting set true otherwise set false
    //             'waiting_room' => false, // if you want to use waiting room for participants set true otherwise set false
    //             'audio' => 'both', // values are 'both', 'telephony', 'voip'. default is both.
    //             'auto_recording' => 'none', // values are 'none', 'local', 'cloud'. default is none.
    //             'approval_type' => 0, // 0 => Automatically Approve, 1 => Manually Approve, 2 => No Registration Required
    //         ],

    //     ]);

    //     dd($meetings);

    // }
}

