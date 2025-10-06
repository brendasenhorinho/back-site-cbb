<?php
include_once 'Database.php';
include_once 'voluntarios.php'; // certifique-se que o nome do arquivo e da classe estão iguais

$database = new Database();
$db = $database->getConnection();

$voluntario = new Voluntario($db);

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

    $query = "SELECT id, nome, endereco, telefone, instagram, escolaridade, 
                     funcao_desejada, trabalho_voluntario, local_voluntario, 
                     tempo_voluntario, descricao_atuacao, status, data_criacao
              FROM voluntarios
              WHERE nome LIKE :pesquisa
                 OR endereco LIKE :pesquisa
                 OR telefone LIKE :pesquisa
                 OR instagram LIKE :pesquisa
                 OR escolaridade LIKE :pesquisa
                 OR funcao_desejada LIKE :pesquisa
                 OR trabalho_voluntario LIKE :pesquisa
                 OR local_voluntario LIKE :pesquisa
                 OR descricao_atuacao LIKE :pesquisa
                 OR id = :id_pesquisa
              ORDER BY $ordem";

    $stmt = $db->prepare($query);
    $stmt->bindParam(":pesquisa", $pesquisa);
    $stmt->bindParam(":id_pesquisa", $idPesquisa, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $query = "SELECT id, nome, endereco, telefone, instagram, escolaridade, 
                     funcao_desejada, trabalho_voluntario, local_voluntario, 
                     tempo_voluntario, descricao_atuacao, status, data_criacao
              FROM voluntarios
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
                <td>{$telefone}</td>
                <td>{$instagram}</td>
                <td>{$escolaridade}</td>
                <td>{$funcao_desejada}</td>
                <td>{$status}</td>
                <td>" . date('d/m/Y', strtotime($data_criacao)) . "</td>
                <td>
                    <form action='update_voluntario.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='{$id}'>
                        <button type='submit'>Editar</button>
                    </form>

                    <form action='delete_voluntario.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='id' value='{$id}'>
                        <button type='submit' onclick='return confirm(\"Tem certeza que deseja excluir este voluntário?\")'>Excluir</button>
                    </form>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>Nenhum voluntário encontrado</td></tr>";
}
?>
