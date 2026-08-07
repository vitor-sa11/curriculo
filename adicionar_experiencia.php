<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Experiência</title>
</head>
<body>
    <section class="card espacado">
        <h2>Experiências (bulk)</h2>
        <p class="suave">Use o formato: Empresa|Função|Período|Descrição</p>
        <form method="post">
        <input type="hidden" name="action" value="save_experiencias">
        <textarea name="experiencias_text" rows="6"><?php echo htmlspecialchars($experiencias_text); ?></textarea>
        <div class="espaco-cima">
            <button type="submit">Salvar Experiências</button>
        </div>
        </form>
    </section>
</body>
</html>