<?php
require_once 'crud.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_formacao') {
    $dados = array(
        'Instituicao' => $_POST['instituicao'],
        'curso'       => $_POST['curso'],
        'periodo'     => $_POST['periodo']
    );

    create($pdo, 'formacao', $dados);

    header('Location: ../index.php');
    exit;
}
?>