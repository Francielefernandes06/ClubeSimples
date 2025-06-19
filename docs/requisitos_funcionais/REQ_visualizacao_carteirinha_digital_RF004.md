# RF004 – Visualização da Carteirinha Digital

## 🎯 Objetivo

Permitir que sócios adimplentes visualizem e baixem sua carteirinha digital através do sistema ClubeSimples, garantindo autenticidade e praticidade na identificação em ambientes do clube e eventos.

---

## 📌 Funcionalidade

- O sistema deve disponibilizar, na área logada do sócio, uma seção chamada **"Minha Carteirinha"**.
- A carteirinha digital deve conter:
  - Nome completo do sócio
  - Matrícula (ID do sócio)
  - Data de nascimento
  - Validade da carteirinha (1 ano a partir da emissão)
  - QR Code com link para validação
- A carteirinha deve estar disponível em tela e também em formato PDF para download.

---

## 🔒 Restrições de Acesso

- Apenas sócios **ativos e adimplentes** podem visualizar ou baixar a carteirinha.
- Caso o sócio esteja inadimplente, o sistema deve exibir uma mensagem:  
  _"Sua carteirinha está indisponível devido à pendência de mensalidade. Regularize sua situação para acessar este recurso."_

---

## 📱 Requisitos de Interface

- A visualização deve ser responsiva (adaptada a dispositivos móveis).
- A versão em PDF deve seguir o mesmo layout visual da versão online.
- Deve conter a logomarca do clube e design institucional padronizado.

---

## 🛠️ Dependências

- Geração de QR Code (via biblioteca `Simple QrCode` ou equivalente).
- Verificação de status financeiro do sócio.
- Nova rota no sistema: `/socio/carteirinha`

---

## ✅ Critérios de Aceitação

- Sócios adimplentes conseguem visualizar e baixar sua carteirinha.
- Sócios inadimplentes visualizam mensagem de bloqueio.
- QR Code redireciona para URL de validação com status real do sócio.
- Layout e informações seguem o padrão estabelecido.

---

**Status:** Proposto  
**Versão:** 2.0  
**Relacionado à US:** [US004 – Carteirinha Digital de Sócio](../user-stories/US_CarteirinhaDigital_v2_US004.md)  
**Data da Criação:** 2025-06-19  
**Responsável:** @francielefernandes06
