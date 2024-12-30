<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    public function sendmsg()
    {
        $datas = Product::all();
        return response()->json($datas);
    }
}
