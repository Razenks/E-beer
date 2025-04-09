<?php
$captcha = $_POST['g-recaptcha-response'];

if (!$captcha) {
    echo "Por favor, confirme o captcha";
    exit;
}

// Verifica com a API do Google
$secretKey = "6LdCBA8rAAAAAHVX3Bq8nsf8GNY3QzRL-H_gDO59";
$reponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
$respondeData = json_decode($response);

if (!$responseData->success) {
    echo "Falha na verificação do captcha.";
    exit;
}
?>