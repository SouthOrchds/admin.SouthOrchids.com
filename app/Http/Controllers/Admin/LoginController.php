<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index() 
    {
        if(Auth::guard('admin')->check()) {
            return redirect()->route('dashboard');
        }
        return view('pages/adminlogin');
    }

    public function checkLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if(Auth::guard('admin')->attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            return redirect()->route('dashboard');
        }
        
        return back()->withErrors(["email" => 'Invalid Email or Password']);
    }

    public function loggedOut()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login');        
    }
}
