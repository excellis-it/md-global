<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function paymentHistory()
    {
        $payment_history = Payment::where('doctor_id', auth()->user()->id)->orderBy('id','desc')->paginate(9);
        return view('frontend.doctor.payment-history')->with(compact('payment_history'));
    }
}
