# US0001 – Definição de Requisitos Funcionais Iniciais

**Como** Dono do Produto  
**Quero** os requisitos funcionais de gerenciamento de sócios, controle de mensalidades e cadastro de eventos  
**Para que** os desenvolvedores possam criar um protótipo funcional que atenda às necessidades administrativas do clube e proporcione organização financeira e de atividades.

---

## ✅ Critérios de Aceitação

### 📌 Gerenciar Sócios e Seus Dados

- O sistema deve permitir o cadastro de novos sócios com:
  - Nome completo
  - CPF (único)
  - Telefone
  - E-mail
  - Data de nascimento

- Deve ser possível:
  - Editar dados de sócios
  - Excluir sócios
  - Listar todos os sócios registrados

- O CPF deve ser validado e não pode se repetir.  
- O sistema deve informar ao usuário sobre o sucesso ou falha no cadastro.

---

### 📌 Controlar Mensalidades e Pagamentos

- O sistema deve registrar o pagamento da mensalidade de cada sócio.  
- Cada pagamento deve conter:
  - Identificação do sócio
  - Valor pago
  - Mês e ano de referência
  - Data do pagamento

- O sistema deve permitir:
  - Verificar se um sócio está em dia com as mensalidades
  - Gerar relatórios de inadimplência

- O sócio deve receber uma notificação ou confirmação visual após o pagamento.

---

### 📌 Cadastrar Eventos do Clube

- O administrador deve poder cadastrar eventos, informando:
  - Nome do evento
  - Data e horário
  - Local
  - Capacidade máxima de participantes

- O sistema deve:
  - Impedir conflitos de agendamento
  - Listar eventos ativos e passados
  - Permitir a inscrição de sócios nos eventos, com limite de vagas

- O evento deve mostrar:
  - Número de vagas disponíveis
  - Lista de participantes inscritos

---

