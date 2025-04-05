<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['PGHOST'];
$db = $_ENV['PGDATABASE'];
$user = $_ENV['PGUSER'];
$pass = $_ENV['PGPASSWORD'];
$port = $_ENV['PGPORT'];

try {
	$conexao = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
	echo "Conectado ao banco Neon!";
} catch(PDOException $e) {
	echo " Erro :" . $e->getMessage();
}