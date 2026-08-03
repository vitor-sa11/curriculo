<?php
require_once 'PHP/crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'save_perfil') {
        delete($pdo, 'dados_pessoais', '1');
        $dados = array(
            'Nome' => $_POST['Nome'],
            'cargo' => $_POST['cargo'],
            'resumo' => $_POST['resumo'],
            'info_principal' => $_POST['info_principal'],
            'imagem' => $_POST['imagem']
        );
        create($pdo, 'dados_pessoais', $dados);
    }

    if ($action === 'save_contatos') {
        delete($pdo, 'contatos', '1');
        $dados = array(
            'email' => $_POST['email'],
            'telefone' => $_POST['telefone'],
            'link' => $_POST['link']
        );
        create($pdo, 'contatos', $dados);
    }

    if ($action === 'save_formacao') {
        delete($pdo, 'formacao', '1');
        $linhas = explode("\n", $_POST['formacao_text']);
        foreach ($linhas as $linha) {
            $linha = trim($linha);
            if ($linha != '') {
                $partes = explode('|', $linha);
                if (count($partes) >= 3) {
                    $dados = array(
                        'Instituicao' => trim($partes[0]),
                        'curso' => trim($partes[1]),
                        'periodo' => trim($partes[2])
                    );
                    create($pdo, 'formacao', $dados);
                }
            }
        }
    }

    if ($action === 'save_experiencias') {
        delete($pdo, 'experiencias', '1');
        $linhas = explode("\n", $_POST['experiencias_text']);
        foreach ($linhas as $linha) {
            $linha = trim($linha);
            if ($linha != '') {
                $partes = explode('|', $linha);
                if (count($partes) >= 4) {
                    $dados = array(
                        'Empresa' => trim($partes[0]),
                        'funcao' => trim($partes[1]),
                        'periodo' => trim($partes[2]),
                        'descricao' => trim($partes[3])
                    );
                    create($pdo, 'experiencias', $dados);
                }
            }
        }
    }

    header('Location: edicao.php');
    exit;
}

$perfil = read($pdo, 'dados_pessoais', '1 LIMIT 1');
$contatos = read($pdo, 'contatos', '1 LIMIT 1');
$formacoes = readAll($pdo, 'formacao');
$experiencias = readAll($pdo, 'experiencias');

if (!$perfil) {
    $perfil = array();
}
if (!$contatos) {
    $contatos = array();
}
if (!$formacoes) {
    $formacoes = array();
}
if (!$experiencias) {
    $experiencias = array();
}

$formacao_text = "";
foreach ($formacoes as $f) {
    $formacao_text = $formacao_text . $f['Instituicao'] . '|' . $f['curso'] . '|' . $f['periodo'] . "\n";
}

$experiencias_text = "";
foreach ($experiencias as $e) {
    $experiencias_text = $experiencias_text . $e['Empresa'] . '|' . $e['funcao'] . '|' . $e['periodo'] . '|' . $e['descricao'] . "\n";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Currículo</title>
    <link rel="stylesheet" href="CSS/edicao.css">
</head>
<body>
<nav>
  <div class="container">
    <div class="brand">Editar Currículo</div>
    <ul>
      <li><a href="index.php">Voltar ao Currículo</a></li>
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
          <input type="text" name="Nome" value="<?php if(isset($perfil['Nome'])) echo htmlspecialchars($perfil['Nome']); ?>" required>

          <label>Cargo</label>
          <input type="text" name="cargo" value="<?php if(isset($perfil['cargo'])) echo htmlspecialchars($perfil['cargo']); ?>" required>

          <label>Resumo curto</label>
          <textarea name="resumo" rows="3"><?php if(isset($perfil['resumo'])) echo htmlspecialchars($perfil['resumo']); ?></textarea>

          <label>Info principal (descrição maior)</label>
          <textarea name="info_principal" rows="4" required><?php if(isset($perfil['info_principal'])) echo htmlspecialchars($perfil['info_principal']); ?></textarea>

          <label>URL da imagem</label>
          <input type="text" name="imagem" value="<?php if(isset($perfil['imagem'])) echo htmlspecialchars($perfil['imagem']); ?>">

          <div class="mt-8">
            <button type="submit">Salvar Dados</button>
          </div>
        </form>
      </section>

      <section class="card spaced">
        <h2>Formação (bulk)</h2>
        <p class="muted">Use o formato: Instituição|Curso|Período</p>
        <form method="post">
          <input type="hidden" name="action" value="save_formacao">
          <textarea name="formacao_text" rows="5"><?php echo htmlspecialchars($formacao_text); ?></textarea>
          <div class="mt-8">
            <button type="submit">Salvar Formação</button>
          </div>
        </form>
      </section>

      <section class="card spaced">
        <h2>Experiências (bulk)</h2>
        <p class="muted">Use o formato: Empresa|Função|Período|Descrição</p>
        <form method="post">
          <input type="hidden" name="action" value="save_experiencias">
          <textarea name="experiencias_text" rows="6"><?php echo htmlspecialchars($experiencias_text); ?></textarea>
          <div class="mt-8">
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
          <input type="text" name="email" value="<?php if(isset($contatos['email'])) echo htmlspecialchars($contatos['email']); ?>" required>

          <label>Telefone</label>
          <input type="text" name="telefone" value="<?php if(isset($contatos['telefone'])) echo htmlspecialchars($contatos['telefone']); ?>" required>

          <label>Link (portfólio/github)</label>
          <input type="text" name="link" value="<?php if(isset($contatos['link'])) echo htmlspecialchars($contatos['link']); ?>">

          <div class="mt-8">
            <button type="submit">Salvar Contato</button>
          </div>
        </form>
      </div>
    </aside>
  </div>
</div>
</body>
</html>