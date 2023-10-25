<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth-login');
    }

    public function do_login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email:rfc,dns|exists:users',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.index'));
        }
        return back()->with(['error' => 'Login failed, email or password wrong!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->flush();
 
        $request->session()->regenerate();
 
        return redirect(route('auth.login'))
            ->withSuccess('Good bye!');
    }
}
