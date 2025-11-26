# 🎓 Portal do Aluno UNINOVE - Plataforma de Autenticação Aprimorada

**Projeto apresentado no curso de Bacharelado em Ciência da Computação**  
*Disciplina: Projeto em Computação Aplicada*

---

## 📑 Índice

1. [Introdução](#introdução)
2. [Tecnologias Empregadas](#tecnologias-empregadas)
3. [Correção Crítica de Segurança](#correção-crítica-de-segurança)
4. [Aprimoramentos Implementados](#aprimoramentos-implementados)
5. [Funcionalidades Principais](#funcionalidades-principais)
6. [Estrutura do Projeto](#estrutura-do-projeto)
7. [Instalação e Configuração](#instalação-e-configuração)
8. [Como Usar](#como-usar)
9. [Segurança e Boas Práticas](#segurança-e-boas-práticas)

---

## Introdução

O **Portal do Aluno UNINOVE** é uma réplica funcional e otimizada do sistema de login institucional da universidade. O projeto visa não apenas replicar a interface de usuário, mas fundamentalmente **corrigir falhas críticas de segurança** identificadas no processo de validação de credenciais, além de implementar melhorias na experiência visual e usabilidade.

O objetivo principal é demonstrar a aplicação prática de conceitos de **desenvolvimento web full-stack** e **boas práticas de segurança**, resultando em uma solução mais robusta e confiável para o gerenciamento de acesso de usuários.

---

## Tecnologias Empregadas

| Componente | Tecnologia | Função no Projeto |
|-----------|-----------|------------------|
| **Frontend (Estrutura)** | HTML5 | Definição da estrutura e conteúdo das páginas |
| **Frontend (Estilização)** | CSS3 | Estilos visuais, layout responsivo e modo dark |
| **Frontend (Interatividade)** | JavaScript (ES6+) | Validações de formulário e manipulação dinâmica da interface |
| **Backend (Lógica)** | PHP 7.4+ | Processamento de requisições, autenticação e gerenciamento de sessões |
| **Banco de Dados** | MySQL 5.7+ | Persistência de dados de usuários, matrículas e logs de acesso |
| **Segurança** | bcrypt (PASSWORD_BCRYPT) | Criptografia de senhas com hash unidirecional |

---

## Correção Crítica de Segurança

### 🔐 Sensibilidade de Senha (Case-Sensitivity)

A falha de segurança mais relevante identificada no sistema original reside na **insensibilidade de maiúsculas e minúsculas** durante o processo de login. Embora a política de criação de senha exija a inclusão de caracteres em caixa alta e baixa, o sistema aceitava a credencial independentemente da capitalização utilizada.

#### Melhoria Implementada

A nova plataforma garante que a validação da senha seja **estritamente sensível a maiúsculas e minúsculas**. Isso foi alcançado através de:

- **Criptografia com bcrypt**: Utiliza o algoritmo `PASSWORD_BCRYPT` do PHP, que mantém a sensibilidade a maiúsculas/minúsculas na hash
- **Validação via `password_verify()`**: Compara a senha fornecida com a hash armazenada, mantendo a case-sensitivity
- **Configuração correta do SQL**: Garante que a comparação no banco de dados respeite a capitalização

**Exemplo Prático:**
```
Senha original criada: Senha123!@#
✅ Aceita:  Senha123!@#
❌ Rejeita: senha123!@#
❌ Rejeita: SENHA123!@#
```

#### Impacto da Melhoria

A implementação da sensibilidade de senha **eleva significativamente o nível de segurança** do sistema:
- ↑ Aumenta a entropia da senha
- ↓ Reduz vulnerabilidade a ataques de força bruta
- ↓ Reduz vulnerabilidade a ataques de dicionário
- ✓ Força o usuário a fornecer a combinação exata de caracteres

---

## Aprimoramentos Implementados

### 1. **Criptografia Robusta de Senhas**

Implementação do **bcrypt** como padrão para armazenamento seguro de senhas:

```php
// Criação de senha
$hash = password_hash($senha, PASSWORD_BCRYPT);
// Inserir $hash no banco de dados

// Validação de senha
if (password_verify($senha_fornecida, $hash_armazenada)) {
    // Senha correta
}
```

**Vantagens:**
- Hash unidirecional (impossível reverter)
- Incorpora salt automático
- Resistente a ataques de dicionário
- Adaptável a futuras melhorias computacionais

### 2. **Interface Moderna e Responsiva**

- Design limpo com cores harmoniosas
- Layout responsivo para desktop e mobile
- **Modo Dark/Light**: Toggle automático com persistência via localStorage
- Animações suaves e feedback visual

### 3. **Validação em Tempo Real**

- Requisitos de senha exibidos dinamicamente com checks (✓) conforme atendidos
- Validação de CPF com formatação automática (XXX.XXX.XXX-XX)
- Feedback de correspondência de senhas (verde/vermelho)
- Mensagens de erro contextualizadas

### 4. **Autenticação Flexível**

- Login via **RA** (Registro Acadêmico)
- Login via **CPF**
- Login via **Email**
- Sistema de recuperação de senha

### 5. **Gestão de Sessões Segura**

- Sessões serverside com PHP
- Verificação obrigatória em cada página protegida
- Logout com destruição completa de sessão
- Normalização de IP (suporta proxies e IPv6)

### 6. **Logging e Auditoria**

- Registro de todos os acessos (sucesso/falha) em `Logs_Acesso`
- Captura de IP de origem
- Timestamp com timezone correto (America/Sao_Paulo)
- Identificação do aluno quando disponível

---

## Funcionalidades Principais

### 🔑 Autenticação
- ✅ Login com RA/CPF/Email
- ✅ Validação de credenciais com bcrypt
- ✅ Logout com limpeza de sessão
- ✅ Recuperação de senha

### 📝 Registro e Primeiro Acesso
- ✅ Criação de senha com requisitos customizados
- ✅ Validação de força de senha em tempo real
- ✅ Reatribuição de senha para usuários existentes
- ✅ Confirmação de senha com feedback visual

### 📊 Dashboard do Aluno
- ✅ Exibição de dados acadêmicos (Curso, Turma, Turno, Semestre)
- ✅ Informações da unidade e matrícula
- ✅ Interface clara e amigável
- ✅ Modo dark/light toggle

### 🛠️ Admin / Visualização de Dados
- ✅ Interface `database/admin_selects.php` para consultas rápidas
- ✅ Visualização de tabelas: Alunos, Cursos, Turmas, Matrículas, Logs
- ✅ Query builder visual com limite de 500 registros

---

## Estrutura do Projeto

```
projeto-6-semestre-computacao-aplicada/
├── index.html                    # Página de login
├── dashboard.php                 # Painel do aluno (requer autenticação)
├── cadastro_form.php             # Formulário de primeira senha
├── recuperar_senha_form.php       # Formulário de recuperação
│
├── login.php                      # Backend: validação de login
├── logout.php                     # Backend: encerramento de sessão
├── cadastro.php                   # Backend: criação/update de senha
├── recuperar_senha.php            # Backend: validação de email
│
├── database/
│   ├── conexao.php               # Configuração de conexão (legacy)
│   ├── db_uninove.sql            # Schema e dados iniciais
│   └── admin_selects.php          # Interface de consultas (admin)
│
├── js/
│   ├── login.js                   # Toggle RA/CPF, formatação CPF
│   ├── cadastro.js                # Validação de senha em tempo real
│   ├── dashboard.js               # Toggle dark mode
│   └── recuperar_senha.js          # Validação de email
│
├── css/
│   └── style.css                  # Estilos globais (HTML + dark mode)
│
├── Midia/
│   └── bg-main.jpg                # Imagem de fundo
│
└── README.md                       # Este arquivo
```

---

## Instalação e Configuração

### Pré-requisitos
- **XAMPP** (Apache + MySQL + PHP) ou servidor equivalente
- **PHP 7.4+**
- **MySQL 5.7+**
- **Navegador moderno** (Chrome, Firefox, Safari, Edge)

### Passos de Instalação

1. **Clone o repositório** ou baixe os arquivos para:
   ```
   C:\xampp\htdocs\projeto-6-semestre-computacao-aplicada\
   ```

2. **Importe o banco de dados:**
   - Abra **phpMyAdmin** (http://localhost/phpmyadmin)
   - Importe o arquivo `database/db_uninove.sql`

3. **Inicie os serviços:**
   - Abra XAMPP Control Panel e clique em "Start" para Apache e MySQL

4. **Acesse a aplicação:**
   - Local: `http://localhost/projeto-6-semestre-computacao-aplicada/`
   - Online (ngrok): `https://<seu-ngrok-url>/projeto-6-semestre-computacao-aplicada/`

---

## Como Usar

### 🔓 Fazer Login

1. Acesse `index.html`
2. Escolha **RA** ou **CPF** como método de acesso
3. Insira suas credenciais:
   - **RA**: `101010` (exemplo)
   - **CPF**: `04479860312` (formato automático para `044.798.603-12`)
   - **Senha**: A definida no cadastro
4. Clique em **"Entrar"**

### 📝 Primeiro Acesso / Criar Senha

1. Na página de login, clique em **"Primeira vez?"**
2. Preencha o formulário de cadastro:
   - **RA**: Digite seu número de RA
   - **Senha**: Siga os requisitos (8+ caracteres, maiúscula, minúscula, número, especial)
   - **Confirmar**: Repita a senha
3. Os requisitos aparecem dinamicamente com **checks verdes** conforme atendidos
4. Clique em **"Criar senha e salvar"**

### 🔄 Recuperar Senha

1. Na página de login, clique em **"Esqueci a senha"**
2. Insira seu email cadastrado
3. Um email de recuperação será enviado (função de email pode ser implementada)

### 📊 Visualizar Dados (Admin)

Acesse: `/database/admin_selects.php?t=[alunos|cursos|turmas|matriculas|logs]`

Exemplo:
```
http://localhost/projeto-6-semestre-computacao-aplicada/database/admin_selects.php?t=logs
```

**Tabelas disponíveis:**
- `alunos` - Usuários do sistema
- `cursos` - Cursos oferecidos
- `turmas` - Turmas e suas informações
- `matriculas` - Matrículas de alunos em turmas
- `logs` - Histórico de acessos (IP, resultado, timestamp)

---

## Segurança e Boas Práticas

### 🛡️ Medidas de Segurança Implementadas

| Medida | Implementação |
|--------|---------------|
| **Criptografia de Senha** | bcrypt com PASSWORD_BCRYPT |
| **Case-Sensitivity** | Senhas respeitam maiúsculas/minúsculas |
| **SQL Injection** | Prepared statements com placeholders (`:param`) |
| **Sessões Seguras** | `session_start()` + validação serverside |
| **XSS Protection** | `htmlspecialchars()` em todas as saídas |
| **CSRF Tokens** | Possível implementação futura (POST verificado) |
| **IP Logging** | Captura e normalização de IP de origem |
| **Timezone Seguro** | `America/Sao_Paulo` para auditoria correta |

### 📋 Requisitos de Senha

Toda senha deve conter:
- ✓ Mínimo **8 caracteres**
- ✓ Pelo menos **1 letra minúscula** (a-z)
- ✓ Pelo menos **1 letra maiúscula** (A-Z)
- ✓ Pelo menos **1 número** (0-9)
- ✓ Pelo menos **1 caractere especial** (!@#$%^&*...)

### 🔍 Validação em Dois Níveis

1. **Cliente (JavaScript):**
   - Validações de formato
   - Feedback visual em tempo real
   - Economia de requisições HTTP

2. **Servidor (PHP):**
   - Re-validação obrigatória
   - Nunca confiar apenas em dados do cliente
   - Lógica de negócio segura

### 🗄️ Dados Demonstrativos

O banco vem pré-carregado com dados para testes:

**Alunos disponíveis:**
| RA | Nome | Email |
|----|------|-------|
| 101010 | Ana Silva | ana.silva@email.com |
| 202020 | Bruno Costa | bruno.costa@email.com |
| 303030 | Carla Dias | carla.dias@email.com |

---

## 📌 Próximas Melhorias (Futuro)

- [ ] Implementar envio real de emails para recuperação de senha
- [ ] Token-based password reset com expiração
- [ ] Two-Factor Authentication (2FA)
- [ ] Rate limiting para prevenir força bruta
- [ ] Dashboard administrativo com gráficos de acesso
- [ ] Suporte a OAuth2 (Google, Microsoft)
- [ ] API REST para integração com aplicativos

---

## 👨‍💻 Desenvolvimento

**Desenvolvido por:** Alunos do Bacharelado em Ciência da Computação  
**Instituição:** UNINOVE  
**Disciplina:** Projeto em Computação Aplicada  
**Data:** Novembro de 2025  
**Branch:** `release/gabrielsoaresevt`

---

## 📄 Licença

Este projeto é fornecido para fins educacionais.

---

## 📞 Suporte

Para dúvidas ou sugestões sobre o projeto, entre em contato com a equipe de desenvolvimento ou abra uma issue no repositório.

---

**Última atualização:** 26 de novembro de 2025