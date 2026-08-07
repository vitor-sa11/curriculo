<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Experiência</title>
    <link rel="stylesheet" href="CSS/edicao.css">
</head>
<body>
    <a href="index.php" class="voltar">Voltar</a>
    
    <main class="conteudo-principal">
        <section class="card">
            <h2>Adicionar Experiência Profissional</h2>
            <p class="suave">Preencha os campos abaixo para cadastrar uma nova experiência.</p>
            
            <form method="post" action="processar_experiencia.php">
                <input type="hidden" name="action" value="save_experiencia">
                
                <div class="campo-grupo">
                    <label for="empresa">Empresa</label>
                    <input type="text" id="empresa" name="empresa" placeholder="Ex: Google" maxlength="25" required>
                </div>

                <div class="campo-grupo">
                    <label for="funcao">Função / Cargo</label>
                    <input type="text" id="funcao" name="funcao" placeholder="Ex: Desenvolvedor Front-end" maxlength="20" required>
                </div>

                <div class="campo-grupo">
                    <label for="periodo">Período</label>
                    <input type="text" id="periodo" name="periodo" placeholder="Ex: Jan 2022 - Atual" maxlength="20" required>
                </div>

                <div class="campo-grupo">
                    <label for="descricao">Descrição das Atividades</label>
                    <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva brevemente suas responsabilidades..." maxlength="250"></textarea>
                </div>

                <div class="espaco-cima">
                    <button type="submit" class="btn-salvar">Salvar Experiência</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>