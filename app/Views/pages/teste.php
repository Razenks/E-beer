<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Verifica se o usuário está logado e tem um CPF armazenado
if (!isset($_SESSION['cpf'])) {
    header("Location: index.php?msgErro=Você precisa se autenticar no sistema.");
    exit();
}

require_once '../config/conectaBD.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-beer</title>
</head>

<body>
    <form action="../config/alterar_dados.php" method="POST" id="change-data-inputs" enctype="multipart/form-data">
        <label for="">Imagem</label>
        <input type="file" accept="image/*" id="foto" name="foto">
        <button type="submit" id="save-data-changes">Salvar Alterações</button>
    </form>

</body>

</html>