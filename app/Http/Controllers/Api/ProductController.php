<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    public function sendmsg()
    {
        $datas = Product::all();
        
        $datas->each(function ($data) {
            $data->product_image = $data->product_image ? asset('storage/' . $data->product_image) : null;
        });

        return response()->json($datas);
    }
}
