<?php
require_once 'crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_experiencia') {
    $dados = array(
        'Empresa'   => $_POST['empresa'],
        'funcao'    => $_POST['funcao'],
        'periodo'   => $_POST['periodo'],
        'descricao' => $_POST['descricao']
    );

    create($pdo, 'experiencias', $dados);
    
    header('Location: ../index.php');
    exit;
}
?>