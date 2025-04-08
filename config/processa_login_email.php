<?php
use App\service\Email;

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'conectaBD.php';

// Verificar se está chegando dados por POST
if (!empty($_POST)) {
    // Iniciar SESSAO (session_start)
    session_start();
    try {
        // Montar a SQL para buscar email e senha, e também o tipo do usuário
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

        // Autenticação foi realizada com sucesso
        // Definir as variáveis de sessão
        $_SESSION['nome'] = $result['nome'];
        $_SESSION['email'] = $result['email'];
        $_SESSION['sobrenome'] = $result['sobrenome'];
        $_SESSION['tipo_usuario'] = $result['tipo_usuario'];
        $_SESSION['cpf'] = $result['cpf']; // Adiciona o CPF na sessão
        
        $subject = 'Código de verificação';
        $body = 'Olá '.$_SESSION['nome'].'. 
        <br><br> 
        Você acaba de fazer login na nossa plataforma e precisa informar o código de verificação.
        <br><br>
        Seu código é: ';
        // Enviar o e-mail com o código de verificação
        $email = new Email();
        $_SESSION['code'] = $email->sendEmail($_SESSION['email'], $subject, $body);

        header("Location: ../pages/enter_code.php");

    } catch (PDOException $e) {
        error_log("Erro do Exception :" . $e->getMessage());
        header("Location: ../index.php?msgErro=Problema no sistema, tente novamente.");
        exit();
    }
} else {
    header("Location: ../index.php?msgErro=Você não tem permissão para acessar esta página.");
    exit();
}
