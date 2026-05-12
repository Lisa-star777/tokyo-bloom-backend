<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user() ? $request->user()->cart : null;
        if (!$cart) return response()->json(['items' => []]);
        
        $items = $cart->items()->with('product')->get();
        return response()->json(['items' => $items->map(function ($item) {
            return ['id' => $item->product_id, 'title' => $item->product->title, 'price' => $item->product->price, 'quantity' => $item->quantity];
        })]);
    }
    
    public function addItem(Request $request)
    {
        $user = $request->user();
        if (!$user) return response()->json(['message' => 'Требуется авторизация'], 401);

        $cart = $user->cart ?? $user->cart()->create();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
        if ($item) { $item->quantity += $quantity; $item->save(); }
        else { CartItem::create(['cart_id' => $cart->id, 'product_id' => $productId, 'quantity' => $quantity]); }
        
        return response()->json(['message' => 'Товар добавлен']);
    }
    
    public function updateQuantity(Request $request, $productId)
    {
        $cart = $request->user()->cart ?? null;
        if (!$cart) return response()->json(['message' => 'Корзина пуста'], 404);
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
        if (!$item) return response()->json(['message' => 'Не найдено'], 404);
        $qty = $request->input('quantity', 0);
        $qty <= 0 ? $item->delete() : ($item->quantity = $qty) && $item->save();
        return response()->json(['message' => 'OK']);
    }
    
    public function removeItem($productId)
    {
        $cart = request()->user()->cart ?? null;
        if ($cart) CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->delete();
        return response()->json(['message' => 'Удалено']);
    }
    
    public function clear(Request $request)
    {
        $cart = $request->user()->cart ?? null;
        if ($cart) $cart->items()->delete();
        return response()->json(['message' => 'Очищено']);
    }
}
