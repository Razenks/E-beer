<?php
require_once 'conectaBD.php';

if (!empty($_POST)) {

    session_start();
    try {
        // Definir o diretório onde os arquivos serão salvos
        $uploadDir = '../assets/';

        // Pega as informações do arquivo enviado
        $fileTmpPath = $_FILES['img_cerveja']['tmp_name'];
        $fileName = $_FILES['img_cerveja']['name'];
        $fileSize = $_FILES['img_cerveja']['size'];
        $fileType = $_FILES['img_cerveja']['type'];
        //
        $fileName = time() . '-' . $fileName;
        $destPath = $uploadDir . $fileName;
        //
        // Move o arquivo temporário para a pasta assets
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            // Agora armazena o caminho da imagem no banco de dados
            $sql = 'INSERT INTO img_cerveja (img_cerveja) VALUES (:img_cerveja)';
            $stmt = $conexao->prepare($sql);
            $dados = [
                ':img_cerveja' => $destPath  // Salva o caminho do arquivo
            ];

            if ($stmt->execute($dados)) {
                $id_img_cerveja = $conexao->lastInsertId();
                header('Location: ../pages/register_beer.php?msgSucesso=Imagem carregada com sucesso');
            } else {
                header('Location: ../pages/register_beer.php?msgError=Nao foi possivel adicionar imagem ao banco de dados');
                exit();
            }
        } else {
            header('Location: ../pages/register_beer.php?msgError=Erro ao mover o arquivo para a pasta assets');
            exit();
        }
        //
        $nome = $_POST['nome'];
        $desc_cerv = $_POST['descricao'];
        $desc_cor = $_POST['cor'];
        $desc_teor = $_POST['teor'];
        $desc_amargor = $_POST['amargor'];
        $desc_corpo = $_POST['corpo'];
        $desc_aroma = $_POST['aroma'];
        $desc_sabor = $_POST['sabor'];
        $desc_carbonacao = $_POST['carbonacao'];
        $desc_mouthfeel = $_POST['mouthfeel'];

        function getId($conexao, $tabela, $campo_desc, $descricao, $id_tabela)
        {
            $query = "SELECT $id_tabela FROM $tabela WHERE $campo_desc = :descricao";
            $stmt = $conexao->prepare($query);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        $id_cor = getId($conexao, 'cor', 'desc_cor', $desc_cor, 'id_cor');
        $id_amargor = getId($conexao, 'amargor', 'desc_amargor', $desc_amargor, 'id_amargor');
        $id_teor = getId($conexao, 'teor_alcoolico', 'desc_teor', $desc_teor, 'id_teor');
        $id_corpo = getId($conexao, 'corpo_cerveja', 'desc_corpo', $desc_corpo, 'id_corpo');
        $id_aroma = getId($conexao, 'aroma', 'desc_aroma', $desc_aroma, 'id_aroma');
        $id_sabor = getId($conexao, 'sabor_principal', 'desc_sabor', $desc_sabor, 'id_sabor');
        $id_carbonacao = getId($conexao, 'carbonatacao', 'desc_carbona', $desc_carbonacao, 'id_carbonatacao');
        $id_mouthfeel = getId($conexao, 'mouthfeel', 'desc_mouthfeel', $desc_mouthfeel, 'id_mouthfeel');

        $sql = "INSERT INTO cerveja (nome, descricao, id_cor, id_amargor, id_teor, id_corpo, id_aroma, id_sabor, id_carbonatacao, id_mouthfeel, id_img_cerveja) 
            VALUES (:nome, :descricao, :id_cor, :id_amargor, :id_teor, :id_corpo, :id_aroma, :id_sabor, :id_carbonacao, :id_mouthfeel, :id_img_cerveja)";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $desc_cerv);
        $stmt->bindParam(':id_cor', $id_cor);
        $stmt->bindParam(':id_amargor', $id_amargor);
        $stmt->bindParam(':id_teor', $id_teor);
        $stmt->bindParam(':id_corpo', $id_corpo);
        $stmt->bindParam(':id_aroma', $id_aroma);
        $stmt->bindParam(':id_sabor', $id_sabor);
        $stmt->bindParam(':id_carbonacao', $id_carbonacao);
        $stmt->bindParam(':id_mouthfeel', $id_mouthfeel);
        $stmt->bindParam(':id_img_cerveja', $id_img_cerveja);

        if ($stmt->execute()) {
            $nomeCerveja = $nome; // Pega o nome da cerveja enviada pelo formulário
            header("Location: ../pages/register_beer.php?msgSucesso=" . urlencode($nomeCerveja) . " cadastrada com sucesso!");
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "<pre>";
            print_r($errorInfo);
            echo "</pre>";
            exit();
        }

    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        echo "<br>";
        echo "Código do erro: " . $e->getCode();
    }
} else {
    header("Location: ../pages/cadastro.php?msgErro=Erro de Acesso.");
    exit();  // Finaliza o script após o redirecionamento
}
?>