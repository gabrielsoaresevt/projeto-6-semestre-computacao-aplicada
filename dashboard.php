<?php
session_start();

// Verifica sessão
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

$dbHost = 'localhost';
$dbName = 'db_uninove';
$dbUser = 'admin_uninove';
$dbPass = '123456';

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo 'Erro ao conectar ao banco de dados.';
    exit;
}

$userId = (int) $_SESSION['user_id'];

// Busca dados acadêmicos mais recentes do aluno (última matrícula)
$stmt = $pdo->prepare(
    'SELECT a.nome AS aluno_nome, a.ra AS ra, c.nome_curso AS curso, t.nome_turma AS turma, t.periodo AS turno, t.ano_inicio, t.semestre, t.unidade
     FROM Alunos a
     LEFT JOIN Matriculas m ON a.id_aluno = m.id_aluno_fk
     LEFT JOIN Turmas t ON m.id_turma_fk = t.id_turma
     LEFT JOIN Cursos c ON t.id_curso_fk = c.id_curso
     WHERE a.id_aluno = :id
     ORDER BY m.data_matricula DESC
     LIMIT 1'
);
$stmt->execute([':id' => $userId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$nome = $_SESSION['user_name'] ?? ($row['aluno_nome'] ?? 'Aluno');
$curso = $row['curso'] ?? null;
$turma = $row['turma'] ?? null;
$turno = $row['turno'] ?? null;
$semestre = isset($row['semestre']) && $row['semestre'] !== null ? $row['semestre'] : null;
$ano = $row['ano_inicio'] ?? null;
$unidade = $row['unidade'] ?? null;

function orDash($v) {
    return ($v === null || $v === '') ? '-' : htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Painel - Uninove</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/darkmode.css">
</head>
<body class="dashboard">
  <header class="header">
    <div class="greet" id="greet">Olá, <?php echo htmlspecialchars($nome, ENT_QUOTES, 'UTF-8'); ?>! Seja bem-vindo ao Portal do Aluno UNINOVE</div>
    <div>
      <button class="btn" id="mode" type="button">Modo Escuro</button>
      <form method="POST" action="logout.php" style="display:inline;">
        <button class="btn" type="submit">Sair</button>
      </form>
    </div>
  </header>

  <!-- Card com infos -->

  <main>
      <section class="hero">
        <div>
          <h1 style="margin-bottom:6px;">Bem vindo(a) ao painel de acesso rápido!</h1>
          <div style="margin-top: 16px; font-size: 16px; color: #fff;">
            <span style="font-weight: 600;" id="info-completo">
              Curso: <?php echo orDash($curso); ?> | Unidade: <?php echo orDash($unidade); ?> | Semestre: <?php echo orDash($semestre)."º"; ?> | Turma: <?php echo orDash($turma); ?> | Turno: <?php echo orDash($turno); ?>
            </span>
          </div>
        </div>
        <div class="avatar" aria-hidden="true"></div>
      </section>
      
      <!-- Cards -->

      <div class="container" style="padding-top:22px;">
        <div style="display:flex; gap:24px; flex-wrap:wrap; justify-content:center; padding-bottom:80px;">
          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="https://i.pinimg.com/1200x/2c/0c/38/2c0c381728c6eda6c3c1f5bfe0a33406.jpg" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">Central do Aluno</div>
            <div style="color:#6b7784; font-size:14px;">Acesse aqui sua Central</div>
          </div>

          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="https://i.pinimg.com/736x/ab/17/16/ab1716d989acda36d48ca6d156606633.jpg" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">Sala do Futuro</div>
            <div style="color:#6b7784; font-size:14px;">Acesso a Sala do Futuro</div>
          </div>

          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="https://i.pinimg.com/736x/d5/85/b6/d585b6e855185a9e862151a62efedf1b.jpg" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">Calendário de Aulas</div>
            <div style="color:#6b7784; font-size:14px;">Acesso ao Calendário de Aulas</div>
          </div>

          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="https://i.pinimg.com/1200x/d3/a4/21/d3a42160f600dddd066a842e55b0731f.jpg" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">QR Code</div>
            <div style="color:#6b7784; font-size:14px;">Faça o download do seu Cartão RA</div>
          </div>

          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="./assets/aapa.png" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">AAPA</div>
            <div style="color:#6b7784; font-size:14px;">Ambiente de Apoio na Plataforma de Aprendizagem</div>
          </div>

          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="https://i.pinimg.com/736x/94/f1/75/94f17567da057505a9c0919ad22d0ea2.jpg" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">Minhas Finanças</div>
            <div style="color:#6b7784; font-size:14px;">Acesse suas informações financeiras</div>
          </div>

          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="https://aluno.uninove.br/seu/CENTRAL/aluno/assets/app/media/img/inicial/icone_biblioteca.png" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">Biblioteca Digital</div>
            <div style="color:#6b7784; font-size:14px;">Acesse sua Biblioteca Digital</div>
          </div>

          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="https://i.pinimg.com/1200x/56/c7/40/56c7400c3edf71ea976702704e7fdc1f.jpg" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">Conta Google</div>
            <div style="color:#6b7784; font-size:14px;">Redefinir senha do seu e-mail</div>
          </div>

          <div style="width:260px; background:#fff; border-radius:14px; padding:28px; box-shadow:var(--card-shadow); text-align:center;">
            <div style="margin-bottom: 16px;"><img src="https://aluno.uninove.br/seu/CENTRAL/aluno/assets/app/media/img/inicial/icone_voxy.png" style="width: 64px; height: 64px; object-fit: contain;"></div>
            <div style="font-weight:700; margin-bottom:8px;">Voxy</div>
            <div style="color:#6b7784; font-size:14px;">Acesse a plataforma do Voxy</div>
          </div>
        </div>
      </div>
    </main>

    <script src="js/dashboard.js"></script>
  </body>
</html>
