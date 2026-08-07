<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Formação</title>
</head>
<body>
    <section class="card espacado">
        <h2>Formação (bulk)</h2>
        <p class="suave">Use o formato: Instituição|Curso|Período</p>
        <form method="post">
        <input type="hidden" name="action" value="save_formacao">
        <textarea name="formacao_text" rows="5"><?php echo htmlspecialchars($formacao_text); ?></textarea>
        <div class="espaco-cima">
            <button type="submit">Salvar Formação</button>
        </div>
        </form>
    </section>
</body>
</html>