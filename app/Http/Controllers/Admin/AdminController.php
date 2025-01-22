<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\password;

class AdminController extends Controller
{
    public function index() 
    {
        if(!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        return view('pages/adminregister');
    }

    public function registerAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[^a-zA-Z0-9]/',
            'confirm_password' => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[^a-zA-Z0-9]/',
            'phone_no' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
        ]);    

        if($validated['password'] === $validated['confirm_password'])
        {
            $admin = Admin::create([
                'name' => $validated['name'],
                'email' => Str::lower($validated['email']),
                'password' => Hash::make($validated['password']),
                'api_token' => Str::random(30),
                'phone_no' => $validated['phone_no'],
            ]);
        }
        else {
            alert('Password does not match');
        }

        return redirect()->route('login');
    }
}
