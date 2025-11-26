<?php
// Página de recuperação de senha
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Recuperar Senha - Uninove</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body class="body-index">
  <div class="cadastro-wrapper">
    <div class="cadastro-main">
      <div class="cadastro-left">
        <h1>UNINOVE</h1>
        <div class="linha"></div>
        <p>Recuperar Acesso</p>
        <p>Digite seu email para receber as instruções de recuperação de senha.</p>
      </div>

      <div class="cadastro-right glass-box">
        <h2 style="font-size: 20px; margin-bottom: 16px; word-wrap: break-word;">Recuperar Senha</h2>
        
        <!-- Mensagem de erro/sucesso -->
        <?php
          $error = isset($_GET['error']) ? $_GET['error'] : '';
          $success = isset($_GET['success']) ? $_GET['success'] : '';
          $errorMessages = [
              'missing' => 'Por favor, digite seu email.',
              'email_not_found' => 'Email não encontrado na base de dados.',
              'db' => 'Erro ao conectar ao banco de dados.',
              'server' => 'Erro no servidor. Tente novamente.'
          ];
          
          if ($error && isset($errorMessages[$error])) {
              echo '<div style="background:#f8d7da; color:#721c24; padding:12px; border-radius:4px; margin-bottom:16px; border:1px solid #f5c6cb; font-size:14px;">' . htmlspecialchars($errorMessages[$error]) . '</div>';
          }
          
          if ($success === 'email_sent') {
              echo '<div style="background:#d4edda; color:#155724; padding:12px; border-radius:4px; margin-bottom:16px; border:1px solid #c3e6cb; font-size:14px;">Email enviado com sucesso! Verifique sua caixa de entrada e siga as instruções.</div>';
          }
        ?>
        
        <form method="POST" action="recuperar_senha.php">
          <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Digite seu email registrado" required />
          </div>
          
          <button type="submit">Enviar Email de Recuperação</button>
          <a href="index.html" class="link-voltar">Voltar para login</a>
        </form>
      </div>
    </div>
  </div>

  <script src="js/recuperar_senha.js"></script>
</body>
</html>
