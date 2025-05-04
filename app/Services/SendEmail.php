<?php
namespace App\Services;

use App\Services\Email;

require_once __DIR__ . '/../../vendor/autoload.php';

if (!isset($_SESSION['nome'], $_SESSION['email'])) {
    header("Location: ../index.php?msgErro=Voce precisa se autenticar no sistema.");
    exit();
}

$subject = 'C�digo de verifica��o';
$body = 'Ol� ' . $_SESSION['nome'] . '. 
        <br><br> 
        Voc� acaba de fazer login na nossa plataforma e precisa informar o c�digo de verifica��o.
        <br><br>
        Seu c�digo �: ';
// Enviar o e-mail com o c�digo de verifica��o
$email = new Email();
$_SESSION['code'] = $email->sendEmail($_SESSION['email'], $subject, $body);