<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
                $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'tokyo-bloom/products'
                ]);
                $product->image_url = $uploadedFile->getSecurePath();
                $product->save();
            }
            
            return response()->json($product, 201);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function update(Request $request, Product $product)
    {
        try {
            $product->update([
                'title' => $request->input('title', $product->title),
                'price' => $request->input('price', $product->price),
                'category' => $request->input('category', $product->category),
                'description' => $request->input('description', $product->description),
                'materials' => $request->input('materials', $product->materials),
            ]);
            
            if ($request->hasFile('image')) {
                $uploadedFile = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'tokyo-bloom/products'
                ]);
                $product->image_url = $uploadedFile->getSecurePath();
                $product->save();
            }
            
            return response()->json($product);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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