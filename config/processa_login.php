<?php
require_once 'conectaBD.php';

// Verificar se está chegando dados por POST
if (!empty($_POST)) {
    // Iniciar SESSAO (session_start)
    session_start();

    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = '6LfhFQ8rAAAAAGsv1BqWidU-cmYCCHBaMClRv48L';

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $result = json_decode($response, true);

    if (!$result['success']) {
        header("Location: ../index.php?msgErro=Falha na verificação do CAPTCHA.");
        exit();
    }

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

        if ($result && password_verify($_POST['senha'], $result['senha'])) { // Verifica se a senha está correta
            // Autenticação foi realizada com sucesso
            // Definir as variáveis de sessão
            $_SESSION['nome'] = $result['nome'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['sobrenome'] = $result['sobrenome'];
            $_SESSION['tipo_usuario'] = $result['tipo_usuario'];
            $_SESSION['cpf'] = $result['cpf']; // Adiciona o CPF na sessão

            // Verificar o tipo do usuário
            if ($_SESSION['tipo_usuario'] == 2) { // 2 para administrador
                // Redirecionar para a página de administrador
                header("Location: ../pages/main_admin.php");
                exit(); // Adicione exit para garantir que o script pare aqui
            } else {
                // Redirecionar para a página de usuário normal
                header("Location: ../pages/main_logado.php");
                exit(); // Adicione exit para garantir que o script pare aqui
            }

        } else {
            // Falha na autenticaçao
            session_destroy(); // Destruir a SESSAO
            header("Location: ../index.php?msgErro=E-mail e/ou Senha inválido(s).");

        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
} else {
    header("Location: ../index.php?msgErro=Você não tem permissão para acessar esta página.");
    exit();
}
