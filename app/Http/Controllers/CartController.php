<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        if (!$cart) return response()->json(['items' => []]);
        
        $items = $cart->items()->with('product')->get();
        return response()->json(['items' => $items->map(function ($item) {
            return [
                'id' => $item->product_id,
                'title' => $item->product->title,
                'price' => $item->product->price,
                'description' => $item->product->description,
                'quantity' => $item->quantity,
            ];
        })]);
    }
    
    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1|max:99',
        ]);
        
        $cart = $this->getOrCreateCart($request);
        $quantity = $validated['quantity'] ?? 1;
        
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $validated['product_id'])->first();
        
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create(['cart_id' => $cart->id, 'product_id' => $validated['product_id'], 'quantity' => $quantity]);
        }
        
        return response()->json(['message' => 'Товар добавлен', 'cart_count' => $cart->items()->sum('quantity')]);
    }
    
    public function updateQuantity(Request $request, $productId)
    {
        $cart = $this->getCart($request);
        if (!$cart) return response()->json(['message' => 'Корзина пуста'], 404);
        
        $cartItem = CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->first();
        if (!$cartItem) return response()->json(['message' => 'Товар не найден'], 404);
        
        $quantity = $request->input('quantity', 0);
        if ($quantity <= 0) { $cartItem->delete(); return response()->json(['message' => 'Удалено']); }
        $cartItem->quantity = $quantity; $cartItem->save();
        return response()->json(['message' => 'Обновлено']);
    }
    
    public function removeItem($productId)
    {
        $cart = $this->getCart(request());
        if ($cart) CartItem::where('cart_id', $cart->id)->where('product_id', $productId)->delete();
        return response()->json(['message' => 'Удалено']);
    }
    
    public function clear(Request $request)
    {
        $cart = $this->getCart($request);
        if ($cart) $cart->items()->delete();
        return response()->json(['message' => 'Очищено']);
    }
    
    private function getCart(Request $request)
    {
        if ($user = $request->user()) return $user->cart;
        $cartId = $request->session()->get('guest_cart_id');
        return $cartId ? Cart::find($cartId) : null;
    }
    
    private function getOrCreateCart(Request $request)
    {
        if ($user = $request->user()) {
            return $user->cart ?? $user->cart()->create();
        }
        $cartId = $request->session()->get('guest_cart_id');
        if ($cartId && $cart = Cart::find($cartId)) return $cart;
        $cart = Cart::create(['user_id' => 0]);
        $request->session()->put('guest_cart_id', $cart->id);
        return $cart;
    }
}