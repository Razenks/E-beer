<?php
use App\service\Email;

require_once __DIR__ . '/../../vendor/autoload.php';

if (!isset($_SESSION['nome'], $_SESSION['email'])) {
    header("Location: ../index.php?msgErro=Voce precisa se autenticar no sistema.");
    exit();
}

$subject = 'Código de verificação';
$body = 'Olá ' . $_SESSION['nome'] . '. 
        <br><br> 
        Você acaba de fazer login na nossa plataforma e precisa informar o código de verificação.
        <br><br>
        Seu código é: ';
// Enviar o e-mail com o c�digo de verifica��o
$email = new Email();
$_SESSION['code'] = $email->sendEmail($_SESSION['email'], $subject, $body);