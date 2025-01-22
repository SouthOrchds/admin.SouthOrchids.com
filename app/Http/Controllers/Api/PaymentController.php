<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Item;
use App\Models\Product;
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

            $razorpayOrder = $api->order->create([
                'amount' => $amount,
                'currency' => 'INR',
                'receipt' => 'order_rcpt_' . uniqid(),
            ]);

            $items = $request->items;
            $productCount = count($items);
            $quantityCount = array_sum(array_column($items, 'quantity'));
            
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_date' => now(),
                'total_amount' => $amount / 100,
                'payment_status' => 'Pending',
                'delivery_status' => 'Pending',
                'total_count' => json_encode([
                    'product_count' => $productCount,
                    'quantity_count' => $quantityCount,
                ]),
            ]);
            
            return response()->json([
                'order_id' => $order->id,
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $amount,
                'currency' => 'INR',
                'order_items' => $items,
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

            $api->utility->verifyPaymentSignature([
                'razorpay_signature' => $signature,
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_order_id' => $razorpayOrderId,
            ]);

            $order = Order::where('id', $request->order_id)->first();
            $order->payment_status = 'Completed';
            $order->delivery_status = 'Order Placed';

            $items = $request->items;
            foreach($items as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    return response()->json(['error' => "Product with ID {$item['product_id']} not found."], 404);
                }

                $order_items = Order_Item::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'mrp_price' => $product->mrp_price,
                    'purchased_price' => $product->purchased_price,
                ]);
            }

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'phone_number' => $request->phone_no,
                'reference_id' => $razorpayPaymentId,
                'amount' => $order->total_amount,
                'status' => 'Success',
            ]);

            $order->transaction_id = $transaction->id;
            $order->save();

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
