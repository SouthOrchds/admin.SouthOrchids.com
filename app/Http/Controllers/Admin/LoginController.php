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
            $admin = Auth::guard('admin')->user();

            if($admin->status == 'active'){
                return redirect()->route('dashboard');
            }
        }
        return view('pages/adminlogin');
    }

    public function checkLogin(Request $request)
    {

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
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
