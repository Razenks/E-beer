<?php
session_start();
require '../config/conectaBD.php';

// Verifica se o CPF foi passado corretamente
if (!isset($_POST['cpf'])) {
    header("Location: manage_users.php?msgErro=CPF não encontrado.");
    exit();
}

$cpf_usuario = $_POST['cpf'];  // O CPF deve ser passado como um campo oculto no formulário
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$tipo_usuario = $_POST['tipo_usuario'];

// Verifica se os campos não estão vazios
if (empty($nome) || empty($sobrenome) || empty($email)) {
    header("Location: editar_usuario.php?cpf=$cpf_usuario&msgErro=Todos os campos são obrigatórios.");
    exit();
}

try {
    // Prepara a consulta SQL para atualizar os dados do usuário
    $sql = "UPDATE usuario SET nome = :nome, sobrenome = :sobrenome, email = :email, tipo_usuario = :tipo_usuario WHERE cpf = :cpf";
    $stmt = $conexao->prepare($sql);

    // Executa a consulta
    $stmt->execute([
        ':nome' => $nome,
        ':sobrenome' => $sobrenome,
        ':email' => $email,
        ':cpf' => $cpf_usuario,
        ':tipo_usuario' => $tipo_usuario
    ]);

    // Redireciona para a página de gerenciamento com mensagem de sucesso
    header("Location: ../pages/manage_users.php?cpf=$cpf_usuario&msgSucessoUser=Usuário atualizado com sucesso.");
} catch (PDOException $e) {
    echo 'Erro ao atualizar os dados: ' . $e->getMessage();
}
?>