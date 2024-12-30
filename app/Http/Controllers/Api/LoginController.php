<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;



class LoginController extends Controller
{
    public function loginCheck(Request $request)
    {
        try {
            Log::info('Request Data: ', $request->all());

            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
            
            $user = User::where('email', $validatedData['email'])->first();
            if (!$user) {
                return response()->json(['message'=> 'User not a user'],404);
            }

            if (!Hash::check($validatedData['password'], $user->password)) {
                return response()->json(['message'=> 'Invalid email or password'],401);
            }

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'api_token' => $user->api_token,
                ],
            ], 200);
        }
        catch (ValidationException $e) {
            Log::warning('Validation Errors: ', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error in Login Check: ' . $e->getMessage());
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
}
