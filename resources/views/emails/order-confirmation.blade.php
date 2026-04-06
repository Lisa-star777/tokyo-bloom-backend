<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Подтверждение заказа</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #292966; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f8f9fa; }
        .order-items { margin: 20px 0; }
        .item { padding: 10px 0; border-bottom: 1px solid #ddd; }
        .total { font-size: 18px; font-weight: bold; text-align: right; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tokyo Bloom</h1>
            <p>Спасибо за заказ!</p>
        </div>
        
        <div class="content">
            <h2>Здравствуйте, {{ $user->name }}!</h2>
            <p>Ваш заказ №{{ $order->id }} успешно оформлен.</p>
            
            <div class="order-items">
                <h3>Состав заказа:</h3>
                @foreach($order->items as $item)
                <div class="item">
                    <strong>{{ $item['title'] }}</strong><br>
                    Количество: {{ $item['quantity'] }} шт.<br>
                    Цена: {{ number_format($item['price'] * $item['quantity'], 0, '', ' ') }} ₽
                </div>
                @endforeach
            </div>
            
            <div class="total">
                Итого: {{ number_format($order->total, 0, '', ' ') }} ₽
            </div>
            
            <p>Мы свяжемся с вами для подтверждения заказа.</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Tokyo Bloom. Все права защищены.</p>
        </div>
    </div>
</body>
</html>