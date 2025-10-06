<?php
include_once 'Database.php';
include_once 'voluntario.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $endereco = htmlspecialchars(trim($_POST['endereco']));
    $telefone = htmlspecialchars(trim($_POST['telefone']));
    $instagram = htmlspecialchars(trim($_POST['instagram']));
    $escolaridade = htmlspecialchars(trim($_POST['escolaridade']));
    $funcao_desejada = htmlspecialchars(trim($_POST['funcao_desejada']));
    $trabalho_voluntario = htmlspecialchars(trim($_POST['trabalho_voluntario']));
    $local_voluntario = htmlspecialchars(trim($_POST['local_voluntario']));
    $tempo_voluntario = htmlspecialchars(trim($_POST['tempo_voluntario']));
    $descricao_atuacao = htmlspecialchars(trim($_POST['descricao_atuacao']));

    $database = new Database();
    $db = $database->getConnection();

    $voluntario = new Voluntario($db);
    $voluntario->nome = $nome;
    $voluntario->endereco = $endereco;
    $voluntario->telefone = $telefone;
    $voluntario->instagram = $instagram;
    $voluntario->escolaridade = $escolaridade;
    $voluntario->funcao_desejada = $funcao_desejada;
    $voluntario->trabalho_voluntario = $trabalho_voluntario;
    $voluntario->local_voluntario = $local_voluntario;
    $voluntario->tempo_voluntario = $tempo_voluntario;
    $voluntario->descricao_atuacao = $descricao_atuacao;
    $voluntario->status = 'ativo';

    if ($voluntario->cadastrar()) {
        header("Location: adm.html?msg=sucesso");
        exit;
    } else {
        header("Location: adm.html?msg=erro");
        exit;
    }
}
?>
