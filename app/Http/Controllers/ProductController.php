<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        $products = Cache::remember('products', 600, function () {
            return Product::orderBy('id')->get();
        });
        return response()->json($products);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }
}
