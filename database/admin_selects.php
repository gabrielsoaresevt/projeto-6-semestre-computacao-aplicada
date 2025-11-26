<?php
// admin_selects.php
// Interface simples para visualizar os principais SELECTs do banco
// Uso: database/admin_selects.php?t=alunos|cursos|turmas|matriculas|logs

$host = 'localhost';
$db   = 'db_uninove';
$user = 'admin_uninove';
$pass = '123456';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo "Erro ao conectar ao banco de dados: " . htmlspecialchars($e->getMessage());
    exit;
}

$allowed = [
    'alunos' => 'Alunos',
    'cursos' => 'Cursos',
    'turmas' => 'Turmas',
    'matriculas' => 'Matriculas',
    'logs' => 'Logs_Acesso',
];

$tbl = isset($_GET['t']) ? strtolower(trim($_GET['t'])) : 'alunos';
if (!array_key_exists($tbl, $allowed)) {
    $tbl = 'alunos';
}

// Monta consultas especiais quando necessário
switch ($tbl) {
    case 'matriculas':
        $sql = "SELECT m.id_matricula, m.id_aluno_fk, a.nome AS aluno, m.id_turma_fk, t.nome_turma AS turma, t.ano_inicio, t.semestre, m.data_matricula
                FROM Matriculas m
                LEFT JOIN Alunos a ON m.id_aluno_fk = a.id_aluno
                LEFT JOIN Turmas t ON m.id_turma_fk = t.id_turma
                ORDER BY m.data_matricula DESC
                LIMIT 200";
        break;
    case 'logs':
      $sql = "SELECT l.id_log, l.ra_informado, l.data_acesso, l.ip_origem, l.resultado, l.id_aluno_fk, a.nome AS aluno
          FROM Logs_Acesso l
          LEFT JOIN Alunos a ON l.id_aluno_fk = a.id_aluno
          ORDER BY l.data_acesso DESC
          LIMIT 500";
      break;
    default:
        // Consulta simples com limite
        $tableName = $allowed[$tbl];
        $sql = "SELECT * FROM `" . str_replace('`','', $tableName) . "` LIMIT 500";
        break;
}

try {
    $stmt = $pdo->query($sql);
    $rows = $stmt->fetchAll();
} catch (Exception $e) {
    echo "Erro na consulta: " . htmlspecialchars($e->getMessage());
    exit;
}

function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

?><!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin - SELECTs do Banco</title>
  <style>
    body{font-family:Segoe UI,Arial, sans-serif; padding:18px; background:#f6f7fb; color:#222}
    header{display:flex;align-items:center;justify-content:space-between;gap:12px}
    nav a{margin-right:8px; text-decoration:none; padding:8px 12px; background:#0b73d6;color:#fff;border-radius:8px}
    nav a.active{box-shadow:0 6px 18px rgba(11,115,214,0.18)}
    table{border-collapse:collapse;width:100%;margin-top:14px;background:#fff;border-radius:8px;overflow:hidden}
    th,td{padding:8px 10px;border-bottom:1px solid #eee;text-align:left;font-size:14px}
    th{background:#f1f5f9}
    pre.sql{background:#0b1220;color:#e6f0ff;padding:10px;border-radius:6px;overflow:auto}
    .meta{margin-top:8px;color:#555}
    .small{font-size:13px;color:#666}
  </style>
</head>
<body>
  <header>
    <div>
      <h2>Admin: Consultas rápidas</h2>
      <div class="small">Tabela selecionada: <strong><?php echo h($allowed[$tbl]); ?></strong></div>
    </div>
    <nav>
      <a href="?t=alunos" class="<?php echo $tbl==='alunos' ? 'active' : '' ?>">Alunos</a>
      <a href="?t=cursos" class="<?php echo $tbl==='cursos' ? 'active' : '' ?>">Cursos</a>
      <a href="?t=turmas" class="<?php echo $tbl==='turmas' ? 'active' : '' ?>">Turmas</a>
      <a href="?t=matriculas" class="<?php echo $tbl==='matriculas' ? 'active' : '' ?>">Matriculas</a>
      <a href="?t=logs" class="<?php echo $tbl==='logs' ? 'active' : '' ?>">Logs_Acesso</a>
    </nav>
  </header>

  <section class="meta">
    <div class="small">Consulta executada:</div>
    <pre class="sql"><?php echo h($sql); ?></pre>
    <div class="small">Linhas retornadas: <?php echo count($rows); ?></div>
  </section>

  <section>
    <?php if (count($rows) === 0): ?>
      <div style="margin-top:12px;">Nenhum registro encontrado.</div>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <?php foreach (array_keys($rows[0]) as $col): ?>
              <th><?php echo h($col); ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <?php foreach ($r as $c): ?>
                <td><?php echo h($c); ?></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </section>

  <footer style="margin-top:18px;font-size:13px;color:#666">Dica: use os links acima para trocar de tabela. Se desejar exportar, use o botão direito -> salvar página como.</footer>
</body>
</html>
