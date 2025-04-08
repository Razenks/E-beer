<?php
use App\service\Email;

require_once __DIR__ . '/../vendor/autoload.php';
require_once 'conectaBD.php';

// Verificar se est� chegando dados por POST
if (!empty($_POST)) {
    // Iniciar SESSAO (session_start)
    session_start();
    try {
        // Montar a SQL para buscar email e senha, e tamb�m o tipo do usu�rio
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
            header("Location: ../index.php?msgErro=E-mail n�o cadastrado.");
            exit();
        }

        if (!password_verify($_POST['senha'], $result['senha'])) {
            session_destroy(); // Destruir a SESSAO
            header("Location: ../index.php?msgErro=Senha incorreta.");
            exit();
        }

        // Autentica��o foi realizada com sucesso
        // Definir as vari�veis de sess�o
        $_SESSION['nome'] = $result['nome'];
        $_SESSION['email'] = $result['email'];
        $_SESSION['sobrenome'] = $result['sobrenome'];
        $_SESSION['tipo_usuario'] = $result['tipo_usuario'];
        $_SESSION['cpf'] = $result['cpf']; // Adiciona o CPF na sess�o
        
        $subject = 'C�digo de verifica��o';
        $body = 'Ol� '.$_SESSION['nome'].'. 
        <br><br> 
        Voc� acaba de fazer login na nossa plataforma e precisa informar o c�digo de verifica��o.
        <br><br>
        Seu c�digo �: ';
        // Enviar o e-mail com o c�digo de verifica��o
        $email = new Email();
        $_SESSION['code'] = $email->sendEmail($_SESSION['email'], $subject, $body);

        header("Location: ../pages/enter_code.php");

    } catch (PDOException $e) {
        error_log("Erro do Exception :" . $e->getMessage());
        header("Location: ../index.php?msgErro=Problema no sistema, tente novamente.");
        exit();
    }
} else {
    header("Location: ../index.php?msgErro=Voc� n�o tem permiss�o para acessar esta p�gina.");
    exit();
}
