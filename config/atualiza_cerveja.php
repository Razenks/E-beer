<?php
require_once 'conectaBD.php';

if (!empty($_POST)) {
    session_start();
    try {
        // Captura o ID da cerveja que será atualizada
        $id_cerveja = $_POST['id_cerveja'];

        // Pega as informações do arquivo enviado (imagem)
        $fileTmpPath = $_FILES['img_cerveja']['tmp_name'];
        $fileName = $_FILES['img_cerveja']['name'];
        $uploadDir = '../assets/';
        $destPath = $uploadDir . time() . '-' . $fileName;

        // Verifica se há uma nova imagem para atualizar
        if (!empty($fileTmpPath)) {
            // Move o arquivo temporário para a pasta assets
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Atualiza o caminho da imagem no banco de dados
                $sql = 'UPDATE img_cerveja 
                        SET img_cerveja = :img_cerveja 
                        WHERE id_img_cerveja = (SELECT id_img_cerveja FROM cerveja WHERE id_cerveja = :id_cerveja)';
                $stmt = $conexao->prepare($sql);
                $stmt->execute([':img_cerveja' => $destPath, ':id_cerveja' => $id_cerveja]);
            } else {
                header('Location: ../pages/register_beer.php?msgError=Erro ao mover o arquivo para a pasta assets');
                exit();
            }
        }

        // Captura os outros dados do formulário
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

        // Função para obter IDs a partir das descrições
        function getId($conexao, $tabela, $campo_desc, $descricao, $id_tabela)
        {
            $query = "SELECT $id_tabela FROM $tabela WHERE $campo_desc = :descricao";
            $stmt = $conexao->prepare($query);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        // Obtendo IDs
        $id_cor = getId($conexao, 'cor', 'desc_cor', $desc_cor, 'id_cor');
        $id_amargor = getId($conexao, 'amargor', 'desc_amargor', $desc_amargor, 'id_amargor');
        $id_teor = getId($conexao, 'teor_alcoolico', 'desc_teor', $desc_teor, 'id_teor');
        $id_corpo = getId($conexao, 'corpo_cerveja', 'desc_corpo', $desc_corpo, 'id_corpo');
        $id_aroma = getId($conexao, 'aroma', 'desc_aroma', $desc_aroma, 'id_aroma');
        $id_sabor = getId($conexao, 'sabor_principal', 'desc_sabor', $desc_sabor, 'id_sabor');
        $id_carbonacao = getId($conexao, 'carbonatacao', 'desc_carbona', $desc_carbonacao, 'id_carbonatacao');
        $id_mouthfeel = getId($conexao, 'mouthfeel', 'desc_mouthfeel', $desc_mouthfeel, 'id_mouthfeel');

        // Atualizando as informações da cerveja no banco de dados
        $sql = "UPDATE cerveja 
                SET nome = :nome, 
                    descricao = :descricao, 
                    id_cor = :id_cor, 
                    id_amargor = :id_amargor, 
                    id_teor = :id_teor, 
                    id_corpo = :id_corpo, 
                    id_aroma = :id_aroma, 
                    id_sabor = :id_sabor, 
                    id_carbonatacao = :id_carbonacao, 
                    id_mouthfeel = :id_mouthfeel 
                WHERE id_cerveja = :id_cerveja";

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
        $stmt->bindParam(':id_cerveja', $id_cerveja);

        if ($stmt->execute()) {
            header("Location: ../pages/register_beer.php?msgSucesso=Cerveja atualizada com sucesso!");
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
    exit(); // Finaliza o script após o redirecionamento
}
?>