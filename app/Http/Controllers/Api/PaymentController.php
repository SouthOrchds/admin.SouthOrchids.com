<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {
        try {
            $apiKey = 'rzp_test_iykvKQhyb4LTCM';
            $apiSecret = 'u4M0BjSFaBFP938ZJvQOIwF2';

            $api = new Api($apiKey, $apiSecret);

            $amount = $request->amount;

            $order = $api->order->create([
                'amount' => $amount,
                'currency' => 'INR',
                'receipt' => 'order_rcpt_' . uniqid(),
            ]);
            
            $newOrder = Order::create([
                'user_id' => Auth::id(),
                'orders' => json_encode($request->items),
                'order_date' => now(),
                'total_amount' => $amount / 100,
                'status' => 'Pending',
            ]);
            
            return response()->json([
                'order_id' => $newOrder->id,
                'razorpay_order_id' => $order['id'],
                'amount' => $amount,
                'currency' => 'INR',
                'order' => $newOrder->orders,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function handlePaymentSuccess(Request $request) 
    {    
        try {
            $signature = $request->razorpay_signature;
            $razorpayPaymentId  = $request->razorpay_payment_id;
            $razorpayOrderId  = $request->razorpay_order_id;

            $apiKey = 'rzp_test_iykvKQhyb4LTCM';
            $apiSecret = 'u4M0BjSFaBFP938ZJvQOIwF2';

            $api = new Api($apiKey, $apiSecret);

            $attributes = [
                'razorpay_signature' => $signature,
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_order_id' => $razorpayOrderId,
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $order = Order::where('id', $request->order_id)->first();
            $order->status = 'Completed';
            $order->save();

            Transaction::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'phone_number' => $request->phone_no,
                'reference_id' => $razorpayPaymentId,
                'amount' => $order->total_amount,
                'status' => 'Success',
            ]);

            app(CartController::class)->ClearCartAfterOrder($request);

            return response()->json([
                'message' => 'Payment successful!, Cart cleared',
                'transaction_id' => $razorpayPaymentId
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handlePaymentFailure(Request $request)
    {
        try {
            Transaction::create([
                'user_id' => Auth::id(),
                'order_id' => $request->order_id,
                'phone_number' => $request->phone_no,
                'reference_id' => $request->razorpay_payment_id,
                'amount' => $request->amount,
                'status' => 'Failed',
            ]);

            return response()->json(['message' => 'Payment failed.'], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
