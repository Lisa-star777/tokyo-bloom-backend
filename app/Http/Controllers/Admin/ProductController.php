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
        $product = Product::create([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'category' => $request->input('category'),
            'description' => $request->input('description', ''),
            'materials' => $request->input('materials', ''),
            'image_url' => $request->input('image_url', null),
        ]);
        
        return response()->json($product, 201);
    }
    
    public function update(Request $request, Product $product)
    {
        $product->update([
            'title' => $request->input('title', $product->title),
            'price' => $request->input('price', $product->price),
            'category' => $request->input('category', $product->category),
            'description' => $request->input('description', $product->description),
            'materials' => $request->input('materials', $product->materials),
            'image_url' => $request->input('image_url', $product->image_url),
        ]);
        
        return response()->json($product);
    }
    
    public function show(Product $product)
    {
        return response()->json($product);
    }
    
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Товар удален']);
    }
}
