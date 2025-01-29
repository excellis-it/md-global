<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\UserMembership;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function paymentHistory()
    {
        $membership = UserMembership::where('user_id', auth()->user()->id)->where('membership_expiry_date','>=',date('Y-m-d'))->orderBy('id','desc')->first();
        $payment_history = Payment::where('patient_id', auth()->user()->id)->orderBy('id','desc')->paginate(6);
        return view('frontend.patient.payment-history')->with(compact('membership','payment_history'));
    }
}
