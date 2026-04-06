<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json(['items' => []]);
            }
            
            $cart = $user->cart;
            
            if (!$cart) {
                $cart = $user->cart()->create();
            }
            
            $items = $cart->items()->with('product')->get();
            
            $formattedItems = $items->map(function ($item) {
                return [
                    'id' => $item->product_id,
                    'title' => $item->product->title,
                    'price' => $item->product->price,
                    'description' => $item->product->description,
                    'quantity' => $item->quantity,
                ];
            });
            
            return response()->json(['items' => $formattedItems]);
            
        } catch (\Exception $e) {
            return response()->json(['items' => [], 'error' => $e->getMessage()], 500);
        }
    }
    
    public function addItem(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'integer|min:1|max:99',
            ]);
            
            $user = $request->user();
            $cart = $user->cart;
            
            if (!$cart) {
                $cart = $user->cart()->create();
            }
            
            $quantity = $validated['quantity'] ?? 1;
            
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $validated['product_id'])
                ->first();
            
            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $validated['product_id'],
                    'quantity' => $quantity,
                ]);
            }
            
            return response()->json([
                'message' => 'Товар добавлен в корзину',
                'cart_count' => $cart->items()->sum('quantity')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    
    public function updateQuantity(Request $request, $productId)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:0|max:99',
            ]);
            
            $cart = $request->user()->cart;
            
            if (!$cart) {
                return response()->json(['message' => 'Корзина пуста'], 404);
            }
            
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();
            
            if (!$cartItem) {
                return response()->json(['message' => 'Товар не найден в корзине'], 404);
            }
            
            if ($validated['quantity'] <= 0) {
                $cartItem->delete();
                return response()->json(['message' => 'Товар удален из корзины']);
            }
            
            $cartItem->quantity = $validated['quantity'];
            $cartItem->save();
            
            return response()->json(['message' => 'Количество обновлено']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function removeItem($productId)
    {
        try {
            $cart = request()->user()->cart;
            
            if ($cart) {
                CartItem::where('cart_id', $cart->id)
                    ->where('product_id', $productId)
                    ->delete();
            }
            
            return response()->json(['message' => 'Товар удален из корзины']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function clear(Request $request)
    {
        try {
            $cart = $request->user()->cart;
            
            if ($cart) {
                $cart->items()->delete();
            }
            
            return response()->json(['message' => 'Корзина очищена']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}