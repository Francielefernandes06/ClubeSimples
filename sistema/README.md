# 🏛️ ClubeSimples

Sistema de gestão para clubes sociais, focado na organização de sócios, mensalidades e eventos.  
Este projeto foi desenvolvido com **Laravel**, **Livewire**, **Tailwind CSS** e **MySQL**.

---

## 🚀 Tecnologias Utilizadas

- [Laravel](https://laravel.com/) – Backend e estrutura MVC
- [Livewire](https://livewire.laravel.com/) – Componentes reativos sem sair do Laravel
- [Tailwind CSS](https://tailwindcss.com/) – Estilização moderna e utilitária
- [MySQL](https://www.mysql.com/) – Banco de dados relacional

---

## 📦 Funcionalidades

- Cadastro de sócios (com validação de CPF)
- Controle de mensalidades e pagamentos
- Cadastro de eventos com capacidade e agendamento
- Interface responsiva para desktop e dispositivos móveis
- Acesso restrito com autenticação

---


## 🔧 Instalação Local

```bash
# Clonar o repositório
git clone https://github.com/Francielefernandes06/ClubeSimples.git
cd ClubeSimples/sistema

# Instalar dependências PHP
composer install

# Copiar e configurar variáveis de ambiente
cp .env.example .env
php artisan key:generate

# Configurar banco de dados MySQL
# Atualizar DB_DATABASE, DB_USERNAME e DB_PASSWORD no .env

# Rodar as migrações
php artisan migrate

# Iniciar servidor de desenvolvimento
php artisan serve
