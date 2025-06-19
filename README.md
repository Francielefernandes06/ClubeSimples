# ClubeSimples 🏛️

**Sistema de Gerenciamento de Clubes**

O *ClubeSimples* é uma aplicação web simples voltada para a administração de clubes recreativos. Este projeto tem como objetivo não apenas entregar uma aplicação funcional, mas também demonstrar a aplicação de boas práticas de **documentação de requisitos**, **rastreabilidade**, **qualidade de software** e **gestão de evolução**.

---

## 🔍 Objetivos

- Gerenciar sócios e seus dados
- Controlar mensalidades e pagamentos
- Cadastrar eventos do clube

---

## 📄 Documentação de Requisitos — ClubeSimples

Este diretório contém os artefatos de requisitos funcionais (RF) e não funcionais (RNF) do projeto **ClubeSimples**. Toda a documentação é versionada e segue padrões definidos para garantir rastreabilidade, clareza e alinhamento com as boas práticas de engenharia de software.

---

## 🧾 Padrão de Artefato de Requisitos

Todos os artefatos de requisitos devem ser criados no formato **Markdown (.md)**, com uma estrutura clara, concisa e rastreável. Esse padrão será utilizado durante todo o ciclo de vida do desenvolvimento.

---

## 🧾 Padrão de Nomeclatura dos Arquivos

Os arquivos de requisitos devem seguir o padrão:

`REQ_<modulo>_<ID>.md`


### 📌 Exemplos:

- `REQ_socios_RF001.md` → Cadastro de sócios  
- `REQ_eventos_RF002.md` → Agendamento de eventos  
- `REQ_participacoes_RF003.md` → Visualização de participações  
- `REQ_sistema_RNF001.md` → Acesso via navegador (requisito não funcional)

**Legenda:**
- `REQ_` → Prefixo fixo
- `<modulo>` → Nome do módulo funcional ou área do sistema
- `<ID>` → Código identificador do requisito (RF001, RNF001, etc.)

---

## 🧾 Padrão de Commits

Utilizamos a convenção Conventional Commits para padronizar o histórico e facilitar rastreabilidade:


`<tipo>: [<ID da Issue>] <descrição breve>`

### Tipos principais:
- `feat` → nova funcionalidade

- `fix` → correção de bug

- `docs` → alterações na documentação

- `refactor` → refatorações sem alteração de comportamento

- `test` → adição ou alteração de testes

- `chore` → tarefas administrativas ou de configuração

### Exemplos:

- `feat: [#1] implementar cadastro de sócios`

- `fix: [#3] corrigir validação de CPF duplicado`

- `docs: [#2] atualizar requisitos de visualização de participações`


