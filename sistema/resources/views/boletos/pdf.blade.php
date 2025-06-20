<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleto - {{ $boleto->numero_boleto }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        
        .boleto-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .info-label {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        .pagador {
            margin-bottom: 30px;
        }
        
        .pagador h3 {
            background-color: #2563eb;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
        }
        
        .pix-section {
            border: 2px solid #2563eb;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .pix-title {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 15px;
        }
        
        .qr-code {
            margin: 20px 0;
        }
        
        .pix-code {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
            word-break: break-all;
            font-family: monospace;
            font-size: 10px;
            margin-top: 15px;
        }
        
        .instrucoes {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #2563eb;
        }
        
        .instrucoes h4 {
            color: #2563eb;
            margin-bottom: 10px;
        }
        
        .instrucoes ul {
            margin-left: 20px;
        }
        
        .instrucoes li {
            margin-bottom: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .valor-destaque {
            font-size: 16px;
            font-weight: bold;
            color: #dc2626;
        }
        
        .vencimento-destaque {
            font-size: 14px;
            font-weight: bold;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">{{ $nomeRecebedor }}</div>
            <div>Boleto de Mensalidade</div>
        </div>

        <!-- Informações do Boleto -->
        <div class="boleto-info">
            <div class="info-row">
                <div class="info-cell info-label">Número do Boleto:</div>
                <div class="info-cell">{{ $boleto->numero_boleto }}</div>
                <div class="info-cell info-label">Data de Emissão:</div>
                <div class="info-cell">{{ $boleto->created_at->format('d/m/Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Valor:</div>
                <div class="info-cell valor-destaque">R$ {{ number_format($boleto->valor_total, 2, ',', '.') }}</div>
                <div class="info-cell info-label">Vencimento:</div>
                <div class="info-cell vencimento-destaque">{{ $boleto->data_vencimento->format('d/m/Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-cell info-label">Referência:</div>
                <div class="info-cell">Mensalidade {{ str_pad($mensalidade->mes, 2, '0', STR_PAD_LEFT) }}/{{ $mensalidade->ano }}</div>
                <div class="info-cell info-label">Status:</div>
                <div class="info-cell">{{ ucfirst($boleto->status) }}</div>
            </div>
        </div>

        <!-- Dados do Pagador -->
        <div class="pagador">
            <h3>Dados do Pagador</h3>
            <div class="boleto-info">
                <div class="info-row">
                    <div class="info-cell info-label">Nome:</div>
                    <div class="info-cell">{{ $socio->nome_completo }}</div>
                </div>
                <div class="info-row">
                    <div class="info-cell info-label">Email:</div>
                    <div class="info-cell">{{ $socio->email }}</div>
                    <div class="info-cell info-label">Telefone:</div>
                    <div class="info-cell">{{ $socio->telefone ?? 'Não informado' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-cell info-label">Endereço:</div>
                    <div class="info-cell">{{ $socio->endereco ?? 'Não informado' }}</div>
                </div>
            </div>
        </div>

        <!-- Seção PIX -->
        <div class="pix-section">
            <div class="pix-title">💳 PAGAMENTO VIA PIX</div>
            <p><strong>Escaneie o QR Code abaixo ou copie e cole o código PIX:</strong></p>
            
            <div class="qr-code">
                <img src="{{ $qrCodeImage }}" alt="QR Code PIX" style="max-width: 150px;">
            </div>
            
            <p><strong>Chave PIX:</strong> {{ $chavePix }}</p>
            
            <div class="pix-code">
                <strong>Código PIX (Copia e Cola):</strong><br>
                {{ $boleto->qr_code_pix }}
            </div>
        </div>

        <!-- Instruções -->
        <div class="instrucoes">
            <h4>📋 Instruções para Pagamento</h4>
            <ul>
                <li><strong>PIX:</strong> Escaneie o QR Code ou copie o código PIX acima</li>
                <li><strong>Prazo:</strong> Pagamento deve ser realizado até {{ $boleto->data_vencimento->format('d/m/Y') }}</li>
                <li><strong>Confirmação:</strong> O pagamento será confirmado automaticamente em até 2 horas úteis</li>
                <li><strong>Dúvidas:</strong> Entre em contato conosco através do email contato@clube.com.br</li>
                <li><strong>2ª Via:</strong> Acesse sua área do sócio para baixar uma segunda via</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>{{ $nomeRecebedor }} - CNPJ: 12.345.678/0001-91</p>
            <p>Este boleto foi gerado automaticamente em {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>Para sua segurança, verifique sempre a autenticidade deste documento</p>
        </div>
    </div>
</body>
</html>
