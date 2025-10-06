<?php
include_once 'Database.php';
include_once 'voluntario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $voluntario = new Voluntario($db);


    $voluntario->id = intval($_POST['id']);
    $voluntario->nome = trim($_POST['nome']);
    $voluntario->endereco = trim($_POST['endereco']);
    $voluntario->telefone = trim($_POST['telefone']);
    $voluntario->instagram = trim($_POST['instagram']);
    $voluntario->escolaridade = trim($_POST['escolaridade']);
    $voluntario->funcao_desejada = trim($_POST['funcao_desejada']);
    $voluntario->trabalho_voluntario = trim($_POST['trabalho_voluntario']);
    $voluntario->local_voluntario = trim($_POST['local_voluntario']);
    $voluntario->tempo_voluntario = trim($_POST['tempo_voluntario']);
    $voluntario->descricao_atuacao = trim($_POST['descricao_atuacao']);
    $voluntario->status = isset($_POST['status']) ? trim($_POST['status']) : 'ativo';

    if ($voluntario->atualizar()) {
        header("Location: adm.html?msg=atualizado");
        exit;
    } else {
        header("Location: adm.html?msg=erro");
        exit;
    }
}
?>
