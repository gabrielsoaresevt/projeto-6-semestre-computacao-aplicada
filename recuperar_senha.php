<?php
// Definir timezone para São Paulo/Brasil
date_default_timezone_set('America/Sao_Paulo');

// Configurações de conexão
$dbHost = 'localhost';
$dbName = 'db_uninove';
$dbUser = 'admin_uninove';
$dbPass = '123456';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    header('Location: recuperar_senha_form.php?error=db');
    exit;
}

// Recebe dados do formulário
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

// Validações básicas
if (empty($email)) {
    header('Location: recuperar_senha_form.php?error=missing');
    exit;
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: recuperar_senha_form.php?error=missing');
    exit;
}

try {
    // Verificar se o email existe na tabela Alunos
    $stmt = $pdo->prepare('SELECT id_aluno, nome, ra, email FROM Alunos WHERE email = :email LIMIT 1');
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Email não encontrado
        header('Location: recuperar_senha_form.php?error=email_not_found');
        exit;
    }

    // Gerar token de recuperação (válido por 1 hora)
    $token = bin2hex(random_bytes(32));
    $token_hash = password_hash($token, PASSWORD_BCRYPT);
    $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Salvar token no banco (nota: você precisa adicionar coluna token_recuperacao na tabela Alunos)
    // Por enquanto, apenas simulamos o envio e exibimos mensagem de sucesso
    // Em produção, você salvaria o token e enviaria por email real

    // TODO: Implementar salvamento de token na tabela
    // TODO: Implementar envio de email real com o link de recuperação

    // Redirecionar com mensagem de sucesso
    header('Location: recuperar_senha_form.php?success=email_sent');
    exit;

} catch (Exception $e) {
    header('Location: recuperar_senha_form.php?error=server');
    exit;
}

?>
