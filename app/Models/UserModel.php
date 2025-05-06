<?php
namespace App\Models;

use App\Core\Database;
use Exception;
use PDO;

class UserModel
{
    private PDO $db;
    public string $name;
    public string $email;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function findByEmail(string $email): array|bool
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM usuario WHERE email = ?");
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->name = $result['nome'];
            $this->email = $result['email'];

            return $result;
        } catch (Exception $e) {
            error_log("Erro na consulta por e-mail:" . $e->getMessage());
            return false;
        }
    }
}