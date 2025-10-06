<?php
include_once 'Database.php';
include_once 'usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $email = htmlspecialchars(trim($_POST['email']));
    $senha = htmlspecialchars(trim($_POST['senha']));

    $database = new Database();
    $db = $database->getConnection();

    $usuario = new Usuario($db);
    $usuario->nome = $nome;
    $usuario->email = $email;
    $usuario->senha = $senha;
    $usuario->status = 'ativo';

    if ($usuario->cadastrar()) {
        header("Location: adm.html?msg=sucesso");
        exit;
    } else {
        header("Location: adm.html?msg=erro");
        exit;
    }
}
?>