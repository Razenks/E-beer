<?php
require '../src/service/jwt.php';

try {
    session_start();
    if (!isset($_SESSION['email'], $_SESSION['code'], $_SESSION['tipo_usuario'])) {
        header("Location: ../index.php?msgErro=Voc� precisa se autenticar no sistema.");
        exit();
    }
    if (empty($_POST)) {
        throw new Exception("Erro no envio do post");
    }

    $code= $_POST['codigo'];
    if ($code != $_SESSION['code']) {
        header("Location: ../pages/enter_code.php?msgErro=Codigo incorreto.");
        exit();
    }

    $_SESSION['code'] = '';
    // Autentica��o foi realizada com sucesso
    // Verificar o tipo do usu�rio
    if ($_SESSION['tipo_usuario'] == 2) { // 2 para administrador
        // Redirecionar para a p�gina de administrador
        header("Location: ../pages/main_admin.php");
        exit(); // exit para garantir que o script pare aqui
    } else {
        // Redirecionar para a p�gina de usu�rio normal
        header("Location: ../pages/main_logado.php");
        exit(); // exit para garantir que o script pare aqui
    }

} catch (Exception $e) {
    error_log("Erro do Exception :" . $e->getMessage());
    header("Location: ../index.php?msgErro=Problema no sistema, tente novamente.");
    exit();
}

