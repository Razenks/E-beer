<?php
require __DIR__.'/vendor/autoload.php';

// 1. Configuração inicial
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<pre>Iniciando teste de e-mail...</pre>";

// 2. Carrega variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 3. Cria instância do PHPMailer com debug máximo
$mail = new PHPMailer\PHPMailer\PHPMailer(true);
$mail->SMTPDebug = 4; // Debug máximo (4 = detalhado + conexão)

try {
    // 4. Configuração SMTP (Gmail)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['APPGOOGLEEMAIL']; // Verifica se está carregando
    $mail->Password = $_ENV['APPGOOGLEPASSWORD']; // Verifica se está carregando
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    
    // 5. Opções para contornar problemas SSL (teste apenas)
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];
    
    // 6. Remetente e destinatário
    $mail->setFrom($_ENV['APPGOOGLEEMAIL'], 'Teste PHPMailer');
    $mail->addAddress($_ENV['APPGOOGLEEMAIL']); // Envia para si mesmo
    
    // 7. Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Teste SMTP - '.date('Y-m-d H:i:s');
    $mail->Body = '<h1>Teste de envio</h1><p>Se você está lendo isso, o e-mail foi enviado com sucesso!</p>';
    
    // 8. Envio com tratamento de erros
    if (!$mail->send()) {
        throw new Exception("Erro ao enviar: ".$mail->ErrorInfo);
    }
    
    echo "<pre>E-mail enviado com sucesso!</pre>";
    
} catch (Exception $e) {
    // 9. Mostra erros detalhados
    echo "<pre>ERRO CRÍTICO:</pre>";
    echo "<pre>".$e->getMessage()."</pre>";
    echo "<pre>Debug Output:</pre>";
    echo "<pre>".$mail->ErrorInfo."</pre>";
    
    // 10. Verifica credenciais
    echo "<pre>Verificando variáveis:</pre>";
    echo "APPGOOGLEEMAIL: ".$_ENV['APPGOOGLEEMAIL']."\n";
    echo "APPGOOGLEPASSWORD: ".(!empty($_ENV['APPGOOGLEPASSWORD']) ? '*** (existe)' : 'NÃO DEFINIDA');
}