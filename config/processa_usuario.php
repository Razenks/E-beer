<?php
require_once 'conectaBD.php';
// Definir a timezone correta
date_default_timezone_set('America/Caracas');

if (!empty($_POST)) {
    try {

        $senha = $_POST['senha'];
        $email = $_POST['email'];

        if (strlen($_POST['nome']) < 3 || strlen($_POST['sobrenome']) < 3) {
            header('Location: ../pages/cadastro.php?MsgErrorName= Nome ou Sobrenome muito pequenos');
            exit();
        }

        // Validação do e-mail
        if (!isValidEmail($email)) {
            header('Location: ../pages/cadastro.php?msgErrorEmail=E-mail inválido');
            exit();
        }


        if (!validatePassword($senha)) {
            header('Location: ../pages/cadastro.php?msgErrorSenha=Senha deve conter pelo menos 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial');
            exit();
        }

        // Remove caracteres não numéricos do CPF
        $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);

        // Verificar se o email ou CPF já existem
        $sql_verifica = "SELECT * FROM usuario WHERE email = :email OR cpf = :cpf";
        $stmt_verifica = $conexao->prepare($sql_verifica);
        $stmt_verifica->execute([
            ':email' => $_POST['email'],
            ':cpf' => $cpf
        ]);
        $usuario_existente = $stmt_verifica->fetch();

        if ($usuario_existente) {
            // Não adicionar espaços ou quebras de linha antes de `header()`
            header('Location: ../pages/cadastro.php?msgErroCadastro=E-mail ou CPF já cadastrado.');
            exit();  // Certifique-se de que o script pare aqui.
        }

        // Preparar SQL para inserção
        $sql = "INSERT INTO usuario (nome, sobrenome, email, cpf, senha, tipo_usuario, data_cadastro)
                VALUES (:nome, :sobrenome, :email, :cpf, :senha, :tipo_usuario, :data_cadastro)";
        $stmt = $conexao->prepare($sql);
        $dados = [
            ':nome' => $_POST['nome'],
            ':sobrenome' => $_POST['sobrenome'],
            ':email' => $_POST['email'],
            ':cpf' => $cpf,
            ':senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
            ':tipo_usuario' => 1,  // Tipo 1 para usuário
            ':data_cadastro' => date('Y-m-d H:i:s')
        ];

        if ($stmt->execute($dados)) {
            header('Location: ../pages/cadastro.php?msgSucesso=Cadastro realizado com sucesso!');
            exit();  // Finaliza o script após o redirecionamento
        } else {
            header('Location: ../pages/cadastro.php?msgErro=Falha ao cadastrar, tente novamente.');
            exit();  // Finaliza o script após o redirecionamento
        }
    } catch (PDOException $e) {
        header('Location: ../pages/cadastro.php?msgErro=Erro');
        exit();  // Finaliza o script após o redirecionamento
    }
} else {
    header("Location: ../pages/cadastro.php?msgErro=Erro de Acesso.");
    exit();  // Finaliza o script após o redirecionamento
}

function validatePassword($password)
{
    // Verifica se a senha tem pelo menos 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    return preg_match($pattern, $password);
}

// Função para validar o e-mail
function isValidEmail($email) {
    // Verifica se o e-mail tem um formato válido básico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Verifica se o domínio tem pelo menos 3 caracteres
    $domain = substr(strrchr($email, "@"), 1);
    if (strlen($domain) < 3) {
        return false;
    }

    // Verifica se a parte local (antes do @) tem pelo menos 2 caracteres
    $localPart = strstr($email, '@', true);
    if (strlen($localPart) < 2) {
        return false;
    }

    return true;
}


?>