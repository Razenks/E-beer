<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['cpf'])) {
    header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
    exit();
}

// Inclui o arquivo de conexão
require_once '../config/conectaBD.php';

try {
    // CPF do usuário logado
    $cpf = $_SESSION['cpf'];

    // Obtém os dados do formulário
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $tipo_usuario = $_POST['tipo_usuario'];

    // Remove qualquer caractere que não seja número do telefone
    $telefone = preg_replace('/\D/', '', $telefone);
    
    // Atualiza os dados do usuário no banco
    $sqlUpdateUsuario = "UPDATE usuario
                         SET nome = :nome,
                             sobrenome = :sobrenome,
                             email = :email,
                             telefone = :telefone
                         WHERE cpf = :cpf";
    $stmtUpdateUsuario = $conexao->prepare($sqlUpdateUsuario);
    $stmtUpdateUsuario->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmtUpdateUsuario->bindParam(':sobrenome', $sobrenome, PDO::PARAM_STR);
    $stmtUpdateUsuario->bindParam(':email', $email, PDO::PARAM_STR);
    $stmtUpdateUsuario->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $stmtUpdateUsuario->bindParam(':cpf', $cpf, PDO::PARAM_STR);

    if (!$stmtUpdateUsuario->execute()) {
        throw new Exception('Erro ao atualizar os dados do usuário.');
    }

    // Atualiza as informações na sessão
    $_SESSION['nome'] = $nome;
    $_SESSION['sobrenome'] = $sobrenome;
    $_SESSION['email'] = $email;

    // Verifica se há upload de foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Diretório onde as imagens serão salvas
        $uploadDir = '../userUploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Processa o arquivo enviado
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = time() . '-' . basename($_FILES['foto']['name']);
        $destPath = $uploadDir . $fileName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            throw new Exception('Erro ao mover o arquivo para o diretório de upload.');
        }

        // Verifica se o usuário já possui uma foto associada
        $sqlCheckFoto = 'SELECT id_foto_usuario FROM usuario WHERE cpf = :cpf';
        $stmtCheckFoto = $conexao->prepare($sqlCheckFoto);
        $stmtCheckFoto->bindParam(':cpf', $cpf, PDO::PARAM_STR);
        $stmtCheckFoto->execute();
        $usuario = $stmtCheckFoto->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $usuario['id_foto_usuario'] != null) {
            // Se o usuário já tem uma foto, faz um UPDATE
            $sqlUpdateFoto = 'UPDATE foto_usuario SET img_foto_usuario = :caminho_foto WHERE id_foto_usuario = :id_foto_usuario';
            $stmtUpdateFoto = $conexao->prepare($sqlUpdateFoto);
            $stmtUpdateFoto->bindParam(':caminho_foto', $destPath, PDO::PARAM_STR);
            $stmtUpdateFoto->bindParam(':id_foto_usuario', $usuario['id_foto_usuario'], PDO::PARAM_INT);

            if (!$stmtUpdateFoto->execute()) {
                throw new Exception('Erro ao atualizar a foto do usuário no banco.');
            }
        } else {
            // Se o usuário não tem foto, faz um INSERT
            $sqlInsertFoto = 'INSERT INTO foto_usuario (img_foto_usuario) VALUES (:caminho_foto)';
            $stmtInsertFoto = $conexao->prepare($sqlInsertFoto);
            $stmtInsertFoto->bindParam(':caminho_foto', $destPath, PDO::PARAM_STR);

            if ($stmtInsertFoto->execute()) {
                $idFoto = $conexao->lastInsertId();

                // Atualiza a tabela `usuario` para associar o ID da foto ao usuário
                $sqlUpdateUsuarioFoto = 'UPDATE usuario SET id_foto_usuario = :id_foto_usuario WHERE cpf = :cpf';
                $stmtUpdateUsuarioFoto = $conexao->prepare($sqlUpdateUsuarioFoto);
                $stmtUpdateUsuarioFoto->bindParam(':id_foto_usuario', $idFoto, PDO::PARAM_INT);
                $stmtUpdateUsuarioFoto->bindParam(':cpf', $cpf, PDO::PARAM_STR);

                if (!$stmtUpdateUsuarioFoto->execute()) {
                    throw new Exception('Erro ao associar a nova foto ao usuário.');
                }
            } else {
                throw new Exception('Erro ao salvar a nova imagem no banco de dados.');
            }
        }

        // Atualiza o caminho da foto na sessão
        $_SESSION['foto'] = $destPath;
    }

    if ($_SESSION['tipo_usuario'] == 2) { // 2 para administrador
        // Redirecionar para a página de administrador
        header("Location: ../pages/main_admin.php?MsgSucesso= Seus Dados foram atualizados com sucesso!");
        exit(); // Adicione exit para garantir que o script pare aqui
    } else {
        // Redirecionar para a página de usuário normal
        header("Location: ../pages/main_logado.php?MsgSucesso= Seus Dados foram atualizados com sucesso!");
        exit(); // Adicione exit para garantir que o script pare aqui
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit();
}
?>