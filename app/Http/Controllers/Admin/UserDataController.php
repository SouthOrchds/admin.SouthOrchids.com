<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserDataController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages/usersdata', compact('users'));
    }

    public function getUserData(Request $request)
    {
        $search = $request->input('search');
        
        $user = User::where('email', 'LIKE', "%{$search}%")
                ->orWhere('phone_no', 'LIKE', "%{$search}%")
                ->get();

        return response()->json($user);
    }

    public function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[^a-zA-Z0-9]/',
            'phone_no' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'pincode' => 'required|digits:6|regex:/^[6]\d{5}$/',
        ]);
        $validatedData['email'] = Str::lower($validatedData['email']);
        $validatedData['password'] = bcrypt($validatedData['password']);
        $validatedData['api_token'] = Str::random(20);
        $user = User::create($validatedData);

        return redirect()->route('usersdata')->with('success', 'User created successfully');
    }
}
