<?php
class Usuario {
    private $conn;
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $status;
    public $data_criacao;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE - Cadastrar usuário
    public function cadastrar() {
        $query = "INSERT INTO usuarios SET
                 nome = :nome,
                 email = :email,
                 senha = :senha,
                 status = :status";

        $stmt = $this->conn->prepare($query);

        // Limpar e sanitizar os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->status = htmlspecialchars(strip_tags($this->status));
        
        // Hash da senha para segurança
        $this->senha = password_hash($this->senha, PASSWORD_DEFAULT);

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':status', $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ - Buscar usuário por ID
    public function buscarPorId($id) {
        $query = "SELECT * FROM usuarios WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->nome = $row['nome'];
            $this->email = $row['email'];
            $this->senha = $row['senha'];
            $this->status = $row['status'];
            $this->data_criacao = $row['data_criacao'];
            
            return true;
        }
        return false;
    }


    // READ - Listar por nome
    public function buscarPorNome($nome) {
    $query = "SELECT * FROM usuarios WHERE nome = ? LIMIT 0,1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $nome);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->id = $row['id'];
        $this->nome = $row['nome'];
        $this->email = $row['email'];
        $this->senha = $row['senha'];
        $this->status = $row['status'];
        $this->data_criacao = $row['data_criacao'];
        
        return true;
    }
    return false;
}

// READ - Buscar usuários por nome (parcial)
public function buscarPorNomeParcial($nome) {
    $query = "SELECT * FROM usuarios WHERE nome LIKE ? ORDER BY nome";
    $stmt = $this->conn->prepare($query);
    
    $nomeParam = "%" . $nome . "%";
    $stmt->bindParam(1, $nomeParam);
    $stmt->execute();

    $usuarios = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $usuarios[] = $row;
    }
    return $usuarios;
}

    // READ - Listar todos os usuários
    public function listarTodos() {
        $query = "SELECT * FROM usuarios ORDER BY data_criacao DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $usuarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }

    // READ - Listar usuários por status
    public function listarPorStatus($status) {
        $query = "SELECT * FROM usuarios WHERE status = ? ORDER BY nome";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status);
        $stmt->execute();

        $usuarios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }

    // UPDATE - Atualizar usuário
    public function atualizar() {
        $query = "UPDATE usuarios SET
                 nome = :nome,
                 email = :email,
                 status = :status
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // UPDATE - Atualizar senha
    public function atualizarSenha($novaSenha) {
        $query = "UPDATE usuarios SET senha = :senha WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        $stmt->bindParam(':senha', $novaSenhaHash);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE - Remover usuário
    public function remover() {
        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Verificar senha
    public function verificarSenha($senha) {
        return password_verify($senha, $this->senha);
    }

    // Ativar usuário
    public function ativar() {
        $query = "UPDATE usuarios SET status = 'ativo' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            $this->status = 'ativo';
            return true;
        }
        return false;
    }

    // Inativar usuário
    public function inativar() {
        $query = "UPDATE usuarios SET status = 'inativo' WHERE id = ?";
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