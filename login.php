<?php
session_start();

// Definir timezone para São Paulo/Brasil
date_default_timezone_set('America/Sao_Paulo');

// Configurações de conexão (ajuste se necessário)
$dbHost = 'localhost';
$dbName = 'db_uninove';
$dbUser = 'admin_uninove';
$dbPass = '123456';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    // Não exibir detalhes em produção
    header('Location: index.html?error=db');
    exit;
}

// Recebe dados do formulário
$ra = isset($_POST['ra']) ? trim($_POST['ra']) : '';
$cpf = isset($_POST['cpf']) ? trim($_POST['cpf']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

$identifier = '';
if (!empty($ra)) {
    $identifier = $ra;
} elseif (!empty($cpf)) {
    $identifier = $cpf;
}

if (empty($identifier) || empty($senha)) {
    header('Location: index.html?error=missing');
    exit;
}

try {
    // Buscar aluno por RA, CPF ou email
    $stmt = $pdo->prepare('SELECT id_aluno, nome, ra, email, senha_hash FROM Alunos WHERE ra = :id OR cpf = :id OR email = :id LIMIT 1');
    $stmt->execute([':id' => $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obter IP real (considerando proxies)
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    $ip = trim($ip);
    
    // Normalizar IPv6 localhost para IPv4
    if ($ip === '::1') {
        $ip = '127.0.0.1';
    }

    // Data e hora em São Paulo
    $dataAcesso = date('Y-m-d H:i:s');

    // Verificação flexível de senha:
    // - se o hash armazenado for bcrypt ($2y$|$2a$|$2b$) usamos password_verify()
    // - se não for, tentamos comparar como texto simples e, se corresponder,
    //   re-hashamos com bcrypt e atualizamos o registro (migração automática)
    $loginSuccess = false;
    $storedHash = $user['senha_hash'] ?? '';

    if ($user) {
        $isBcrypt = ($storedHash && (substr($storedHash, 0, 4) === '$2y$' || substr($storedHash, 0, 4) === '$2a$' || substr($storedHash, 0, 4) === '$2b$'));

        if ($isBcrypt) {
            if (password_verify($senha, $storedHash)) {
                $loginSuccess = true;
            }
        } else {
            // Possível senha em texto simples ou hash de outro formato
            if ($storedHash !== '' && hash_equals($storedHash, $senha)) {
                // Atualiza para hash bcrypt seguro
                $newHash = password_hash($senha, PASSWORD_BCRYPT);
                $upd = $pdo->prepare('UPDATE Alunos SET senha_hash = :h WHERE id_aluno = :id');
                $upd->execute([':h' => $newHash, ':id' => $user['id_aluno']]);
                $loginSuccess = true;
            }
        }
    }

    if ($loginSuccess) {
        // Login bem-sucedido
        $_SESSION['user_id'] = $user['id_aluno'];
        $_SESSION['user_name'] = $user['nome'];

        // Grava log de sucesso
        $logStmt = $pdo->prepare('INSERT INTO Logs_Acesso (ra_informado, data_acesso, ip_origem, resultado, id_aluno_fk) VALUES (:ra, :data, :ip, :resultado, :id_aluno)');
        $logStmt->execute([
            ':ra' => $identifier,
            ':data' => $dataAcesso,
            ':ip' => $ip,
            ':resultado' => 'Sucesso',
            ':id_aluno' => $user['id_aluno']
        ]);

        header('Location: dashboard.php');
        exit;
    } else {
        // Grava log de falha (id_aluno pode ser NULL)
        $idAluno = $user ? $user['id_aluno'] : null;
        $logStmt = $pdo->prepare('INSERT INTO Logs_Acesso (ra_informado, data_acesso, ip_origem, resultado, id_aluno_fk) VALUES (:ra, :data, :ip, :resultado, :id_aluno)');
        $logStmt->execute([
            ':ra' => $identifier,
            ':data' => $dataAcesso,
            ':ip' => $ip,
            ':resultado' => 'Falha',
            ':id_aluno' => $idAluno
        ]);

        header('Location: index.html?error=invalid');
        exit;
    }

} catch (Exception $e) {
    header('Location: index.html?error=server');
    exit;
}

?>
