<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        if(!Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }
        $products = Product::all();
        $brands = Product::select('brand')->distinct()->get();

        return view('pages/product', compact('products', 'brands'));
    }

    public function addProduct(Request $request)
    {
        $validateProduct = $request->validate([
            'product_name' => 'required|string|max:50|regex:/^[a-zA-Z\s]+$/',
            'product_decrp' => 'required|string|max:100',
            'product_quantity' => 'required|string|max:15',
            'brand_name' => 'required|string|max:15',
            'price' => 'required|numeric|min:1|max:10000',
            'mrp_price' => 'required|numeric|min:1|max:10000',
            'purchase_price' => 'nullable|numeric|min:1|max:10000',
            'category' => 'required|numeric',
            'product_status' => 'required|string',
            'product_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]); 

        if($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $image_path = $image->store('product_image', 'public');
        }

        $product = new Product();
        $product->category_id = $validateProduct['category'];
        $product->name = $validateProduct['product_name'];
        $product->description = $validateProduct['product_decrp'];
        $product->brand = $validateProduct['brand_name'];
        $product->mrp_price = $validateProduct['mrp_price'];
        $product->purchased_price = $validateProduct['purchase_price'];
        $product->price = $validateProduct['price'];
        $product->quantity = $validateProduct['product_quantity'];
        $product->status = $validateProduct['product_status'];
        $product->product_image = $image_path;
        $product->save();

        session()->flash('success', 'Product successfully added');

        return redirect()->back();
    }

    public function getProducts(Request $request)
    {
        $query = Product::query();
    
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%'. $request->search . '%');
        } 

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->get();

        return response()->json($products);
    }
}
