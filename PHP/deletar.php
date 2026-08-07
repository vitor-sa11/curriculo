<?php
require_once 'crud.php';

if (isset($_GET['tipo']) && isset($_GET['index'])) {
    $tipo = $_GET['tipo'];
    $index = intval($_GET['index']);

    if ($tipo === 'experiencia') {
        $experiencias = readAll($pdo, 'experiencias');
        
        if (isset($experiencias[$index])) {
            unset($experiencias[$index]);
            delete($pdo, 'experiencias', '1');
            
            foreach ($experiencias as $exp) {
                create($pdo, 'experiencias', array(
                    'Empresa'   => $exp['Empresa'],
                    'funcao'    => $exp['funcao'],
                    'periodo'   => $exp['periodo'],
                    'descricao' => $exp['descricao']
                ));
            }
        }
    } elseif ($tipo === 'formacao') {
        $formacoes = readAll($pdo, 'formacao');
        
        if (isset($formacoes[$index])) {
            unset($formacoes[$index]);
            delete($pdo, 'formacao', '1');
            
            foreach ($formacoes as $f) {
                create($pdo, 'formacao', array(
                    'Instituicao' => $f['Instituicao'],
                    'curso'       => $f['curso'],
                    'periodo'     => $f['periodo']
                ));
            }
        }
    }
}

header('Location: ../index.php');
exit;