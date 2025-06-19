# RN_ClubeSimples_RN001.md

**ID**: RN001  
**Tipo**: Regra de Negócio  
**Nome**: Regras de Negócio do ClubeSimples  
**Descrição**:  
- Este documento define as regras de negócio essenciais que devem ser respeitadas pelo sistema ClubeSimples, visando o correto funcionamento das rotinas administrativas do clube e o cumprimento das políticas internas.

---

## Cadastro de Sócios

- O CPF do sócio deve ser **único** e **válido** conforme a regra oficial brasileira.
- Sócios **inadimplentes há mais de 3 meses** não podem se inscrever em eventos.
- Sócios **menores de idade** só podem ser cadastrados mediante inclusão de autorização do responsável legal.

---

## Mensalidades

- A mensalidade deve ser paga **até o dia 10 de cada mês**.
- Pagamentos realizados **após o dia 10** devem ter **multa de 2%** aplicada automaticamente.
- Sócios com mensalidades em **atraso superior a 60 dias** terão o **acesso bloqueado** até a regularização da situação financeira.

---

## Eventos

- Somente **administradores** podem cadastrar ou editar eventos no sistema.
- Um **mesmo local** não pode ser reservado para **dois eventos no mesmo horário**.
- A **capacidade máxima** de um evento deve ser respeitada e, ao ser atingida, **novas inscrições devem ser bloqueadas** automaticamente.

---

**Justificativa**:  
- Garantir que o sistema siga as políticas administrativas, regras financeiras e critérios de organização de eventos do clube, evitando conflitos, inadimplência e comportamentos indevidos.

**Prioridade**: Alta  
**Status**: Proposto


Data da Última Atualização: 2025-06-18
