<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function login()
    {

        //dd(Hash::make('bagas'));
         
        return view('frontend.auth.login');
    }

    public function doLogin(Request $request)
    {
        // Handle login logic here
        // Validate credentials, authenticate user, etc.

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $attempt = Auth::attempt($validated);

        if(!$attempt) {
            return redirect()->back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->withInput(
                    $request->only('email', 'remember')
                );
        }

        // Check if there's an intended URL (from add to cart redirect)
        $intendedUrl = session('intended', route('frontend.index'));
        
        // Clear the intended URL from session
        session()->forget('intended');

        return redirect($intendedUrl)->with('success', 'Login berhasil! Selamat datang kembali.'); 
    }

    public function register()
    {
        return view('frontend.auth.register');
    }

    // Handle user registration
    public function doRegister(Request $request)
    {
        // Step 1: Validate the request data
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // Password confirmation
        ]);
        // Step 2: Create the user
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hash the password before storing
            ]);

            // Assign default subscriber role to new customers
            $user->assignRole('subscriber');

            return redirect()->route('frontend.index'); 

        } catch (\Exception $e) {
            // Handle any error that occurs during registration
           return redirect()->back()
                ->withErrors(['error' => 'Registration failed. Please try again.'])
                ->withInput($request->only('name', 'email'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Hapus session user

        $request->session()->invalidate();       // Invalidate session
        $request->session()->regenerateToken();  // Regenerate CSRF token

        return redirect('/login')->with('success', 'Anda berhasil logout');
    }
}
