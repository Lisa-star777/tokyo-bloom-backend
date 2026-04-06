<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id')->get();
        return response()->json($products);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }
}