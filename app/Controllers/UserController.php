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
use Exception;

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

        $data['error'] = $error ? $error : null;
        $data['success'] = $success ? $success : null;

        $this->logout();
        $this->render('login.index', $data);
    }

    public function getRegisterPage(?Request $request = null, array $data = []): void {
        $error = $request?->get('error');
        $success = $request?->get('success');
        
        $data['error'] = $error ? $error : null;
        $data['success'] = $success ? $success : null;

        $this->render('registration.register', $data);
    }

    public function getCodePage(array $data = []): void {
        $this->render('login.enter_code', $data);
    }

    public function getFinalizeRegistrationPage(?Request $request = null, array $data = []): void {
        $error = $request?->get('error');
        $success = $request?->get('success');
        
        $data['error'] = $error ? $error : null;
        $data['success'] = $success ? $success : null;

        $this->render('registration.finalize-registration', $data);
    }

    public function processLogin(Request $request): void {
        try {
            $captcha = $request->post('g-recaptcha-response') ?? null;

            $email = $request->post('email');
            $pass = $request->post('senha');

            if(!$this->recaptcha_service->isCaptchaValid($captcha))
            {
                self::redirect('/login?error=Necessário a validação do reCAPTCHA.');
                return;
            }

            $user = $this->auth_service->validateUser($email, $pass);
            if (!$user)
            {
                self::redirect('/login?error=Usuário ou senha incorretos.');
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

            // $_SESSION['code'] = $this->email_service->code;

            $this->user_service->createUserSession([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'user_type' => $user->getUserType()
            ]);
            self::redirect('/enter-code');
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
            if($this->email_service->isValidatedCode($request->post('codigo'))) {
                self::redirect('/enter-code?error=Código inválido');
            }

            // unset($_SESSION['code']);
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

    public function startRegistration(Request $request): void {
        try {
            $captcha = $request->post('g-recaptcha-response') ?? null;
            $name = $request->post('nome');
            $last_name = $request->post('sobrenome');
            $email = $request->post('email');
            $cpf = preg_replace('/[^0-9]/', '', $request->post('cpf'));
            $user_type = 1; // Tipo 1 para usuário comum
            $registration_date = date('Y-m-d H:i:s');
            
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

            $data = [
                'name' => $name,
                'last_name' => $last_name,
                'email' => $email,
                'cpf' => $cpf,
                'user_type' => $user_type,
                'registration_date' => $registration_date
            ];
            $token = $this->jwt_service->generateToken($data, 3600);
            $_SESSION['jwt'] = $token;
            $link = "http://localhost/confirm-email/{$token}";
            $subject = "Validar Conta";
            $body = '
                Olá ' . $name . '. 
                <br><br> 
                Você acaba de se cadastrar na nossa plataforma e precisa validar sua conta clicando no link abaixo.
                <br><br>
                '.$link.'
            ';

            $isSentEmail = $this->email_service->sendEmail($email, $subject, $body);
            if(!$isSentEmail)
            {
                self::redirect('/login?error=Erro interno. Tente novamente.');
                throw new Exception("Erro ao enviar link para o e-mail: {$email}.");
            }

            self::redirect('/register?success=Para finalizar seu cadastro, acesse o link que enviamos no seu e-mail.');
        } catch (Exception $e) {
            error_log("Erro na função register no UserController: " . $e->getMessage());
            self::redirect('/register?error=Erro interno. Tente novamente.');
            return;
        }
        
    }

    public function confirmEmail(string $token): void {
        if (!$token) {
            self::redirect('/register?error=Não foi possível finalizar o cadastro, tente novamente.');
            return;
        }

        try {
            $decoded = $this->jwt_service->validateToken($token);
            if (!$decoded['success']) {
                self::redirect('/register?error=Confirmação de e-mail expirou ou falhou, tente novamente.');
                return;
            }

            $_SESSION['jwt'] = $token;

            self::redirect('/finalize-registration');
        } catch (Exception $e) {
            error_log("Erro na função finalizeRegistration no UserController: " . $e->getMessage());
            self::redirect('/register?error=Erro interno. Tente novamente.');
            return;
        }
    }

    public function finalizeRegistration(Request $request): void {
        try {
            $token = $_SESSION['jwt'] ?? null;
            if (!$token) {
                self::redirect('/register?error=Confirmação de e-mail inválido ou sessão expirada.');
                return;
            }

            $decoded = $this->jwt_service->validateToken($token);
            if (!$decoded['success']) {
                self::redirect('/register?error=Confirmação de e-mail expirou ou falhou, tente novamente.');
                return;
            }

            $password = $request->post('senha');
            $confirmPassword = $request->post('confirm-senha');

            if ($password !== $confirmPassword) {
                self::redirect('/finalize-registration?error=Senhas não conferem.');
                return;
            }

            $data = $decoded['data'];

            $user = [
                ':name' => $data['name'],
                ':last_name' => $data['last_name'],
                ':email' => $data['email'],
                ':cpf' => $data['cpf'],
                ':pass' => password_hash($password, PASSWORD_BCRYPT),
                ':user_type' => $data['user_type'],
                ':registration_date' => $data['registration_date']
            ];

            $is_created = $this->user_service->createUser($user);

            if (!$is_created) {
                self::redirect('/register?error=Erro ao criar usuário, tente novamente.');
                return;
            }

            // Depois de criar, remove o token da sessão
            unset($_SESSION['jwt']);

            self::redirect('/login?success=Cadastro finalizado com sucesso, faça login!');
        } catch (Exception $e) {
            error_log("Erro na função finalizeRegistration no UserController: " . $e->getMessage());
            self::redirect('/register?error=Erro interno. Tente novamente.');
            return;
        }
    }
}