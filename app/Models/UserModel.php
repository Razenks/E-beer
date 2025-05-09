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
    private int $tipo_usuario;

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

    public function getTipoUsuario(): ?int
    {
        return $this->tipo_usuario;
    }

    public function setTipoUsuario(int $tipo_usuario): void
    {
        $this->tipo_usuario = $tipo_usuario;
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
                $this->setTipoUsuario($result['tipo_usuario']);
            }

            return $result;
        } catch (Exception $e) {
            error_log("Erro na consulta por e-mail:" . $e->getMessage());
            return false;
        }
    }
}