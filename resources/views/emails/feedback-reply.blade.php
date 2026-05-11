<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ответ на ваше сообщение</title>
</head>
<body style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <h1 style="color: #292966;">Здравствуйте, {{ $name }}!</h1>
    
    <p>Благодарим вас за обращение в Tokyo Bloom.</p>
    
    <h3>Наш ответ:</h3>
    <p style="background-color: #f5f5f5; padding: 15px; border-radius: 8px;">
        {{ $replyText }}
    </p>
    
    <p>Если у вас остались вопросы, свяжитесь с нами снова.</p>
    
    <p style="color: #666;">С уважением,<br>Tokyo Bloom</p>
    
</body>
</html>
