<?php
namespace App\Services;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv;
require '../vendor/autoload.php';

class Email {
	// Vari�veis de inst�ncia
	private $mail;
	private $dotenv;
	private $email;
	private $password;
	
	// Construtor que ir� iniciar com o PHPMailer e carregar as vari�veis de ambiente
	public function __construct() {
		$this->mail = new PHPMailer(true);
        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $this->dotenv->load();
		$this->email = $_ENV['APPGOOGLEEMAIL'];
		$this->password = $_ENV['APPGOOGLEPASSWORD'];
	}

	// M�todo para enviar o e-mail
    public function sendEmail(string $recipient, string $subject, string $body)
    {
        try {
            // servidor SMTP
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            // precisa autenticar
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $this->email;
            $this->mail->Password = $this->password;
            // seguran�a
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            // remetente e destinat�rio
            $this->mail->setFrom($this->email, 'Equipe E-beer');
            $this->mail->addAddress($recipient);
            // verificar e-mail
            if (!$this->verifyEmail($recipient)) {
                throw new Exception("E-mail inv�lido.");
            }
            // gerar c�digo aleat�rio
            $codigo = $this->generateCod(100000, 999999);
            // atualiza o conte�do do body com o c�digo
            $body = $body . "<h4>".$codigo."</h4>";
            // estrutura do e-mail
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Encoding = 'base64';
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            // enviar e-mail
            $this->mail->send();

            return $codigo;
        } catch (Exception $e) {
            error_log("Erro do e-mail :" . $this->mail->ErrorInfo);
            error_log("Erro do Exception :" . $e->getMessage());
            return false;
        }
    }

	// M�todo para verificar e-mail
	private function verifyEmail(string $email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    // M�todo para criar um c�digo aleat�rio
    private function generateCod(int $min, int $max) {
        return rand($min, $max);
    }
}