<?php
require_once __DIR__ . '/PHP/crud.php';

// Fetch data from DB (use sensible defaults if empty)
$perfil = read($pdo, 'dados_pessoais', '1 LIMIT 1');
$contatos = read($pdo, 'contatos', '1 LIMIT 1');
$formacoes = readAll($pdo, 'formacao');
$experiencias = readAll($pdo, 'experiencias');

function esc($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Currículo</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link rel="icon" href="imagens/icon.png" type="image/x-icon">
</head>
<body>
<nav>
  <div class="container">
    <div class="brand">Meu Currículo</div>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="#sobre">Sobre</a></li>
      <li><a href="#projetos">Projetos</a></li>
      <li><a href="edicao.php">Editar</a></li>
    </ul>
  </div>
</nav>

<div class="main-wrap">
  <section class="profile-card">
    <img src="<?php echo esc($perfil['imagem'] ?? 'imagens/perfil.jpg'); ?>" alt="Foto de perfil">
    <div class="info">
      <h1><?php echo esc($perfil['Nome'] ?? 'Nome Completo'); ?></h1>
      <p class="title"><?php echo esc($perfil['cargo'] ?? 'Profissão'); ?></p>
      <p class="blurb"><?php echo nl2br(esc($perfil['resumo'] ?? ($perfil['info_principal'] ?? ''))); ?></p>
    </div>
  </section>

  <div class="sections">
    <div>
      <section id="sobre" class="card">
        <h2>Sobre</h2>
        <p><?php echo nl2br(esc($perfil['info_principal'] ?? 'Escreva aqui um resumo profissional que destaque suas habilidades e objetivos.')); ?></p>
      </section>

      <section id="experiencia" class="card" style="margin-top:12px;">
        <h2>Experiência</h2>
        <?php if (!empty($experiencias)): ?>
          <ul class="list">
            <?php foreach ($experiencias as $exp): ?>
              <li>
                <strong><?php echo esc($exp['Empresa']); ?></strong> — <?php echo esc($exp['funcao']); ?>
                <div style="color:var(--muted); font-size:0.95rem"><?php echo esc($exp['periodo']); ?></div>
                <?php if (!empty($exp['descricao'])): ?><div style="margin-top:6px; color:var(--muted);"><?php echo esc($exp['descricao']); ?></div><?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="muted">Nenhuma experiência cadastrada.</p>
        <?php endif; ?>
      </section>

      <section id="formacao" class="card" style="margin-top:12px;">
        <h2>Formação</h2>
        <?php if (!empty($formacoes)): ?>
          <ul class="list">
            <?php foreach ($formacoes as $f): ?>
              <li>
                <strong><?php echo esc($f['Instituicao']); ?></strong>
                <div><?php echo esc($f['curso']); ?> — <span style="color:var(--muted);"><?php echo esc($f['periodo']); ?></span></div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="muted">Nenhuma formação cadastrada.</p>
        <?php endif; ?>
      </section>
    </div>

    <aside class="side-stack">
      <div class="card">
        <h2>Contato</h2>
        <p style="color:var(--muted)">Email: <?php echo esc($contatos['email'] ?? 'seu@email.com'); ?></p>
        <p style="color:var(--muted)">Telefone: <?php echo esc($contatos['telefone'] ?? '(00) 0 0000-0000'); ?></p>
        <?php if (!empty($contatos['link'])): ?><p><a href="<?php echo esc($contatos['link']); ?>" target="_blank">Link/Portfólio</a></p><?php endif; ?>
      </div>

      <div class="card">
        <h2>Projetos</h2>
        <p style="color:var(--muted);">Adicione projetos na página de edição.</p>
      </div>

      <div class="card">
        <h2>Ações</h2>
        <a href="edicao.php"><button>Editar conteúdo</button></a>
      </div>
    </aside>
  </div>

  <footer>
    <small>Feito com PHP • Visualizado localmente</small>
  </footer>
</div>
</body>
</html>