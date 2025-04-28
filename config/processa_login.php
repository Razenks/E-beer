<?php
use App\Service\Recaptcha;

require_once '../vendor/autoload.php';
require_once 'conectaBD.php';
require_once '../src/service/jwt.php';

// Verificar se est� chegando dados por POST
if (!empty($_POST)) {
    // Iniciar SESSAO (session_start)
    session_start();

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    try {


        // Código Recaptcha 
        $captcha = $_POST['g-recaptcha-response'];
        $recaptcha = new Recaptcha($_ENV['API_KEY_RECAPTCHA']);
        $result = $recaptcha->verify($captcha);
        if (!$result) {
            session_destroy(); // Destruir a SESSAO
            header("Location: ../index.php?msgErro=Falha na verificação do reCAPTCHA.");
            exit();
        }

        // Montar a SQL para buscar email e senha, e tamb�m o tipo do usuário
        $sql = "SELECT nome, email, senha, sobrenome, tipo_usuario, cpf FROM usuario WHERE email = :email";

        // Preparar a SQL (pdo)
        $stmt = $conexao->prepare($sql);

        // Definir/Organizar os dados p/ SQL
        $dados = array(
            ':email' => $_POST['email']
        );

        $stmt->execute($dados);
        $result = $stmt->fetch();

        if (!$result) {
            session_destroy(); // Destruir a SESSAO
            header("Location: ../index.php?msgErro=E-mail não cadastrado.");
            exit();
        }

        if (!password_verify($_POST['senha'], $result['senha'])) {
            session_destroy(); // Destruir a SESSAO
            header("Location: ../index.php?msgErro=Senha incorreta.");
            exit();
        }

        // Autentica��o foi realizada com sucesso
        // Definir as variáveis de sess�o
        $_SESSION['nome'] = $result['nome'];
        $_SESSION['email'] = $result['email'];
        $_SESSION['sobrenome'] = $result['sobrenome'];
        $_SESSION['tipo_usuario'] = $result['tipo_usuario'];
        $_SESSION['cpf'] = $result['cpf']; // Adiciona o CPF na sess�o

        $dadosUsuario = [
            'nome' => $result['nome'],
            'email' => $result['email'],
            'sobrenome' => $result['sobrenome'],
            'tipo_usuario' => $result['tipo_usuario'],
            'cpf' => $result['cpf']
        ];

        $tokenJWT = gerarTokenJWT($dadosUsuario);
        $_SESSION['jwt'] = $tokenJWT; // Ou você pode salvar em cookie se preferir

        header("Location: ../pages/main_logado.php");

    } catch (PDOException $e) {
        error_log("Erro do Exception :" . $e->getMessage());
        header("Location: ../index.php?msgErro=Problema no sistema, tente novamente.");
        exit();
    }
} else {
    header("Location: ../index.php?msgErro=Voc� n�o tem permiss�o para acessar esta p�gina.");
    exit();
}
