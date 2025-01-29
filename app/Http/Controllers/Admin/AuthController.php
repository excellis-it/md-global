<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check() && Auth::user()->hasRole('ADMIN')) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('admin.auth.login');
        }
    }
    public function redirectAdminLogin()
    {
        return redirect()->route('admin.login');
    }

    public function loginCheck(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|min:8'
        ]);
        $remember_me = $request->has('remember_me') ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember_me)) {
            $user = User::where('email', $request->email)->select('id', 'email', 'status')->first();
            // if ($user->hasRole('ADMIN') && $user->status == 1) {
            //     return redirect()->route('admin.dashboard');
            // } else {
            //     Auth::logout();
            //     return redirect()->back()->with('error', 'Email id & password was invalid!');
            // }
            if ($user && $user->status == 1 && ($user->hasRole('ADMIN') || $user->roles->first()->id == 1 || $user->roles->first()->id >= 5)) {
                // Successfully logged in
                return redirect()->route('admin.dashboard');
            } else {
                // Invalid credentials or user is not active
                Auth::logout();
                return redirect()->back()->with('error', 'Email id & password was invalid!');
            }
        } else {
            return redirect()->back()->with('error', 'Email id & password was invalid!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
