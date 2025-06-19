<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carteirinha Digital - {{ $socio->nome_completo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .carteirinha {
            width: 350px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .logo {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        .content {
            padding: 20px;
        }
        .photo {
            width: 80px;
            height: 80px;
            background: #e5e7eb;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #9ca3af;
        }
        .name {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .status {
            text-align: center;
            color: #059669;
            font-size: 12px;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-label {
            color: #6b7280;
            font-size: 12px;
        }
        .info-value {
            font-weight: 500;
            font-size: 12px;
        }
        .qr-section {
            text-align: center;
            margin: 20px 0;
        }
        .qr-code {
            border: 2px solid #e5e7eb;
            padding: 10px;
            display: inline-block;
        }
        .footer {
            background: #f9fafb;
            padding: 15px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
        .matricula {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.2);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="carteirinha">
        <div class="header">
            <div class="logo">👥</div>
            <h1 style="margin: 0; font-size: 16px;">Clube Sistema</h1>
            <p style="margin: 5px 0 0 0; font-size: 12px; opacity: 0.8;">Carteirinha Digital</p>
            <div class="matricula">
                <div style="font-size: 10px; opacity: 0.8;">Matrícula</div>
                <div style="font-weight: bold;">{{ $socio->getNumeroMatricula() }}</div>
            </div>
        </div>

        <div class="content">
            <div class="photo">👤</div>
            
            <div class="name">{{ $socio->nome_completo }}</div>
            <div class="status">✓ Sócio Ativo e Adimplente</div>

            <div class="info">
                <div class="info-row">
                    <span class="info-label">Data de Nascimento:</span>
                    <span class="info-value">{{ $socio->data_nascimento->format('d/m/Y') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">CPF:</span>
                    <span class="info-value">
                        {{ substr($socio->cpf, 0, 3) }}.{{ substr($socio->cpf, 3, 3) }}.{{ substr($socio->cpf, 6, 3) }}-{{ substr($socio->cpf, 9, 2) }}
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Válida até:</span>
                    <span class="info-value" style="color: #059669;">{{ $socio->getValidadeCarteirinha()->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="qr-section">
                <p style="margin: 0 0 10px 0; font-size: 12px; color: #6b7280;">QR Code para Validação</p>
                <div class="qr-code">
                    <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code" style="width: 100px; height: 100px;">
                </div>
                <p style="margin: 10px 0 0 0; font-size: 10px; color: #9ca3af;">Apresente este código para validação</p>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 0;">Emitida em {{ now()->format('d/m/Y H:i') }}</p>
            <p style="margin: 5px 0 0 0;">Esta carteirinha é válida apenas para sócios adimplentes</p>
        </div>
    </div>
</body>
</html>
