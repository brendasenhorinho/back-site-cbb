<?php
include_once 'database.php';
include_once 'voluntario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $database = new Database();
    $db = $database->getConnection();

    $voluntario = new Voluntario($db);
    $voluntario->id = $id;

    if ($voluntario->ativar()) {
        header("Location: adm.html?msg=ativado");
        exit;
    } else {
        header("Location: adm.html?msg=erro");
        exit;
    }
} else {
    echo "Requisição inválida.";
}
?>