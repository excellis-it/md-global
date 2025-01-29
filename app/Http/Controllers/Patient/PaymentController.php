<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\VideoCallDetails;
use App\Models\VideoCallPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe;
class PaymentController extends Controller
{
    public function videoConsultancyPayment(Request $request)
    {
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = Stripe\Customer::create(array(
                "email" => Auth::user()->email,
                "name" => $request->name,
                "source" => $request->stripeToken
            ));

            $videoCallPrice = VideoCallPrice::find($request->videocall_price_id);
            $video = VideoCallDetails::find($request->videocall_id);
            $charge = Stripe\Charge::create([
                "amount" => 100 * $videoCallPrice->price,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => "Video Consultancy Payment for " . $video->sender->name . " Plan" . " by " . Auth::user()->name,
            ]);

            if ($charge->status == 'succeeded') {
               $payment = new Payment();
                $payment->patient_id = Auth::user()->id;
                $payment->doctor_id = $video->sender_id;
                $payment->amount = $videoCallPrice->price;
                $payment->meeting_id = $video->meeting_id;
                $payment->payment_id = $charge->id;
                $payment->currency = 'usd';
                $payment->payment_response = json_encode($charge);
                $payment->start_url = $video->start_url;
                $payment->join_url = $video->join_url;
                $payment->call_duration = $videoCallPrice->duration;
                $payment->save();

                return redirect($video->join_url);
            } else {
                return redirect()->back()->with('error', 'Payment failed.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
