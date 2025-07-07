<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login()
    {
        return view('frontend.auth.login');
    }

    public function doLogin(Request $request)
    {
        // Handle login logic here
        // Validate credentials, authenticate user, etc.

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $attempt = Auth::attempt($validated);
        if(!$attempt) {
            return redirect()->back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->withInput(
                    $request->only('email', 'remember')
                );
        }

        return redirect()->route('frontend.index'); 
    }

    public function register()
    {
        return view('frontend.auth.register');
    }
}
