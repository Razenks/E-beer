<?php
namespace App\Core;

use Dotenv;
use Exception;
use PDO;

class Database
{
    protected string $host;
    protected string $db;
    protected string $user;
    protected string $pass;
    protected string $port;

    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->host = $_ENV['PGHOST'];
        $this->db = $_ENV['PGDATABASE'];
        $this->user = $_ENV['PGUSER'];
        $this->pass = $_ENV['PGPASSWORD'];
        $this->port = $_ENV['PGPORT'];
    }

    public function connect(): PDO
    {
        try {
            return new PDO(
                "pgsql:host={$this->host};port={$this->port};dbname={$this->db}",
                $this->user,
                $this->pass 
            ); 
        } catch (Exception $e) {
            error_log("Erro na conexão:" . $e->getMessage());
            die("Não conseguimos conectar ao Banco de Dados do sistema, tente novamente em alguns minutos.");
        }
    }
}