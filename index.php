<?php
require_once 'PHP/crud.php';

$perfil = read($pdo, 'dados_pessoais', '1 LIMIT 1');
$contatos = read($pdo, 'contatos', '1 LIMIT 1');
$formacoes = readAll($pdo, 'formacao');
$experiencias = readAll($pdo, 'experiencias');

if (!$perfil) {$perfil = array();
}
if (!$contatos) {$contatos = array();
}
if (!$formacoes) {$formacoes = array();
}
if (!$experiencias) {$experiencias = array();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meu Currículo</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

<div class="conteudo-principal">
  <section class="card-perfil">
    <?php
    $imagem = 'https://cdn-icons-png.flaticon.com/512/12225/12225881.png';
    if (isset($perfil['imagem']) &&$perfil['imagem'] != '') {
        $imagem =$perfil['imagem'];
    }
    ?>
    <img src="<?php echo htmlspecialchars($imagem); ?>" alt="Foto de perfil">
    <div class="informacoes">
      <h1>
        <?php
        if (isset($perfil['Nome'])) {
            echo htmlspecialchars($perfil['Nome']);
        } else {
            echo 'Nome Completo';
        }
        ?>
      </h1>
      <p class="titulo">
        <?php
        if (isset($perfil['cargo'])) {
            echo htmlspecialchars($perfil['cargo']);
        } else {
            echo 'Profissão';
        }
        ?>
      </p>
      <p class="resumo-perfil">
        <?php
        if (isset($perfil['resumo'])) {
            echo nl2br(htmlspecialchars($perfil['resumo']));
        }
        ?>
      </p>
    </div>
  </section>

  <div class="secoes">
    <div>
      <section id="sobre" class="card">
        <h2>Sobre</h2>
        <p>
          <?php
          if (isset($perfil['info_principal'])) {
              echo nl2br(htmlspecialchars($perfil['info_principal']));
          } else {
              echo 'Escreva seu resumo profissional aqui.';
          }
          ?>
        </p>
      </section>

      <section id="experiencia" class="card espacado">
        <div class="linha">
          <h2>Experiência</h2>
          <a href="./adicionar_experiencia.php">
            <button class="adicionar">+</button>
          </a>
        </div>
        <?php if (count($experiencias) > 0) { ?>
          <ul class="lista">
            <?php foreach ($experiencias as$exp) { ?>
              <li>
                <strong><?php echo htmlspecialchars($exp['Empresa']); ?></strong> — <?php echo htmlspecialchars($exp['funcao']); ?>
                <div class="metadados">
                  <?php echo htmlspecialchars($exp['periodo']); ?>
                </div>
                <?php if (isset($exp['descricao']) &&$exp['descricao'] != '') { ?>
                    <div class="descricao">
                      <?php echo htmlspecialchars($exp['descricao']); ?>
                    </div>
                <?php } ?>
              </li>
            <?php } ?>
          </ul>
        <?php } else { ?>
          <p class="suave">Nenhuma experiência cadastrada.</p>
        <?php } ?>
      </section>

      <section id="formacao" class="card espacado">
        <div class="linha">
          <h2>Formação</h2>
          <a href="./adicionar_formacao.php">
            <button class="adicionar">+</button>
          </a>
        </div>
        <?php if (count($formacoes) > 0) { ?>
          <ul class="lista">
            <?php foreach ($formacoes as$f) { ?>
              <li>
                <strong><?php echo htmlspecialchars($f['Instituicao']); ?></strong>
                <div>
                  <?php echo htmlspecialchars($f['curso']); ?> —
                  <span class="suave">
                    <?php echo htmlspecialchars($f['periodo']); ?>
                  </span>
                </div>
              </li>
            <?php } ?>
          </ul>
        <?php } else { ?>
          <p class="suave">Nenhuma formação cadastrada.</p>
        <?php } ?>
      </section>
    </div>

    <aside class="coluna-lateral">
      <div class="card">
        <h2>Contato</h2>
        <p class="suave">Email:
          <?php
          if (isset($contatos['email'])) {
              echo htmlspecialchars($contatos['email']);
          } else {
              echo 'seu@email.com';
          }
          ?>
        </p>
        <p class="suave">Telefone:
          <?php
          if (isset($contatos['telefone'])) {
              echo htmlspecialchars($contatos['telefone']);
          } else {
              echo '(00) 00000-0000';
          }
          ?>
        </p>
        <?php if (isset($contatos['link']) &&$contatos['link'] != '') { ?>
            <p>
              <a href="<?php echo htmlspecialchars($contatos['link']); ?>" target="_blank">Link/Portfólio</a>
            </p>
        <?php } ?>
      </div>
      <div class="card">
        <h2>Ações</h2>
        <a href="edicao.php"><button class="editar">Editar conteúdo</button></a>
      </div>
    </aside>
  </div>
</div>
</body>
</html>