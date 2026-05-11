<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::orderBy('id')->get());
    }
    
    public function store(Request $request)
    {
        $product = Product::create($request->only([
            'title', 'price', 'category', 'description', 'materials', 'image_url'
        ]));
        return response()->json($product, 201);
    }
    
    public function show($id)
    {
        return response()->json(Product::findOrFail($id));
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->only([
            'title', 'price', 'category', 'description', 'materials', 'image_url'
        ]));
        return response()->json($product);
    }
    
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Товар удален']);
    }
}
