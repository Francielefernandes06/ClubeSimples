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


- **User Stories:** `docs/user-stories`
- **Requisitos Funcionais:** `docs/requisitos_funcionais`
- **Histórico de Evoluções:** `docs/historico.md`

> A documentação é atualizada **sempre que o código evolui**.

---

## 🧾 Padrão de Artefato de Requisitos

Todos os artefatos de requisitos devem ser criados no formato **Markdown (.md)**, com uma estrutura clara, concisa e rastreável. Esse padrão será utilizado durante todo o ciclo de vida do desenvolvimento.

---

## 🧾 Padrão de Nomeclatura dos Arquivos

Os arquivos de requisitos devem seguir o padrão:

`<ID>_<modulo>.md`

### 📌 Exemplos:

- `RF001_socios.md` → Cadastro de sócios  
- `RF002_eventos.md` → Agendamento de eventos  
- `RF003_participacoes.md` → Visualização de participações  
- `RNF001_sistema.md` → Acesso via navegador (requisito não funcional)

**Legenda:**
- `<ID>` → Código identificador do requisito (RF001, RNF001, etc.)
- `<modulo>` → Nome do módulo funcional ou área do sistema

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

## Como Rodar o Projeto

### 1. Clone o repositório
```
$ git clone https://github.com/Francielefernandes06/ClubeSimples.git
$ cd ClubeSimples
```

### 2. Instale as dependências (exemplo Laravel)

```
$ composer install
$ npm install && npm run dev
```

### 3. Configure o arquivo .env
```
$ cp .env.example .env
$ php artisan key:generate
```

### 4. Configure o banco de dados (no .env)
````
DB_DATABASE=clubesimples
DB_USERNAME=root
DB_PASSWORD=sua_senha
````

### 5. Execute as migrations
```
$ php artisan migrate
```

### 6. Rode o servidor local
```
$ php artisan serve
```

### Acesse no navegador:
http://localhost:8000

---

## ✅ Checklist para Contribuição

- [ ] Atualizou ou criou artefato de requisito?
- [ ] Commit vinculado ao ID do requisito?
- [ ] PR com descrição clara e documentação atualizada?

---
