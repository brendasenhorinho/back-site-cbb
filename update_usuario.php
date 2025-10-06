<?php
include_once 'Database.php';
include_once 'usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $usuario = new Usuario($db);

    $usuario->id = intval($_POST['id']);
    $usuario->nome = trim($_POST['nome']);
    $usuario->email = trim($_POST['email']);
    $usuario->status = isset($_POST['status']) ? trim($_POST['status']) : 'ativo';

    if ($usuario->atualizar()) {
        header("Location: adm.html?msg=atualizado");
        exit;
    } else {
        header("Location: adm.html?msg=erro");
        exit;
    }
}
?>