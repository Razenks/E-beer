<?php 

// Conexão modelo antigo :
//endereço
//nome do BD
//usuario
//senha

//$endereco = 'localhost';
//$banco = 'e-beer';
//$usuario = 'postgres';
//$senha = 'Rafha@123database';

//try {
//    // SGBD; host; porta; dbname;
//    // usuario
//    // senha
//    // errmode
//    $conexao = new PDO("pgsql:host=$endereco;port=5432;dbname=$banco", $usuario, $senha, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

//    echo "Conectado no Banco de dados!!!";
//} catch (PDOException $e) {
//    echo "Falha ao conectar ao banco de dados. <br/>";
//    die($e->getMessage());
//}
// Conexão modelo novo com NEON :

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['PGHOST'];
$db = $_ENV['PGDATABASE'];
$user = $_ENV['PGUSER'];
$pass = $_ENV['PGPASSWORD'];
$port = $_ENV['PGPORT'];

try {
    $conexao = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    echo " Erro :" . $e->getMessage();
}