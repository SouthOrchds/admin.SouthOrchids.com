<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('usersdata', compact('users'));
    }

    public function getUserData(Request $request)
    {
        $search = $request->input('search');
        
        $user = User::where('email', 'LIKE', "%{$search}%")
                ->orWhere('phone_no', 'LIKE', "%{$search}%")
                ->get();

        return response()->json($user);
    }
}
