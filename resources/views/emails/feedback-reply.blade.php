<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ответ на ваше сообщение</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #292966; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f8f9fa; }
        .reply { background: white; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #292966; }
        .footer { text-align: center; padding: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tokyo Bloom</h1>
        </div>
        
        <div class="content">
            <h2>Здравствуйте, {{ $userName }}!</h2>
            <p>Мы получили ваше сообщение и подготовили ответ:</p>
            
            <div class="reply">
                {{ $replyText }}
            </div>
            
            <p>С уважением,<br>Команда Tokyo Bloom</p>
        </div>
        
        <div class="footer">
            <p> Это письмо отправлено автоматически Пожалуйста, не отвечайте на него.</p>
        </div>
    </div>
</body>
</html>