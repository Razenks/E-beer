<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$email = $_ENV['APPGOOGLEEMAIL'];
$password = $_ENV['APPGOOGLEPASSWORD'];

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // servidor SMTP
    $mail->SMTPAuth = true; // precisa autenticar
    $mail->Username = $email; // seu e-mail
    $mail->Password = $password; // senha (ou senha de app)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($email, 'Equipe E-beer');
    $mail->addAddress('test-6rzsbd5is@srv1.mail-tester.com');

    $codigo = rand(100000, 999999); // Gera o c�digo

    $mail->isHTML(true);
    $mail->Subject = 'C�digo de verifica��o';
    $mail->Body = ".";
    $mail->Body = "";
    $mail->Body = "Ol�, fulano.
                <br><br>
                Voc� solicitou um c�digo de verifica��o para o seu cadastro.
                <br><br>
                 Seu c�digo de verifica��o �: <h4>$codigo</h4>";

    $mail->send();
    echo 'E-mail enviado com sucesso.';
} catch (Exception $e) {
    echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}
