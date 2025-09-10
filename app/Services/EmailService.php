<?php
namespace App\Services;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {
	// Variáveis de instância
	private PHPMailer $mail;
	private string $email;
	private string $password;
    public string $code;
	
	// Construtor que irá iniciar com o PHPMailer e carregar as variáveis de ambiente
	public function __construct() {
		$this->mail = new PHPMailer(true);
		$this->email = $_ENV['APPGOOGLEEMAIL'];
		$this->password = $_ENV['APPGOOGLEPASSWORD'];
	}

	// Método para enviar o código no e-email
    public function sendCodeEmail(string $recipient, string $subject, string $body): bool {
        try {
            // gerar código aleatório
            $this->code = $this->generateCod(100000, 999999);
            // atualiza o conteúdo do body com o código
            $body = $body .="<h4>{$this->code}</h4>";
            $isSentEmail = $this->sendEmail($recipient, $subject, $body);
            if(!$isSentEmail)
            {
                throw new Exception("Erro ao enviar código para o e-mail: {$recipient}.");
            }

            return true;
        } catch (Exception $e) {
            error_log("Erro do e-mail :" . $this->mail->ErrorInfo);
            error_log("Erro do Exception :" . $e->getMessage());
            return false;
        }
    }

    // Método para enviar e-email
    public function sendEmail(string $recipient, string $subject, string $body): bool {
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
            
            // estrutura do e-mail
            $this->mail->isHTML(true);
            $this->mail->CharSet = 'UTF-8';
            $this->mail->Encoding = 'base64';
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;
            // enviar e-mail
            $this->mail->send();

            return true;
        } catch (Exception $e) {
            error_log("Erro do e-mail :" . $this->mail->ErrorInfo);
            error_log("Erro do Exception :" . $e->getMessage());
            return false;
        }
    }

	// Método para verificar e-mail
	private function verifyEmail(string $email): bool {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    // Método para criar um código aleatório
    private function generateCod(int $min, int $max): int {
        return random_int($min, $max);
    }

    // Método que válida o código digitado
    public function isValidatedCode(int $code): bool {
        if (!$code || !$this->code) {
            return false;
        }

        return $code === $this->code;
    }
}