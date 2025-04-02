<?php
require_once 'conectaBD.php';

if (!empty($_FILES)) {
    session_start();

    try {
        // Verifica se o arquivo foi enviado sem erros
        if ($_FILES['perfil_foto']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['perfil_foto']['tmp_name'];

            // Lê o conteúdo do arquivo
            $fileContent = file_get_contents($fileTmpPath);

            // Prepara a inserção no banco de dados
            $sql = 'INSERT INTO foto_usuario (img_foto_usuario) VALUES (:perfil_foto)';
            $stmt = $conexao->prepare($sql);
            $dados = [
                ':perfil_foto' => $fileContent // Armazena o conteúdo do arquivo
            ];

            // Execute a consulta
            if ($stmt->execute($dados)) {
                header('Location: ../pages/main_logado.php?msgSucesso=Imagem adicionada com sucesso!');
                exit();
            } else {
                header('Location: ../pages/main_logado.php?msgError=Nao foi possivel adicionar imagem');
                exit();
            }
        } else {
            header('Location: ../pages/main_logado.php?msgError=Erro no envio do arquivo: ' . $_FILES['perfil_foto']['error']);
            exit();
        }
    } catch (PDOException $e) {
        header('Location: ../pages/main_logado.php?msgError=Erro: ' . $e->getMessage());
        exit();
    }
} else {
    header('Location: ../pages/main_logado.php?msgError=Sem dados para processar');
    exit();
}
?>