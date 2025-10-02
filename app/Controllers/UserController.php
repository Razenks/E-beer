<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repository\UserRepository;
use App\Services\AuthService;
use App\Services\EmailService;
use App\Services\RecaptchaService;
use App\Services\JwtService;
use App\Services\UserService;
use App\Core\View;
use Exception;
use PhpParser\Node\Expr\Throw_;

class UserController extends Controller {
    private AuthService $auth_service;
    private RecaptchaService $recaptcha_service;
    private EmailService $email_service;
    private JwtService $jwt_service;
    private UserService $user_service;

    public function __construct() {
        $this->auth_service = new AuthService();
        $this->recaptcha_service = new RecaptchaService();
        $this->email_service = new EmailService();
        $this->jwt_service = new JwtService();
        $this->user_service = new UserService(new UserRepository());
    }

    public function index(?Request $request = null, array $data = []): void {
        $error = $request?->get('error');
        $success = $request?->get('success');

        $data['error'] = $error;
        $data['success'] = $success;
        $data['title'] = 'E-beer - Login';

        View::setLayout('auth');
        $this->logout();
        $this->render('pages.auth.login', $data);
    }

    public function getRegisterPage(?Request $request = null, array $data = []): void {
        $error = $request?->get('error');
        $success = $request?->get('success');
        
        $data['error'] = $error;
        $data['success'] = $success;
        $data['title'] = 'E-beer - Cadastro';

        View::setLayout('auth');
        $this->render('pages.auth.register', $data);
    }

    public function getCodePage(array $data = []): void {
        View::setLayout('auth');
        $data['title'] = 'E-beer - Código Email';
        $this->render('pages.auth.enter_code', $data);
    }

    public function processLogin(Request $request): void {
        try {
            $captcha = $request->post('g-recaptcha-response') ?? null;

            $email = $request->post('email');
            $pass = $request->post('senha');

            if(!$this->recaptcha_service->isCaptchaValid($captcha)) {
                self::redirect('/login?error=Necessário a validação do reCAPTCHA.');
                return;
            }

            $user = $this->user_service->getUserByEmail($email);
            if (!$user) {
                self::redirect('/login?error=Usuário não cadastrado.');
                return;
            }

            $isValidatedUser = $this->auth_service->validateUserPassword($pass, $user->getPass());
            if (!$isValidatedUser) {
                self::redirect('/login?error=Senha incorreta.');
                return;
            }

            $subject = "Código de Verificação";
            $body = '
                Olá ' . $user->getName() . '. 
                <br><br> 
                Você acaba de fazer login na nossa plataforma e precisa informar o código de verificação.
                <br><br>
                Seu código é: 
            ';

            $isSentEmail = $this->email_service->sendCodeEmail($email, $subject, $body);
            if(!$isSentEmail)
            {
                self::redirect('/login?error=Erro interno. Tente novamente.');
                throw new Exception("Erro ao salvar code na session. ");
            }

            $_SESSION['email-code'] = $this->email_service->code;

            $this->user_service->createUserSession([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'user_type' => $user->getUserType()
            ]);
            self::redirect('/login/digitar-codigo');
        } catch (Exception $e) {
            error_log("Erro na função login no UserController: " . $e->getMessage());
            self::redirect('/login?error=Erro interno. Tente novamente.');

        }
        
    }

    private function logout(): void {
        $this->user_service->logout();
    }

    public function validateEmailCode(Request $request): void {
        try {
            if($request->post('codigo') !== $_SESSION['email-code']) {
                self::redirect('/login/digitar-codigo?error=Código inválido');
            }

            unset($_SESSION['email-code']);
            $_SESSION['jwt'] = $this->jwt_service->generateToken(
                [
                    "name" => $_SESSION['name'],
                    "email" => $_SESSION['email'],
                    "user_type" => $_SESSION['user_type']
                ]
            );
            self::redirect("/api/get-home/{$_SESSION['user_type']}");
        } catch (Exception $e) {
            error_log("Erro na função validateEmailCode no LoginController: " . $e->getMessage());
            $this->index(null, ['error' => 'Erro interno. Tente novamente.']);
        }
    }

    public function redirectHome(int $user_type): void {
        if(!$user_type)
        {
            $this->index(null, ['error' => 'Usuário não logado']);
        }

        switch ($user_type) {
            case 1:
                self::redirect('/home');
                break;
            case 2:
                self::redirect('/admin');
                break;
                
            default:
                $this->index(null, ['error' => 'Usuário não logado']);
                break;
        }
    }

    public function processRegistration(Request $request): void {
        try {
            $captcha = $request->post('g-recaptcha-response') ?? null;
            $name = $request->post('nome');
            $last_name = $request->post('sobrenome');
            $email = $request->post('email');
            $cpf = preg_replace('/[^0-9]/', '', $request->post('cpf'));
            $password = $request->post('senha');
            $confirmPassword = $request->post('confirm-senha');
            $user_type = 1; // Tipo 1 para usuário comum
            $registration_date = date('Y-m-d H:i:s');
            
            if ($password !== $confirmPassword) {
                self::redirect('/register?error=Senhas não conferem.');
                return;
            }

            if(!$this->recaptcha_service->isCaptchaValid($captcha))
            {
                self::redirect('/register?error=Necessário a validação do reCAPTCHA.');
                return;
            }

            $is_created_user = $this->user_service->isCreatedUser($email);
            if ($is_created_user) {
                self::redirect('/register?error=E-mail já foi cadastro no sistema.');
                return;
            } else if ($is_created_user === null) {
                self::redirect('/register?error=Erro interno. Tente novamente.');
                return;
            }

            $user = [
                ':name' => $name,
                ':last_name' => $last_name,
                ':email' => $email,
                ':cpf' => $cpf,
                ':pass' => password_hash($password, PASSWORD_DEFAULT),
                ':user_type' => $user_type,
                ':registration_date' => $registration_date
            ];

            $is_created = $this->user_service->createUser($user);
            if (!$is_created) {
                self::redirect('/register?error=Erro ao criar usuário, tente novamente.');
                return;
            }

            $data = [ 'email' => $email ];

            $token = $this->jwt_service->generateToken($data, 3600);
            $_SESSION['jwt'] = $token;
            $link = "http://localhost/api/ativar-email/{$token}";
            $subject = "Ativar Conta";
            $body = '
                Olá ' . $name . '. 
                <br><br> 
                Você acaba de se cadastrar na nossa plataforma e precisa ativar sua conta clicando no link abaixo.
                <br><br>
                link: '.$link.'
            ';

            $isSentEmail = $this->email_service->sendEmail($email, $subject, $body);
            if(!$isSentEmail)
            {
                self::redirect('/register?error=Erro interno. Tente novamente.');
                throw new Exception("Erro ao enviar link para o e-mail: {$email}.");
            }

            self::redirect('/login/?success=Cadastro finalizado com sucesso! Ative sua conta acessando o link que enviamos no seu e-mail.');
        } catch (Exception $e) {
            error_log("Erro na função register no UserController: " . $e->getMessage());
            self::redirect('/register?error=Erro interno. Tente novamente.');
            return;
        }
        
    }

    public function activateAccount(string $token): void {
        if (!$token) {
            self::redirect('/login?error=Não foi possível finalizar o cadastro, tente novamente.');
            return;
        }

        try {
            $decoded = $this->jwt_service->validateToken($token);
            if (!$decoded['success']) {
                self::redirect('/login?error=Confirmação de e-mail expirou ou falhou, tente novamente.');
                return;
            }

            $data = $decoded['data'];
            $email = $data['email'];
            $user = $this->user_service->getUserByEmail($email);
            if (!$user) {
                self::redirect('/login?error=E-mail não cadastrado.');
                return;
            }

            $isActiveUser = $this->user_service->activateUser($email);
            if (!$isActiveUser) {
                throw new Exception("Erro ao ativar usuário.");
                return;
            }

            self::redirect('/login?success="Sua conta foi ativada. Faça login e aproveite!"');
        } catch (Exception $e) {
            error_log("Erro na função activateAccount no UserController: " . $e->getMessage());
            self::redirect('/login?error=Erro interno. Tente novamente.');
            return;
        }
    }
}