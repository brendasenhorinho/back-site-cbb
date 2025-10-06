<?php
include_once 'Database.php';
include_once 'usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

// Ordenação padrão
$ordem = "data_criacao DESC";

// Se foi enviado um critério de ordenação
if (isset($_POST['ordenar']) && $_POST['ordenar'] == "nome") {
    $ordem = "nome ASC";
}

// Se foi enviada uma pesquisa
if (isset($_POST['pesquisar']) && !empty(trim($_POST['pesquisar']))) {
    $pesquisa = "%" . trim($_POST['pesquisar']) . "%";
    $idPesquisa = is_numeric($_POST['pesquisar']) ? intval($_POST['pesquisar']) : 0;

    $query = "SELECT id, nome, email, status, data_criacao
              FROM usuarios
              WHERE nome LIKE :pesquisa
                 OR email LIKE :pesquisa
                 OR id = :id_pesquisa
              ORDER BY $ordem";

    $stmt = $db->prepare($query);
    $stmt->bindParam(":pesquisa", $pesquisa);
    $stmt->bindParam(":id_pesquisa", $idPesquisa, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $query = "SELECT id, nome, email, status, data_criacao
              FROM usuarios
              ORDER BY $ordem";

    $stmt = $db->prepare($query);
    $stmt->execute();
}

$num = $stmt->rowCount();

if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        echo "<tr>
                <td>{$id}</td>
                <td>{$nome}</td>
                <td>{$email}</td>
                <td>{$status}</td>
                <td>" . date('d/m/Y', strtotime($data_criacao)) . "</td>
                <td>
                    <form action='update_usuario.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='{$id}'>
                        <button type='submit'>Editar</button>
                    </form>

                    <form action='delete_usuario.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='{$id}'>
                        <button type='submit' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>Excluir</button>
                    </form>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>Nenhum usuário encontrado</td></tr>";
}
?>