<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart;
        if (!$cart) return response()->json(['items' => []]);
        $items = $cart->items()->with('product')->get();
        return response()->json(['items' => $items->map(fn($i) => ['id' => $i->product_id, 'title' => $i->product->title, 'price' => $i->product->price, 'quantity' => $i->quantity]])]);
    }
    
    public function addItem(Request $request)
    {
        $cart = $request->user()->cart ?? $request->user()->cart()->create();
        $pid = $request->input('product_id'); $qty = $request->input('quantity', 1);
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $pid)->first();
        $item ? ($item->quantity += $qty) && $item->save() : CartItem::create(['cart_id' => $cart->id, 'product_id' => $pid, 'quantity' => $qty]);
        return response()->json(['message' => 'Добавлено']);
    }
    
    public function updateQuantity(Request $request, $productId)
    {
        $cart = $request->user()->cart;
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
        $qty = $request->input('quantity', 0);
        $qty <= 0 ? $item->delete() : ($item->quantity = $qty) && $item->save();
        return response()->json(['message' => 'OK']);
    }
    
    public function removeItem($productId)
    {
        $cart = request()->user()->cart;
        if ($cart) CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->delete();
        return response()->json(['message' => 'Удалено']);
    }
    
    public function clear(Request $request)
    {
        $request->user()->cart?->items()->delete();
        return response()->json(['message' => 'Очищено']);
    }
}
