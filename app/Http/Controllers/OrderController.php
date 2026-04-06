<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($orders);
    }
    
    public function store(Request $request)
    {
        try {
            $user = $request->user();
            
            // Получаем корзину пользователя
            $cart = $user->cart;
            
            if (!$cart || $cart->items->count() === 0) {
                return response()->json(['message' => 'Корзина пуста'], 400);
            }
            
            // Формируем список товаров
            $items = [];
            $subtotal = 0;
            
            foreach ($cart->items as $item) {
                $items[] = [
                    'id' => $item->product_id,
                    'title' => $item->product->title,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ];
                $subtotal += $item->product->price * $item->quantity;
            }
            
            $deliveryCost = $subtotal > 5000 ? 0 : 300;
            $certificateDiscount = $request->input('certificateUsed.discount', 0);
            $bonusesUsed = $request->input('bonusesUsed', 0);
            
            $total = $subtotal + $deliveryCost - $certificateDiscount - $bonusesUsed;
            if ($total < 0) $total = 0;
            
            $bonusesEarned = floor($subtotal * 0.1);
            
            // Создаем заказ
            $order = Order::create([
                'user_id' => $user->id,
                'items' => $items,
                'subtotal' => $subtotal,
                'delivery_cost' => $deliveryCost,
                'certificate_discount' => $certificateDiscount,
                'bonuses_used' => $bonusesUsed,
                'total' => $total,
                'bonuses_earned' => $bonusesEarned,
                'certificate_used' => $request->input('certificateUsed'),
                'delivery_details' => $request->input('deliveryDetails'),
                'status' => 'new',
                'status_text' => 'Новый',
            ]);

            // Отправка email
                try {
                    Mail::to($user->email)->send(new OrderConfirmation($order, $user));
                    \Log::info('Email отправлен на ' . $user->email);
                } catch (\Exception $e) {
                    \Log::error('Ошибка отправки email: ' . $e->getMessage());
                }
            
            // Обновляем бонусы пользователя
            $user->bonuses = $user->bonuses - $bonusesUsed + $bonusesEarned;
            $user->save();
            
            // Очищаем корзину
            $cart->items()->delete();
            
            return response()->json($order, 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }
        return response()->json($order);
    }
}