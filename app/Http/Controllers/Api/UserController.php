<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use function Laravel\Prompts\password;

class UserController
{

    public function register(Request $request)
    {
        try {
            
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
            
            return response()->json($user, 200);
        } 
        catch (ValidationException $e) {
            Log::warning('Validation Errors: ', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        } 
        catch (\Exception $e) {
            Log::error('Error in User Registration: ' . $e->getMessage());
            return response()->json(['message' => 'Server Error'], 500);
        }
    }

    public function UserData()
    {
        $user = Auth::user();

        if(!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        $userdata = $user->only(['id', 'name', 'email', 'phone_no', 'address', 'city', 'pincode']);

        return response()->json($userdata);
    }

    public function editAddress(Request $request)
    {
        $user = Auth::user();

        if(!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }     
        
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'pincode' => 'required|digits:6|regex:/^[6]\d{5}$/',
        ]);
        
        $user->address = $validatedData['address'];
        $user->city = $validatedData['city'];
        $user->pincode = $validatedData['pincode'];
        $user->save();  

        return response()->json(['message' => 'Address updated successfully'], 200);
    }
}

