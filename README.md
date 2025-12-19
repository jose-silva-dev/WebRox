# Changelog

Todas as funcionalidades notáveis do projeto serão documentadas neste arquivo.

## [1.0.0] - 2025-12-18

### 🚀 Funcionalidades Adicionadas

#### 🌐 Web (Público)

- **Autenticação:** Sistema de login seguro.
- **Páginas Informativas:** Home, Informações VIP, Moedas (Coins) e Equipe (Staff).
- **Registro:** Sistema completo de cadastro de novos usuários.
- **Downloads:** Página gerenciável de links para download.
- **Rankings:**
  - Ranking Geral.
  - Busca de jogadores.
  - Filtros por slug e top.
- **Notícias:** Sistema de blog/notícias com visualização detalhada.
- **Pagamentos:** Integração de Webhooks para MercadoPago e Stripe.

#### 👤 Painel do Usuário

- **Gerenciamento de Conta:**
  - Visualização de informações da conta.
  - Atualização de E-mail.
  - Alteração de Senha.
  - Gerenciamento de Personal ID.
- **Gerenciamento de Personagens:**
  - Seleção e visualização de personagens.
  - **Alteração de Nick:** Sistema para renomear personagens.
  - **Avatar:** Upload e atualização de imagem do personagem.
  - **Teleporte/Mapas:** Sistema para mover personagem (desbugar/teleportar).
  - **Classe:** Sistema de troca de classe.
- **Interação:** Sistema de comentários em notícias.
- **Doação:**
  - Integração com MercadoPago para compra de moedas.
  - Integração com Stripe para compra de moedas.

#### 🛡️ Painel Admin

- **Dashboard:** Visão geral do sistema e estatísticas.
- **Gerenciamento de Conteúdo:**
  - **Notícias:** CRUD completo (Criar, Ler, Atualizar, Deletar).
  - **Downloads:** CRUD completo (Criar, Ler, Atualizar, Deletar).
  - **Sliders:** Gerenciamento de banners da home (Adicionar/Remover).
- **Gerenciamento de Usuários (Contas):**
  - Listagem e busca avançada de contas.
  - Visualização detalhada de conta.
  - Edição de dados da conta.
  - **Gestão de Saldos:** Adicionar/Remover moedas.
  - **Gestão VIP:** Adicionar/Remover dias VIP.
- **Gerenciamento de Personagens:**
  - Listagem e busca de personagens.
  - Visualização detalhada.
  - Edição de dados do personagem.
- **Financeiro:** Visualização de histórico de pagamentos.
