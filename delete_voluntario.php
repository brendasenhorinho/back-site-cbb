<?php
include_once 'Database.php';
include_once 'voluntario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $database = new Database();
    $db = $database->getConnection();
    $usuario = new Voluntario($db);
    $usuario->id = $id;

    if ($usuario->remover()) {
        header("Location: adm.html?msg=deletado");
    } else {
        header("Location: adm.html?msg=erro");
    }
    exit;
} else {
    header("Location: adm.html?msg=invalid");
    exit;
}
