<?php
namespace App\service;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv;
require '../vendor/autoload.php';

class Email {
	// Variáveis de instância
	private $mail;
	private $dotenv;
	private $email;
	private $password;
	
	// Construtor que irá iniciar com o PHPMailer e carregar as variáveis de ambiente
	public function __construct() {
		$this->mail = new PHPMailer(true);
        $this->dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $this->dotenv->load();
		$this->email = $_ENV['APPGOOGLEEMAIL'];
		$this->password = $_ENV['APPGOOGLEPASSWORD'];
	}

	// Método para enviar o e-mail
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
            // segurança
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = 587;
            // remetente e destinatário
            $this->mail->setFrom($this->email, 'Equipe E-beer');
            $this->mail->addAddress($recipient);
            // verificar e-mail
            if (!$this->verifyEmail($recipient)) {
                throw new Exception("E-mail inválido.");
            }
            // gerar código aleatório
            $codigo = $this->generateCod(100000, 999999);
            // atualiza o conteúdo do body com o código
            $body = $body . "<h4>".$codigo."</h4>";
            // estrutura do e-mail
            $this->mail->isHTML(true);
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

	// Método para verificar e-mail
	private function verifyEmail(string $email) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    // Método para criar um código aleatório
    private function generateCod(int $min, int $max) {
        return rand($min, $max);
    }
}