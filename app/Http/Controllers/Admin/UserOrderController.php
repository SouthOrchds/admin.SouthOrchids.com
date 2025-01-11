<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function getOrderItems()
    {
        $orders = Order::with(['user', 'orderitems.product'])->get();

        $orderDetail = $orders->map(function ($order) {

            $products = $order->orderitems->map(function ($item) {
                $product = $item->product;
                return (object)[
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'product_name' => $product->name,
                    'product_quantity' => $product->quantity,
                    'product_brand' => $product->brand,
                    'product_price' => $product->price,
                    'product_status' => $product->status,
                ];
            });

            return (object)[
                'order_id' => $order->id,
                'order_date' => $order->order_date,
                'total_amount' => $order->total_amount,
                'payment_status' => $order->payment_status,
                'delivery_status' => $order->delivery_status,
                'user_id' => $order->user->id,
                'user_name' => $order->user->name,
                'user_phone_no' => $order->user->phone_no,
                'user_address' => $order->user->address,
                'user_city' => $order->user->city,
                'user_pincode' => $order->user->pincode,
                'products' => $products,
            ];

        });
        return view('userOrdersItems', compact('orderDetail'));
    }

    public function shipOrder(Request $request, $orderId)
    {
        $orders = Order::find($orderId);

        if($orders) {
            $orders->delivery_status = $request->status;
            $orders->save();

            return response()->json(['success' => true]);
        }
        
        return  response()->json(['success' => false]);
    }

    public function getOrders()
    {
        return view('userOrder');
    }
}
