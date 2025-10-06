<?php
include_once 'Database.php';
include_once 'usuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $database = new Database();
    $db = $database->getConnection();

    $usuario = new Usuario($db);
    $usuario->id = $id;

    if ($usuario->inativar()) {
        header("Location: adm.html?msg=inativado");
        exit;
    } else {
        header("Location: adm.html?msg=erro");
        exit;
    }
} else {
    echo "Requisição inválida.";
}
?>