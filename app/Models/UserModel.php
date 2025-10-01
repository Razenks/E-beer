<?php
namespace App\Models;

use App\Core\Model;
use Exception;
use PDO;

class UserModel extends Model
{
    protected static string $table = 'usuario';
    private string $name;
    private string $email;
    private int $user_type;

    public function __construct()
    {
        parent::__construct();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getUserType(): ?int
    {
        return $this->user_type;
    }

    public function setUserType(int $user_type): void
    {
        $this->user_type = $user_type;
    }

    public function findByEmail(string $email): array|bool
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if($result) 
            {
                $this->setName($result['nome']);
                $this->setEmail($result['email']);
                $this->setUserType($result['tipo_usuario']);
            }

            return $result;
        } catch (Exception $e) {
            error_log("Erro na consulta por e-mail:" . $e->getMessage());
            return false;
        }
    }

        
    public function criar($dados): bool {
        $sql = "INSERT INTO usuarios (nome, email, senha,cpf) VALUES (:nome, :email, :senha, :cpf)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome', $dados['nome']);
        $stmt->bindValue(':email', $dados['email']);
        $stmt->bindValue('cpf',$dados['cpf']);
        $stmt->bindValue(':senha', password_hash($dados['senha'], PASSWORD_DEFAULT));
        

        if ($stmt->execute()) {
            return true;
        }
        else {
            return false;
        }
        
    }
}