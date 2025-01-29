<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Blog;
use App\Models\ClinicDetails;
use App\Models\Specialization;
use App\Models\Symptoms;
use App\Models\User;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        $count['patient'] = User::Role('PATIENT')->count();
        $count['doctor'] = User::Role('DOCTOR')->count();
        $count['membership_total_payment'] = UserMembership::sum('amount');
        $total_membership_transaction['january'] = UserMembership::whereMonth('created_at', 1)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['february'] = UserMembership::whereMonth('created_at', 2)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['march'] = UserMembership::whereMonth('created_at', 3)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['april'] = UserMembership::whereMonth('created_at', 4)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['may'] = UserMembership::whereMonth('created_at', 5)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['june'] = UserMembership::whereMonth('created_at', 6)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['july'] = UserMembership::whereMonth('created_at', 7)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['august'] = UserMembership::whereMonth('created_at', 8)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['september'] = UserMembership::whereMonth('created_at', 9)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['october'] = UserMembership::whereMonth('created_at', 10)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['november'] = UserMembership::whereMonth('created_at', 11)->whereYear('created_at', date('Y'))->sum('amount');
        $total_membership_transaction['december'] = UserMembership::whereMonth('created_at', 12)->whereYear('created_at', date('Y'))->sum('amount');
        $count['total_appointment'] = Appointment::where('appointment_status', 'Done')->count();
        $count['clinics'] = ClinicDetails::count();
        // top 5 clinic by appointment with clinic name and total appointment group by clinic id
        $top_5_clinics = DB::table('appointments')
        ->select('clinic_details.clinic_name', 'appointments.clinic_id', DB::raw('count(appointments.id) as total_appointment'))
        ->join('clinic_details', 'appointments.clinic_id', '=', 'clinic_details.id')
        ->where('appointments.appointment_status', 'Done')
        ->groupBy('appointments.clinic_id', 'clinic_details.clinic_name')
        ->orderByDesc('total_appointment')
        ->limit(5)
        ->get();
        // total blogs
        $count['blogs'] = Blog::where('status', 1)->count();
        // total specializations
        $count['specializations'] = Specialization::count();
        // total symptoms
        $count['symptoms'] = Symptoms::count();
        // dd($top_5_clinics->toArray());
        return view('admin.dashboard')->with(compact('count', 'total_membership_transaction','top_5_clinics'));
    }

    public function membershipBarChart(Request $request)
    {
        if ($request->ajax()) {
            $total_membership_transaction['january'] = UserMembership::whereMonth('created_at', 1)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['february'] = UserMembership::whereMonth('created_at', 2)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['march'] = UserMembership::whereMonth('created_at', 3)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['april'] = UserMembership::whereMonth('created_at', 4)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['may'] = UserMembership::whereMonth('created_at', 5)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['june'] = UserMembership::whereMonth('created_at', 6)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['july'] = UserMembership::whereMonth('created_at', 7)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['august'] = UserMembership::whereMonth('created_at', 8)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['september'] = UserMembership::whereMonth('created_at', 9)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['october'] = UserMembership::whereMonth('created_at', 10)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['november'] = UserMembership::whereMonth('created_at', 11)->whereYear('created_at', $request->year)->sum('amount');
            $total_membership_transaction['december'] = UserMembership::whereMonth('created_at', 12)->whereYear('created_at', $request->year)->sum('amount');

            return response()->json(['view' => (string)View::make('admin.membership-bar-chart', compact('total_membership_transaction'))]);
        }
    }
}
