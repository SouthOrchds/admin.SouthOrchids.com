<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index() 
    {
        return view('adminlogin');
    }

    public function checkLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $admin = Admin::where('email', $validated['email'])->first();

        if(!$admin || !Hash::check($validated['password'], $admin->password)) {
            return back()->withErrors(["email" => 'Invalid Email or Password']);
        }

        return redirect()->route('dashboard');
    }
}
