<?php
// Página de formulário de cadastro/primeiro acesso
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Primeiro Acesso - Cadastro de Senha</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body class="body-index">
  <div class="cadastro-wrapper">
    <div class="cadastro-main">
      <div class="cadastro-left">
        <h1>UNINOVE</h1>
        <div class="linha"></div>
        <p style="font-weight: bold; font-size: 25px;">Primeiro Acesso</p>
        <p>Crie sua senha seguindo os requisitos de segurança. Depois, use a tela de login para entrar.</p>
      </div>

      <div class="cadastro-right glass-box">
       
        <!-- Mensagem de erro/sucesso -->
        <?php
          $error = isset($_GET['error']) ? $_GET['error'] : '';
          $success = isset($_GET['success']) ? $_GET['success'] : '';
          $errorMessages = [
              'missing' => 'Por favor, preencha todos os campos.',
              'mismatch' => 'As senhas não conferem.',
              'weak' => 'Senha não atende aos requisitos de segurança.',
              'ra_not_found' => 'RA não encontrado na base de dados.',
              'db' => 'Erro ao conectar ao banco de dados.',
              'server' => 'Erro no servidor. Tente novamente.'
          ];
          
          if ($error && isset($errorMessages[$error])) {
              echo '<div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:4px; margin-bottom:16px; border:1px solid #f5c6cb; font-size:14px;">' . htmlspecialchars($errorMessages[$error]) . '</div>';
          }
          
          if ($success === 'password_set') {
              echo '<div style="background:#d4edda; color:#155724; padding:12px; border-radius:4px; margin-bottom:16px; border:1px solid #c3e6cb; font-size:14px;">Senha criada/atualizada com sucesso! Você já pode fazer login.</div>';
          }
        ?>
        
        <form method="POST" action="cadastro.php">
          <div>
            <label for="ra">RA:</label>
            <input type="text" id="ra" name="ra" placeholder="Digite seu RA" required />
          </div>
          
          <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua nova senha" required />
          </div>
          
          <div>
            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha" required />
          </div>
          
          <ul class="requisitos" id="requisitos">
            <li id="req-len"><span class="check">✓</span> Mínimo 8 caracteres</li>
            <li id="req-lower"><span class="check">✓</span> Pelo menos uma letra minúscula</li>
            <li id="req-upper"><span class="check">✓</span> Pelo menos uma letra maiúscula</li>
            <li id="req-num"><span class="check">✓</span> Pelo menos um número</li>
            <li id="req-spec"><span class="check">✓</span> Pelo menos um caractere especial (!@#$...)</li>
          </ul>
          <button type="submit">Criar senha e salvar</button>
          <a href="index.html" class="link-voltar">Já tenho login</a>
        </form>
      </div>
    </div>
  </div>

  <script src="js/cadastro.js"></script>
</body>
</html>
