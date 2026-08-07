<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Formação</title>
    <link rel="stylesheet" href="CSS/edicao.css">
</head>
<body>
    <a href="index.php" class="voltar">Voltar</a>

    <main class="conteudo-principal">
        <section class="card">
            <h2>Adicionar Formação Acadêmica</h2>
            <p class="suave">Preencha os campos abaixo para cadastrar sua formação.</p>
            
            <form method="post" action="PHP/processar_formacao.php">
                <input type="hidden" name="action" value="save_formacao">

                <div class="campo-grupo">
                    <label for="instituicao">Instituição de Ensino</label>
                    <input type="text" id="instituicao" name="instituicao" placeholder="Ex: USP" maxlength="25" required>
                </div>

                <div class="campo-grupo">
                    <label for="curso">Curso</label>
                    <input type="text" id="curso" name="curso" placeholder="Ex: Ciência da Computação" maxlength="20" required>
                </div>

                <div class="campo-grupo">
                    <label for="periodo">Período</label>
                    <input type="text" id="periodo" name="periodo" placeholder="Ex: 2020 - 2024" maxlength="20" required>
                </div>

                <div class="espaco-cima">
                    <button type="submit" class="btn-salvar">Salvar Formação</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>