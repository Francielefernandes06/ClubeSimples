# CT001 – Cadastro de Sócio com Dados Válidos

**Objetivo:**  
Verificar se o sistema permite o cadastro de um novo sócio com todos os dados válidos.

---

## Pré-condições
- Usuário autenticado como administrador.
- Acesso à tela de cadastro de sócio.

---

## Dados de Entrada

| Campo             | Valor                    |
|------------------|--------------------------|
| Nome Completo     | João da Silva            |
| CPF               | 12345678909              |
| Data de Nascimento| 1990-05-15               |
| E-mail            | joao@email.com           |
| Telefone          | (11) 91234-5678          |

---

## Passos

1. Acessar `/socios/create`.
2. Preencher todos os campos com os dados acima.
3. Clicar no botão “Cadastrar Sócio”.

---

## Resultado Esperado

- O sistema redireciona para `/socios`.
- Exibe a mensagem: `Sócio cadastrado com sucesso`.
- O novo sócio aparece na listagem com os dados informados.

---

