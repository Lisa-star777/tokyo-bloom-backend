<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ваш подарочный сертификат</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #292966; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f8f9fa; }
        .certificate-card { 
            background: white; 
            padding: 20px; 
            border-radius: 12px; 
            border: 2px solid #A3A3CC;
            margin: 20px 0;
            text-align: center;
        }
        .certificate-code { 
            font-size: 24px; 
            font-weight: bold; 
            color: #292966;
            letter-spacing: 2px;
        }
        .certificate-value { 
            font-size: 32px; 
            color: #292966;
            font-weight: bold;
            margin: 15px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .footer { text-align: center; padding: 20px; color: #666; }
        .note { background: #fff3cd; padding: 10px; border-radius: 8px; margin-top: 15px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tokyo Bloom</h1>
            <p>Ваш подарочный сертификат</p>
        </div>
        
        <div class="content">
            <h2>Здравствуйте, {{ $user->name }}!</h2>
            <p>Спасибо за покупку! Ваш подарочный сертификат готов к использованию.</p>
            
            <div class="certificate-card">
                <div class="certificate-code">{{ $certificate->code }}</div>
                <div class="certificate-value">{{ number_format($certificate->value, 0, '', ' ') }} ₽</div>
                
                <div class="info-row">
                    <span>Номинал:</span>
                    <span><strong>{{ number_format($certificate->value, 0, '', ' ') }} ₽</strong></span>
                </div>
                <div class="info-row">
                    <span>Срок действия:</span>
                    <span>{{ \Carbon\Carbon::parse($certificate->expires_at)->format('d.m.Y') }}</span>
                </div>
                <div class="info-row">
                    <span>Статус:</span>
                    <span style="color: green;">Активен</span>
                </div>
            </div>
            
            <p>Как использовать сертификат:</p>
            <ol>
                <li>Скопируйте код сертификата: <strong>{{ $certificate->code }}</strong></li>
                <li>При оформлении заказа введите код в поле "Подарочный сертификат"</li>
                <li>Сумма заказа будет автоматически уменьшена на номинал сертификата</li>
            </ol>
            
            <div class="note">
                Сохраните этот код! Он понадобится для активации сертификата при заказе.
            </div>
        </div>
        
        <div class="footer">
            <p>Это письмо отправлено автоматически Пожалуйста, не отвечайте на него.</p>
        </div>
    </div>
</body>
</html>