<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart;
        if (!$cart) return response()->json(['items' => []]);
        $items = $cart->items()->with('product')->get()->map(function ($item) {
            return ['id' => $item->product_id, 'title' => $item->product->title, 'price' => $item->product->price, 'quantity' => $item->quantity];
        });
        return response()->json(['items' => $items]);
    }
    
    public function addItem(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart ?? $user->cart()->create();
        $pid = $request->input('product_id');
        $qty = $request->input('quantity', 1);
        
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $pid)->first();
        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            CartItem::create(['cart_id' => $cart->id, 'product_id' => $pid, 'quantity' => $qty]);
        }
        return response()->json(['message' => 'Добавлено']);
    }
    
    public function updateQuantity(Request $request, $productId)
    {
        $cart = $request->user()->cart;
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
        $qty = $request->input('quantity', 0);
        if ($qty <= 0) { $item->delete(); } else { $item->quantity = $qty; $item->save(); }
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
        $cart = $request->user()->cart;
        if ($cart) $cart->items()->delete();
        return response()->json(['message' => 'Очищено']);
    }
}
