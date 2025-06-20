# RF006 – Geração de Boleto em PDF com QR Code PIX

## Objetivo

Adequar a geração de mensalidades à nova exigência da plataforma bancária, substituindo links de pagamento por arquivos PDF com QR Code.

## Funcionalidade

- O sistema deve gerar um boleto mensal em PDF com:
  - Nome do sócio
  - Valor da mensalidade
  - Data de vencimento
  - QR Code PIX com chave e valor embutido
- O boleto deve ser enviado por e-mail ao sócio e também acessível na área logada
- Os arquivos devem ser armazenados na pasta `storage/boletos/`

## Dependência

- Integração com uma biblioteca de geração de boletos/QR Code (ex: `Laravel-PDF`, `chillerlan/php-qrcode`)

## Critérios de Aceitação

- PDF gerado corretamente com informações legíveis
- QR Code válido e funcional
- Link para download visível ao sócio
- Administrador pode reemitir boleto manualmente

**Status:** Proposto  
**Data:** 2025-06-19
