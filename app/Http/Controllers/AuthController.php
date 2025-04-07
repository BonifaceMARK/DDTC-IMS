<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
class AuthController extends Controller
{
    public function welcome(){

        return view('welcome');
    }
    public function loadlogin()
    {
        return view('login');
    }
    public function loadregister()
{
    return view('register');
}
public function login(Request $request)
{
    try {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            return redirect($this->redirectDash());
        } else {
            throw new \Exception('Invalid credentials. Please try again.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}

public function redirectDash()
{
    $redirect = '';

    if (Auth::user()) {
        switch (Auth::user()->role) {
            case 1: 
                $redirect = '/welcome';
                break;

            case 2: 
                $redirect = '/welcome';
                break;

            case 3: 
                $redirect = '/welcome';
                break;

            default:  
                $redirect = '/'; 
                break;
        }
    } else {
        $redirect = '/login'; 
    }

    return $redirect;
}

public function register(Request $request)
{
    $request->validate([
        'fullname' => 'required',
        'username' => 'required',
        'password' => 'required',
        'email' => 'required|email',
    ]);
    try {
        User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
        ]);
        return redirect()->route('login')->with('success', 'Registration successful');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());
    }
}

function logout(){
    $user = Auth::user();
    // $user->update(['isactive' => 0]);
    Session::flush();
    Auth::logout();
    return redirect('/');
 }
}
