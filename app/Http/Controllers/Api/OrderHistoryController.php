<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function orderHistory(Request $request)
    {
        $user = $request->user();

        $orderItems = Order::where('user_id', $user->id)->get();

        $orderHistory = $orderItems->map(function ($order) {
            
            $orderDetails = json_decode($order->orders, true);

            $products = collect($orderDetails)->map(function ($item) {
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
                'status' => $order->status,
                'items' => $products,
            ];
        });

        return response()->json([
            "Success" => true,
            "data" => $orderHistory
        ]);
    }
}
