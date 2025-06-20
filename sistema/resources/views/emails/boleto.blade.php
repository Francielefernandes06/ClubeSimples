<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto de Mensalidade</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .highlight {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2563eb;
        }
        .button {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏛️ Clube Exemplo</h1>
        <p>Boleto de Mensalidade</p>
    </div>

    <div class="content">
        <h2>Olá, {{ $socio->nome_completo }}!</h2>
        
        <p>Seu boleto de mensalidade está disponível para pagamento.</p>

        <div class="highlight">
            <h3>📄 Detalhes do Boleto</h3>
            <p><strong>Número:</strong> {{ $boleto->numero_boleto }}</p>
            <p><strong>Referência:</strong> Mensalidade {{ str_pad($mensalidade->mes, 2, '0', STR_PAD_LEFT) }}/{{ $mensalidade->ano }}</p>
            <p><strong>Valor:</strong> <span style="color: #dc2626; font-size: 18px; font-weight: bold;">R$ {{ number_format($boleto->valor_total, 2, ',', '.') }}</span></p>
            <p><strong>Vencimento:</strong> <span style="color: #dc2626; font-weight: bold;">{{ $boleto->data_vencimento->format('d/m/Y') }}</span></p>
        </div>

        <div class="highlight">
            <h3>💳 Formas de Pagamento</h3>
            <p><strong>PIX:</strong> Abra o PDF em anexo e escaneie o QR Code ou copie o código PIX</p>
            <p><strong>Vantagem:</strong> Pagamento instantâneo e confirmação automática</p>
        </div>

        <p>O boleto em PDF está anexado a este email. Você também pode acessar sua área do sócio para baixar uma segunda via a qualquer momento.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/socio/mensalidades') }}" class="button">
                🔐 Acessar Área do Sócio
            </a>
        </div>

        <div class="highlight">
            <h3>⚠️ Importante</h3>
            <ul>
                <li>Mantenha seus dados atualizados</li>
                <li>Em caso de dúvidas, entre em contato conosco</li>
                <li>O pagamento via PIX é confirmado automaticamente</li>
                <li>Após o vencimento, poderão ser aplicadas multas</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p>Este é um email automático, não responda.</p>
        <p>📧 contato@clube.com.br | 📞 (11) 1234-5678</p>
        <p>Clube Exemplo - Todos os direitos reservados</p>
    </div>
</body>
</html>
