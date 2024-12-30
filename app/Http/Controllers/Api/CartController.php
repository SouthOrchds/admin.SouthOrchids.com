<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function AddCartItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();

        $product = Product::find($validated['product_id']);
        if(!$product){
            return response()->json(["error" => "Product not found"]);
        }

        Cart::create([
            'user_id' => $userId,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
        ]);

        return response()->json([
            'message' => 'Product Add successfully',
        ]);
    }

    public function ShowCartItems(Request $request)
    {
        $user = $request->user();

        $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

        return response()->json([
            'success' => true,
            'data' => $cartItems,
        ]);
    }

    public function DeleteCartItme(Request $request, $product_id)
    {
        $userId = Auth::id();
        
        $cartItems = Cart::where('user_id', $userId)->where('product_id', $product_id)->get();

        if(!$cartItems) {
            return response()->json(['error' => 'Cart item not found'], 400);
        }
        $cartItems->each(function($cartItems) {
            $cartItems->delete();
        });
        
        return response()->json([
            'message' => 'Cart removed successfully',
        ]);
    }

    public function ClearCartAfterOrder(Request $request)
    {
        $userId = Auth::id();

        Cart::where('user_id', $userId)->delete();

        return response()->json([
            'message' => 'Cart cleared successfully after order placement',
        ]);
    }
}
