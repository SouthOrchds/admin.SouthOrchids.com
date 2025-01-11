<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Item;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function orderHistory(Request $request)
    {
        $user = $request->user();

        $orders = Order::where('user_id', $user->id)->get();

        $orderHistory = $orders->map(function ($order) {
            
            $orderItems = Order_Item::where('order_id', $order->id)->get();

            $products = $orderItems->map(function ($item) {
                $product = Product::find($item['product_id']);
                return [
                    'product_name' => $product->name,
                    'product_brand' => $product->brand,
                    'product_price' => $product->price,
                    'product_image' => $product->product_image,
                    'quantity' => $item['quantity'],
                ];
            });

            return [
                'id' => $order->id,
                'order_date' => $order->order_date,
                'total_amount' => $order->total_amount,
                'payment_status' => $order->payment_status,
                'delivery_status' => $order->delivery_status,
                'items' => $products,
            ];
        });

        return response()->json([
            "Success" => true,
            "data" => $orderHistory
        ]);
    }
}
