<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id')->get();
        return response()->json($products);
    }
    
    public function store(Request $request)
{
    try {
        $product = Product::create([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'category' => $request->input('category'),
            'description' => $request->input('description', ''),
            'materials' => $request->input('materials', ''),
        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('products', $filename, 'public');
            $product->image_url = '/storage/' . $path;
            $product->save();
        }
        
        return response()->json($product, 201);
        
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    
    // ДОБАВЬТЕ ЭТОТ МЕТОД
    public function update(Request $request, Product $product)
{
    try {
        // Сначала обновим без изображения
        $product->update([
            'title' => $request->input('title', $product->title),
            'price' => $request->input('price', $product->price),
            'category' => $request->input('category', $product->category),
            'description' => $request->input('description', $product->description),
            'materials' => $request->input('materials', $product->materials),
        ]);
        
        // Если есть изображение - обработаем отдельно
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('products', $filename, 'public');
            $product->image_url = '/storage/' . $path;
            $product->save();
        }
        
        return response()->json($product);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}
    
    public function show(Product $product)
    {
        return response()->json($product);
    }
    
    public function destroy(Product $product)
    {
        if ($product->image_url) {
            $oldPath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($oldPath);
        }
        
        $product->delete();
        
        return response()->json(['message' => 'Товар удален']);
    }
}