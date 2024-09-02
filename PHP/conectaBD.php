<?php 
//endereço
//nome do BD
//usuario
//senha

$endereco = 'localhost';
$banco = 'e-beer';
$usuario = 'postgres';
$senha = 'Rafha@123database';

try {
    // SGBD; host; porta; dbname;
    // usuario
    // senha
    // errmode
    $pdo = new PDO("pgsql:host=$endereco;port=5432;dbname=$banco", $usuario, $senha, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

//    echo "Conectado no Banco de dados!!!";

} catch (PDOException $e) {
    echo "Falha ao conectar ao banco de dados. <br/>";
    die($e->getMessage());
}
?>