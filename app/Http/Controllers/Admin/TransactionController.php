<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $userTransaction = Transaction::with('user')->get();
        
        $userData = $userTransaction->map(function ($transaction) {
            $users = $transaction->user;
            return (object)[
                'user_id' => $users->id,
                'name' => $users->name,
                'email' => $users->email,
                'phone_no' => $users->phone_no,
                'address' => $users->address,
                'city' => $users->city,
                'pincode' => $users->pincode
            ];
        });

        return view('pages/transaction', compact('userTransaction', 'userData'));
    }

    public function show(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('phone_no')) {
            $query->where('phone_number', 'LIKE', '%'. $request->phone_no . '%');
        }

        $transactions = $query->get();
        return response()->json($transactions);
    }
}
