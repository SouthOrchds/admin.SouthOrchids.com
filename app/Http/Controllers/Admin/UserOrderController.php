<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function getOrderDetails()
    {
        $userorders = Order::with(['user', 'orderitems.product'])->get();

        return view('pages/userOrder', compact('userorders'));
    }

    public function searchOrderDetails(Request $request)
    {
        $query = Order::with(['user', 'orderitems.product']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone_no', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $query->where('delivery_status', $status);
        }

        
        $orders = $query->get();

        return response()->json($orders);
    }

    public function getOrderItems()
    {
        $orders = Order::with(['user', 'orderitems.product'])->get();
        $placedOrderCount = Order::where('delivery_status', 'Order Placed')->count();

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
        return view('pages/userOrdersItems', compact('orderDetail', 'placedOrderCount'));
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

    public function getShippedOrders()
    {
        $orders = Order::with(['user', 'orderitems.product'])
                        ->where('delivery_status', 'Shipped')
                        ->get();
        
        $shippedOrderCount = $orders->count();

        $shippedDetails = $orders->map(function ($order) {
            $products = $order->orderItems->map(function ($item) {
                $product = $item->product;
                return(object) [
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
                'shipped_date' => $order->updated_at,
                'total_amount' => $order->total_amount,
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

        return view('pages.shippedOrders', compact('shippedDetails', 'shippedOrderCount'));
    }

    public function searchShippedOrders(Request $request)
    {   
        $ShippedOrder = Order::with(['user', 'orderitems.product'])->where('delivery_status', 'Shipped');

        if($request->filled('search')) {
            $search = $request->search;

            $ShippedOrder->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('phone_no', 'LIKE', "%{$search}%");
            });
        }
        
        return response()->json($ShippedOrder->get());
    }

    public function deliveredOrder(Request $request, $orderId)
    {
        $orders = Order::find($orderId);

        if($orders) {
            $orders->delivery_status = $request->status;
            $orders->save();

            return response()->json(['success' => true]);
        }
        
        return  response()->json(['success' => false]);
    }
}
