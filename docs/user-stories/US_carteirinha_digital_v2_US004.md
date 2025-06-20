# US004 – Carteirinha Digital de Sócio (v2)

## ✅ História de Usuário

**COMO** Sócio do Clube  
**QUERO** acessar minha carteirinha digital com meus dados atualizados  
**PARA** que eu possa apresentar como identificação nas dependências do clube e eventos

---

## 🎯 Critérios de Aceitação

### 📌 Visualização da Carteirinha

- A carteirinha deve conter:
  - Nome completo do sócio
  - Número de matrícula
  - Data de nascimento
  - Validade da carteirinha (1 ano após data de emissão)
  - QR Code para validação no sistema
- A carteirinha deve ser acessível na área logada do sócio.
- Deve ser possível visualizar no celular ou baixar como PDF.

### 🔒 Regras de Acesso

- Apenas sócios **ativos e adimplentes** devem poder acessar a carteirinha.
- Sócios inadimplentes verão uma mensagem de bloqueio com orientação para regularização.

### 📷 Layout

- Deve incluir a logo do clube.
- Deve possuir design limpo e responsivo (compatível com dispositivos móveis).
- QR Code deve ser gerado dinamicamente com link de validação única.

---

## 📎 Impactos

- Nova rota: `/socio/carteirinha`
- Nova view Blade: `carteirinha.blade.php`
- Atualização do model `Socio` para incluir método `isAdimplente()`
- Adição de nova biblioteca para geração de QR Codes (ex: [Simple QrCode](https://github.com/SimpleSoftwareIO/simple-qrcode))

---

## 📝 Observações

- Esta funcionalidade foi solicitada após feedback dos sócios sobre a necessidade de uma identificação digital.
- A versão física da carteirinha permanece opcional.
- Essa história foi derivada da evolução funcional da US001 (Cadastro de Sócios).

---


**Versão:** 2.0  
**Data da Última Atualização:** 2025-06-19  
**Relator:** @francielefernandes06  
