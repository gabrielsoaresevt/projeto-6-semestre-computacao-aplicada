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
    header('Location: cadastro.html?error=db');
    exit;
}

// Recebe dados do formulário
$ra = isset($_POST['ra']) ? trim($_POST['ra']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$confirmar_senha = isset($_POST['confirmar_senha']) ? $_POST['confirmar_senha'] : '';

// Validações básicas
if (empty($ra) || empty($senha) || empty($confirmar_senha)) {
    header('Location: cadastro_form.php?error=missing');
    exit;
}

// Verificar se as senhas são iguais
if ($senha !== $confirmar_senha) {
    header('Location: cadastro_form.php?error=mismatch');
    exit;
}

// Validar força da senha
$errors = [];
if (strlen($senha) < 8) {
    $errors[] = 'length';
}
if (!preg_match('/[a-z]/', $senha)) {
    $errors[] = 'lowercase';
}
if (!preg_match('/[A-Z]/', $senha)) {
    $errors[] = 'uppercase';
}
if (!preg_match('/[0-9]/', $senha)) {
    $errors[] = 'number';
}
if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};:\'",.<>?\\/\\\\|`~]/', $senha)) {
    $errors[] = 'special';
}

if (!empty($errors)) {
    header('Location: cadastro_form.php?error=weak');
    exit;
}

try {
    // Verificar se o RA existe na tabela Alunos
    $stmt = $pdo->prepare('SELECT id_aluno, senha_hash FROM Alunos WHERE ra = :ra LIMIT 1');
    $stmt->execute([':ra' => $ra]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // RA não encontrado
        header('Location: cadastro_form.php?error=ra_not_found');
        exit;
    }

    // Criptografar a senha com bcrypt
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // Atualizar a senha no banco de dados (permite alteração de senhas existentes)
    $update_stmt = $pdo->prepare('UPDATE Alunos SET senha_hash = :hash WHERE ra = :ra');
    $update_stmt->execute([
        ':hash' => $senha_hash,
        ':ra' => $ra
    ]);

    // Redirecionar para a página de cadastro com mensagem de sucesso
    header('Location: cadastro_form.php?success=password_set');
    exit;

} catch (Exception $e) {
    header('Location: cadastro_form.php?error=server');
    exit;
}

?>
