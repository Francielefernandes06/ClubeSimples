# REQ_sistema_RNF001.md

**ID**: RNF001  
**Tipo**: Requisito Não Funcional  
**Nome**: Requisitos Não Funcionais do ClubeSimples  
**Descrição**:  
- Este documento especifica os requisitos não funcionais que garantem a qualidade, segurança, desempenho, usabilidade, disponibilidade e manutenibilidade do sistema ClubeSimples.

---

## Requisitos

### Desempenho
- O sistema deve suportar até 1000 usuários simultâneos sem queda perceptível de performance.
- O tempo máximo de resposta para qualquer operação deve ser inferior a 2 segundos.

### Segurança
- Todos os dados pessoais dos sócios devem ser armazenados de forma criptografada.
- O acesso ao sistema deve ser protegido por autenticação com usuário e senha.
- As senhas devem ser armazenadas usando hash seguro (ex: bcrypt).
- O sistema deve registrar logs de acesso e alterações críticas.

### Usabilidade
- A interface deve ser responsiva e acessível em dispositivos móveis e desktops.
- O sistema deve apresentar mensagens claras para erros e confirmações.

### Disponibilidade
- O sistema deve estar disponível 99,5% do tempo durante o horário comercial (8h às 20h).
- Deve ter rotinas automáticas de backup diário dos dados.

### Manutenibilidade
- O código deve ser documentado e seguir padrões de codificação.
- As atualizações devem poder ser feitas com downtime mínimo.

---

**Justificativa**:  
- Garantir a qualidade do sistema em termos de desempenho, segurança, facilidade de uso, disponibilidade contínua e manutenção eficiente.

**Prioridade**: Alta  
**Status**: Proposto  


**Data da Última Atualização**: 2025-06-18
