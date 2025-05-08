<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Services\AuthService;
use App\Services\EmailService;
use App\Models\UserModel;
use App\Services\RecaptchaService;
use Exception;

class LoginController extends Controller
{
    public function index(?Request $request = null, array $data = []): void
    {
        $auth = $request?->get('auth');

        if($auth === 'off')
        {
            $data['error'] = 'Usuário não logado';
        }
        $this->render('login.index', $data);
    }

    public function enterCode(array $data = []): void
    {
        $this->render('login.enter_code', $data);
    }

    public function login(Request $request): void
    {
        try {
            $captcha = $request->post('g-recaptcha-response') ?? null;

            $email = $request->post('email');
            $pass = $request->post('senha');

            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);

            if(!(new AuthService())->validateUser($user, $pass))
            {
                $this->index(null, ['error' => 'Usuário ou Senha incorretos.']);
                return;
            }

            if(!(new RecaptchaService())->validateCaptcha($captcha))
            {
                $this->index(null, ['error' => 'Necessário a validação do reCAPTCHA.']);
                return;
            }

            $subject = "Código de Verificação";
            $body = '
                Olá ' . $userModel->getName() . '. 
                <br><br> 
                Você acaba de fazer login na nossa plataforma e precisa informar o código de verificação.
                <br><br>
                Seu código é: 
            ';

            $_SESSION['name'] = $userModel->getName();
            $_SESSION['email'] = $userModel->getEmail() ?? $email;
            $_SESSION['user_type'] = $userModel->getTipoUsuario();
            $_SESSION['code'] = (new EmailService())->sendEmail($email, $subject, $body);

            if(empty($_SESSION['code']))
            {
                $this->index(null, ['error' => 'Erro interno. Tente novamente.']);
                throw new Exception("Erro ao salvar code na session. ");
            }

            self::redirect('/enter-code');
        } catch (Exception $e) {
            error_log("Erro na função login no LoginController: " . $e->getMessage());
            $this->index(null, ['error' => 'Erro interno. Tente novamente.']);
        }
        
    }

    public function logout(): void
    {
        session_destroy();
        self::redirect('/login');
    }

    public function validateEmailCode(Request $request): void
    {
        try {
            $code = $request->post('codigo') ?? '';
            if($code != $_SESSION['code'])
            {
                $this->enterCode(['error' => 'Código inválido, verifique o e-mail digitado.']);
            }

            unset($_SESSION['code']);
            self::redirect("/home/{$_SESSION['user_type']}");
        } catch (Exception $e) {
            error_log("Erro na função validateEmailCode no LoginController: " . $e->getMessage());
            $this->enterCode(['error' => 'Erro interno. Tente novamente.']);
        }
    }

    public function redirectHome(int $user_type): void
    {
        if(!$user_type)
        {
            self::redirect('/login');
        }

        if(!((new AuthService())->validateLogged(['name', 'email', 'user_type'])))
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
                self::redirect('/login');
                break;
        }
    }
}