<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
   public function newsletter(Request $request)
   {
        // ajax submit
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:newsletters,email',
            ]);

            if ($validator->fails()) {
                $errors['message'] = [];
                $data = explode(',', $validator->errors());
    
                for ($i = 0; $i < count($validator->errors()); $i++) {
                    // return $data[$i];
                    $dk = explode('["', $data[$i]);
                    $ck = explode('"]', $dk[1]);
                    $errors['message'][$i] = $ck[0];
                }
                return response()->json(['status' => false, 'error' => $errors['message'][0]]);
            }

            $newsletter = new Newsletter();
            $newsletter->name = $request->name;
            $newsletter->email = $request->email;
            $newsletter->message = $request->message;
            $newsletter->save();

            return response()->json([
                'success' => true,
                'message' => 'Thanks for subscribing to our newsletter.'
            ]);
        }
   }
}
