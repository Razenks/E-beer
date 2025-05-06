<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Request;
use App\Services\AuthService;
use App\Services\EmailService;
use App\Services\Recaptcha;
use App\Models\UserModel;
use App\Services\RecaptchaService;
use Exception;

class LoginController
{
    public function index(?Request $request = null, array $data = []): void
    {
        $auth = $request?->get('auth');

        if($auth === 'off')
        {
            $data['error'] = 'Você precisa estar autenticado.';
        }
        View::render('login.index', $data);
    }

    public function enterCode(array $data = []): void
    {
        View::render('login.enter_code', $data ?? null);
    }

    public function login(Request $request): void
    {
        try {
            $email = $request->post('email');
            $pass = $request->post('senha');

            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);

            if(!(new AuthService())->validateUser($user, $pass))
            {
                $this->index(null, ['error' => 'Usuário ou Senha incorretos.']);
                return;
            }

            if(!(new RecaptchaService())->validateCaptcha($request->post('g-recaptcha-response')))
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

            header("Location: /enter-code");
        } catch (Exception $e) {
            error_log("Erro na função login no LoginController: " . $e->getMessage());
            $this->index(null, ['error' => 'Erro interno. Tente novamente.']);
        }
        
    }

    public function validateEmailCode(Request $request): void
    {
        try {
            $code = $request->post('codigo') ?? '';
            if($code != $_SESSION['code'])
            {
                $this->enterCode(['error' => 'Código inválido, verifique o e-mail digitado.']);
            }

            header("Location: /home/{_SESSION['user_type']}/{$_SESSION['name']}");
        } catch (Exception $e) {
            error_log("Erro na função validateEmailCode no LoginController: " . $e->getMessage());
            $this->enterCode(['error' => 'Erro interno. Tente novamente.']);
        }
    }
}