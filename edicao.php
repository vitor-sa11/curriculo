<?php
require_once __DIR__ . '/PHP/crud.php';

// helpers to escape output
function esc($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'save_perfil') {
        // Replace dados_pessoais with single row
        delete($pdo, 'dados_pessoais', '1');
        $data = [
            'Nome' => $_POST['Nome'] ?? '',
            'cargo' => $_POST['cargo'] ?? '',
            'resumo' => $_POST['resumo'] ?? '',
            'info_principal' => $_POST['info_principal'] ?? '',
            'imagem' => $_POST['imagem'] ?? ''
        ];
        create($pdo, 'dados_pessoais', $data);
    }

    if ($action === 'save_contatos') {
        delete($pdo, 'contatos', '1');
        $data = [
            'email' => $_POST['email'] ?? '',
            'telefone' => $_POST['telefone'] ?? '',
            'link' => $_POST['link'] ?? ''
        ];
        create($pdo, 'contatos', $data);
    }

    if ($action === 'save_formacao') {
        delete($pdo, 'formacao', '1');
        $lines = explode("\n", trim($_POST['formacao_text'] ?? ""));
        foreach ($lines as $ln) {
            $ln = trim($ln);
            if ($ln === '') continue;
            $parts = array_map('trim', explode('|', $ln));
            // Expect: Instituicao|curso|periodo
            if (count($parts) < 2) continue;
            $data = [
                'Instituicao' => $parts[0] ?? '',
                'curso' => $parts[1] ?? '',
                'periodo' => $parts[2] ?? ''
            ];
            create($pdo, 'formacao', $data);
        }
    }

    if ($action === 'save_experiencias') {
        delete($pdo, 'experiencias', '1');
        $lines = explode("\n", trim($_POST['experiencias_text'] ?? ""));
        foreach ($lines as $ln) {
            $ln = trim($ln);
            if ($ln === '') continue;
            $parts = array_map('trim', explode('|', $ln));
            // Expect: Empresa|funcao|periodo|descricao
            if (count($parts) < 2) continue;
            $data = [
                'Empresa' => $parts[0] ?? '',
                'funcao' => $parts[1] ?? '',
                'periodo' => $parts[2] ?? '',
                'descricao' => $parts[3] ?? ''
            ];
            create($pdo, 'experiencias', $data);
        }
    }

    // After handling, redirect back to main page
    header('Location: index.php');
    exit;
}

// Load current values to prefill forms
$perfil = read($pdo, 'dados_pessoais', '1 LIMIT 1');
$contatos = read($pdo, 'contatos', '1 LIMIT 1');
$formacoes = readAll($pdo, 'formacao');
$experiencias = readAll($pdo, 'experiencias');

// Build textareas for bulk edit
$formacao_text = '';
foreach ($formacoes as $f) {
    $formacao_text .= ($f['Instituicao'] ?? '') . '|' . ($f['curso'] ?? '') . '|' . ($f['periodo'] ?? '') . "\n";
}

$experiencias_text = '';
foreach ($experiencias as $e) {
    $experiencias_text .= ($e['Empresa'] ?? '') . '|' . ($e['funcao'] ?? '') . '|' . ($e['periodo'] ?? '') . '|' . ($e['descricao'] ?? '') . "\n";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Currículo</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
<nav>
  <div class="container">
    <div class="brand">Editar Currículo</div>
    <ul>
      <li><a href="index.php">Voltar</a></li>
    </ul>
  </div>
</nav>

<div class="main-wrap">
  <div class="sections">
    <div>
      <section class="card">
        <h2>Dados Pessoais</h2>
        <form method="post">
          <input type="hidden" name="action" value="save_perfil">
          <label>Nome</label>
          <input type="text" name="Nome" value="<?php echo esc($perfil['Nome'] ?? ''); ?>">
          <label>Cargo</label>
          <input type="text" name="cargo" value="<?php echo esc($perfil['cargo'] ?? ''); ?>">
          <label>Resumo curto</label>
          <textarea name="resumo" rows="3"><?php echo esc($perfil['resumo'] ?? ''); ?></textarea>
          <label>Info principal (descrição maior)</label>
          <textarea name="info_principal" rows="4"><?php echo esc($perfil['info_principal'] ?? ''); ?></textarea>
          <label>URL da imagem</label>
          <input type="text" name="imagem" value="<?php echo esc($perfil['imagem'] ?? ''); ?>">
          <div style="display:flex; gap:8px; margin-top:8px;">
            <button type="submit">Salvar Dados</button>
          </div>
        </form>
      </section>

      <section class="card" style="margin-top:12px;">
        <h2>Formação (bulk)</h2>
        <p style="color:var(--muted);">Uma linha por formação: Instituição|Curso|Período</p>
        <form method="post">
          <input type="hidden" name="action" value="save_formacao">
          <textarea name="formacao_text" rows="6"><?php echo esc($formacao_text); ?></textarea>
          <div style="display:flex; gap:8px; margin-top:8px;">
            <button type="submit">Salvar Formação</button>
          </div>
        </form>
      </section>

      <section class="card" style="margin-top:12px;">
        <h2>Experiências (bulk)</h2>
        <p style="color:var(--muted);">Uma linha por experiência: Empresa|Função|Período|Descrição</p>
        <form method="post">
          <input type="hidden" name="action" value="save_experiencias">
          <textarea name="experiencias_text" rows="8"><?php echo esc($experiencias_text); ?></textarea>
          <div style="display:flex; gap:8px; margin-top:8px;">
            <button type="submit">Salvar Experiências</button>
          </div>
        </form>
      </section>
    </div>

    <aside class="side-stack">
      <div class="card">
        <h2>Contato</h2>
        <form method="post">
          <input type="hidden" name="action" value="save_contatos">
          <label>Email</label>
          <input type="text" name="email" value="<?php echo esc($contatos['email'] ?? ''); ?>">
          <label>Telefone</label>
          <input type="text" name="telefone" value="<?php echo esc($contatos['telefone'] ?? ''); ?>">
          <label>Link (portfólio/github)</label>
          <input type="text" name="link" value="<?php echo esc($contatos['link'] ?? ''); ?>">
          <div style="display:flex; gap:8px; margin-top:8px;">
            <button type="submit">Salvar Contato</button>
          </div>
        </form>
      </div>

      <div class="card">
        <h2>Ajuda</h2>
        <p style="color:var(--muted);">Use formulários para atualizar cada área. Formações e experiências aceitam linhas no formato pedido separadas por "|".</p>
      </div>
    </aside>
  </div>
</div>

</body>
</html>