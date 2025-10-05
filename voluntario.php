<?php
class Voluntario {
    private $conn;
    public $id;
    public $nome;
    public $endereco;
    public $telefone;
    public $instagram;
    public $escolaridade;
    public $funcao_desejada;
    public $trabalho_voluntario;
    public $local_voluntario;
    public $tempo_voluntario;
    public $descricao_atuacao;
    public $status;
    public $data_criacao;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE - Cadastrar voluntário
    public function cadastrar() {
        $query = "INSERT INTO voluntarios SET
                 nome = :nome,
                 endereco = :endereco,
                 telefone = :telefone,
                 instagram = :instagram,
                 escolaridade = :escolaridade,
                 funcao_desejada = :funcao_desejada,
                 trabalho_voluntario = :trabalho_voluntario,
                 local_voluntario = :local_voluntario,
                 tempo_voluntario = :tempo_voluntario,
                 descricao_atuacao = :descricao_atuacao,
                 status = :status";

        $stmt = $this->conn->prepare($query);

        // Limpar e sanitizar os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->instagram = htmlspecialchars(strip_tags($this->instagram));
        $this->escolaridade = htmlspecialchars(strip_tags($this->escolaridade));
        $this->funcao_desejada = htmlspecialchars(strip_tags($this->funcao_desejada));
        $this->trabalho_voluntario = htmlspecialchars(strip_tags($this->trabalho_voluntario));
        $this->local_voluntario = htmlspecialchars(strip_tags($this->local_voluntario));
        $this->tempo_voluntario = htmlspecialchars(strip_tags($this->tempo_voluntario));
        $this->descricao_atuacao = htmlspecialchars(strip_tags($this->descricao_atuacao));
        $this->status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':endereco', $this->endereco);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':instagram', $this->instagram);
        $stmt->bindParam(':escolaridade', $this->escolaridade);
        $stmt->bindParam(':funcao_desejada', $this->funcao_desejada);
        $stmt->bindParam(':trabalho_voluntario', $this->trabalho_voluntario);
        $stmt->bindParam(':local_voluntario', $this->local_voluntario);
        $stmt->bindParam(':tempo_voluntario', $this->tempo_voluntario);
        $stmt->bindParam(':descricao_atuacao', $this->descricao_atuacao);
        $stmt->bindParam(':status', $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ - Buscar voluntário por ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM voluntarios WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->endereco = $row['endereco'];
            $this->telefone = $row['telefone'];
            $this->instagram = $row['instagram'];
            $this->escolaridade = $row['escolaridade'];
            $this->funcao_desejada = $row['funcao_desejada'];
            $this->trabalho_voluntario = $row['trabalho_voluntario'];
            $this->local_voluntario = $row['local_voluntario'];
            $this->tempo_voluntario = $row['tempo_voluntario'];
            $this->descricao_atuacao = $row['descricao_atuacao'];
            $this->status = $row['status'];
            $this->data_criacao = $row['data_criacao'];
            
            return true;
        }
        return false;
    }

    // READ - Buscar voluntário por nome (exato)
    public function buscarPorNome($nome) {
        $query = "SELECT * FROM voluntarios WHERE nome = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->endereco = $row['endereco'];
            $this->telefone = $row['telefone'];
            $this->instagram = $row['instagram'];
            $this->escolaridade = $row['escolaridade'];
            $this->funcao_desejada = $row['funcao_desejada'];
            $this->trabalho_voluntario = $row['trabalho_voluntario'];
            $this->local_voluntario = $row['local_voluntario'];
            $this->tempo_voluntario = $row['tempo_voluntario'];
            $this->descricao_atuacao = $row['descricao_atuacao'];
            $this->status = $row['status'];
            $this->data_criacao = $row['data_criacao'];
            
            return true;
        }
        return false;
    }

    // READ - Buscar voluntários por nome (parcial)
    public function buscarPorNomeParcial($nome) {
        $query = "SELECT * FROM voluntarios WHERE nome LIKE ? ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        
        $nomeParam = "%" . $nome . "%";
        $stmt->bindParam(1, $nomeParam);
        $stmt->execute();

        $voluntarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $voluntarios[] = $row;
        }
        return $voluntarios;
    }

    // READ - Listar todos os voluntários
    public function listarTodos() {
        $query = "SELECT * FROM voluntarios ORDER BY data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $voluntarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $voluntarios[] = $row;
        }
        return $voluntarios;
    }

    // READ - Listar voluntários por status
    public function listarPorStatus($status) {
        $query = "SELECT * FROM voluntarios WHERE status = ? ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->execute();

        $voluntarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $voluntarios[] = $row;
        }
        return $voluntarios;
    }

    // READ - Listar voluntários por experiência (com trabalho voluntário)
    public function listarComExperiencia() {
        $query = "SELECT * FROM voluntarios WHERE trabalho_voluntario = 'Sim' ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $voluntarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $voluntarios[] = $row;
        }
        return $voluntarios;
    }

    // UPDATE - Atualizar voluntário
    public function atualizar() {
        $query = "UPDATE voluntarios SET
                 nome = :nome,
                 endereco = :endereco,
                 telefone = :telefone,
                 instagram = :instagram,
                 escolaridade = :escolaridade,
                 funcao_desejada = :funcao_desejada,
                 trabalho_voluntario = :trabalho_voluntario,
                 local_voluntario = :local_voluntario,
                 tempo_voluntario = :tempo_voluntario,
                 descricao_atuacao = :descricao_atuacao,
                 status = :status
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));
        $this->telefone = htmlspecialchars(strip_tags($this->telefone));
        $this->instagram = htmlspecialchars(strip_tags($this->instagram));
        $this->escolaridade = htmlspecialchars(strip_tags($this->escolaridade));
        $this->funcao_desejada = htmlspecialchars(strip_tags($this->funcao_desejada));
        $this->trabalho_voluntario = htmlspecialchars(strip_tags($this->trabalho_voluntario));
        $this->local_voluntario = htmlspecialchars(strip_tags($this->local_voluntario));
        $this->tempo_voluntario = htmlspecialchars(strip_tags($this->tempo_voluntario));
        $this->descricao_atuacao = htmlspecialchars(strip_tags($this->descricao_atuacao));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':endereco', $this->endereco);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':instagram', $this->instagram);
        $stmt->bindParam(':escolaridade', $this->escolaridade);
        $stmt->bindParam(':funcao_desejada', $this->funcao_desejada);
        $stmt->bindParam(':trabalho_voluntario', $this->trabalho_voluntario);
        $stmt->bindParam(':local_voluntario', $this->local_voluntario);
        $stmt->bindParam(':tempo_voluntario', $this->tempo_voluntario);
        $stmt->bindParam(':descricao_atuacao', $this->descricao_atuacao);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE - Remover voluntário
    public function remover() {
        $query = "DELETE FROM voluntarios WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ativar voluntário
    public function ativar() {
        $query = "UPDATE voluntarios SET status = 'ativo' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            $this->status = 'ativo';
            return true;
        }
        return false;
    }

    // Inativar voluntário
    public function inativar() {
        $query = "UPDATE voluntarios SET status = 'inativo' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            $this->status = 'inativo';
            return true;
        }
        return false;
    }
}
?>