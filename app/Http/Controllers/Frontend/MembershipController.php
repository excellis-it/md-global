<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\PurchaseMembership;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe;

class MembershipController extends Controller
{
    public function membershipModel(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::check() && (Auth::user()->hasRole('PATIENT'))) {
                $plan = Plan::find($request->id);
                return response()->json(['data' => $plan, 'status' => true]);
            } else {
                return response()->json(['status' => false, 'message'=> 'You are not authorized to access this page.']);
            }
        }
    }

    public function membershipPayment(Request $request)
    {
        // return $request->all();

        try {
            $count = UserMembership::where('user_id', Auth::user()->id)->count();
            if ($count > 0) {
                $userMembership = UserMembership::where('user_id', Auth::user()->id)->where('membership_expiry_date', '>=', date('Y-m-d'))->orderBy('id', 'desc')->first();
                if ($userMembership) {
                    return redirect()->back()->with('error', 'You already have a membership plan. Please wait until it expires.');
                } else {
                    UserMembership::where('user_id', Auth::user()->id)->where('membership_expiry_date', '<', date('Y-m-d'))->delete();
                    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                    $customer = Stripe\Customer::create(array(
                        "email" => Auth::user()->email,
                        "name" => $request->name,
                        "source" => $request->stripeToken
                    ));

                    $plan = Plan::find($request->plan_id);

                    $charge = Stripe\Charge::create([
                        "amount" => 100 * $plan->plan_price,
                        "currency" => "usd",
                        "customer" => $customer->id,
                        "description" => "Membership Plan Payment for " . $plan->plan_name . " Plan" . " by " . Auth::user()->name,
                    ]);

                    if ($charge->status == 'succeeded') {
                        $userMembership = new UserMembership();
                        $userMembership->user_id = Auth::user()->id;
                        $userMembership->plan_id = $request->plan_id;
                        $userMembership->payment_id = $charge->id;
                        $userMembership->currency = 'usd';
                        $userMembership->amount = $charge->amount / 100;
                        $userMembership->membership_expiry_date = date('Y-m-d', strtotime('+' . $plan->plan_duration . 'months'));
                        $userMembership->payment_response = json_encode($charge);
                        $userMembership->save();
                        $details = [
                            'name' => $request->name,
                            'plan_name' => $plan->plan_name,
                            'plan_price' => $userMembership->amount,
                        ];
                        Mail::to(Auth::user()->email)->send(new PurchaseMembership($details));
                        return redirect()->back()->with('message', 'Payment done successfully.');
                    } else {
                        return redirect()->back()->with('error', 'Payment failed.');
                    }
                }
            } else {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $customer = Stripe\Customer::create(array(
                    "email" => Auth::user()->email,
                    "name" => $request->name,
                    "source" => $request->stripeToken
                ));

                $plan = Plan::find($request->plan_id);

                $charge = Stripe\Charge::create([
                    "amount" => 100 * $plan->plan_price,
                    "currency" => "usd",
                    "customer" => $customer->id,
                    "description" => "Membership Plan Payment for " . $plan->plan_name . " Plan" . " by " . Auth::user()->name,
                ]);

                if ($charge->status == 'succeeded') {
                    $userMembership = new UserMembership();
                    $userMembership->user_id = Auth::user()->id;
                    $userMembership->plan_id = $request->plan_id;
                    $userMembership->payment_id = $charge->id;
                    $userMembership->currency = 'usd';
                    $userMembership->amount = $charge->amount / 100;
                    $userMembership->membership_expiry_date = date('Y-m-d', strtotime('+' . $plan->plan_duration . 'months'));
                    $userMembership->payment_response = json_encode($charge);
                    $userMembership->save();
                    $details = [
                        'name' => $request->name,
                        'plan_name' => $plan->plan_name,
                        'plan_price' => $userMembership->amount,
                    ];
                    Mail::to(Auth::user()->email)->send(new PurchaseMembership($details));
                    return redirect()->back()->with('message', 'Payment done successfully.');
                } else {
                    return redirect()->back()->with('error', 'Payment failed.');
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
