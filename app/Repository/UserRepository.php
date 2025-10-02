<?php
namespace App\Repository;

use App\Core\BaseRepository;
use App\Models\User;
use PDO;
use Exception;

class UserRepository extends BaseRepository {
    protected string $table = 'usuario';

    public function __construct() {
        parent::__construct();
    }

    public function getUserByEmail(string $email): ?User {
        if (!$email) {
            return null;
        }
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return null;
            }
            $user = new User();
            $user->setName($result['nome']);
            $user->setEmail($email);
            $user->setPass($result['senha']);
            $user->setUserType($result['tipo_usuario']);

            return $user;
        } catch (Exception $e) {
            error_log("Erro ao obter usuário por e-mail:" . $e->getMessage());
            return null;
        }
    }

    public function isCreatedUser(string $email): ?bool {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return isset($result['total']) && $result['total'] > 0;
        } catch (Exception $e) {
            error_log("Erro ao tentar consultar se email já foi cadastrado: " . $e->getMessage());
            return null;
        }
    }

    public function createUser($data = []): bool {
        if (count($data) <= 0) {
            return false;
        }

        try {
            $stmt = $this->db->prepare("INSERT INTO {$this->table} (nome, sobrenome, email, cpf, senha, tipo_usuario, data_cadastro)
                VALUES (:name, :last_name, :email, :cpf, :pass, :user_type, :registration_date)");
            if (!$stmt->execute($data)) {
                return false;
            }

            return true;

        } catch (Exception $e) {
            error_log("Erro para criar usuário no banco: " . $e->getMessage());
            return false;
        }
    }

    public function activateUser(string $email): bool {
        if (!$email) {
            return false;
        }
        try {
            $stmt = $this->db->prepare("
                UPDATE {$this->table}
                SET validacao_email = :validacao
                WHERE email = :email
            ");

            $stmt->bindValue(':validacao', true, PDO::PARAM_BOOL);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            $stmt->execute();

            return true;

        } catch (Exception $e) {
            error_log("Erro para ativar usuário: " . $e->getMessage());
            return false;
        }
    }
}