<?php
session_start();
require_once 'conectaBD.php';

// Verifica se o usuário está autenticado
$cpf = $_SESSION['cpf'] ?? null;
if (!$cpf) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

$query = "
    SELECT * FROM recomendar_cerveja(:cpf)
";
$stmt = $conexao->prepare($query);
$stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
$stmt->execute();
$recomendacao = $stmt->fetch(PDO::FETCH_ASSOC);

// Lógica para recomendar a cerveja (a função que você já tem pode ser utilizada aqui)
try {
    $query = "
        SELECT c.*, 
               co.desc_cor, 
               a.desc_amargor, 
               ta.desc_teor, 
               cc.desc_corpo, 
               ar.desc_aroma, 
               sp.desc_sabor, 
               car.desc_carbona, 
               mf.desc_mouthfeel,
               img.img_cerveja
        FROM cerveja c
        LEFT JOIN cor co ON c.id_cor = co.id_cor
        LEFT JOIN amargor a ON c.id_amargor = a.id_amargor
        LEFT JOIN teor_alcoolico ta ON c.id_teor = ta.id_teor
        LEFT JOIN corpo_cerveja cc ON c.id_corpo = cc.id_corpo
        LEFT JOIN aroma ar ON c.id_aroma = ar.id_aroma
        LEFT JOIN sabor_principal sp ON c.id_sabor = sp.id_sabor
        LEFT JOIN carbonatacao car ON c.id_carbonatacao = car.id_carbonatacao
        LEFT JOIN mouthfeel mf ON c.id_mouthfeel = mf.id_mouthfeel
        LEFT JOIN img_cerveja img ON c.id_img_cerveja = img.id_img_cerveja
        WHERE c.id_cerveja = :id_cerveja
    ";

    // Buscar a recomendação de cerveja com base nas respostas
    // O ID da cerveja pode ser calculado com base nas respostas armazenadas no banco de dados
    $idCerveja = $recomendacao['id_cerveja_recomendada']; 

    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':id_cerveja', $idCerveja);
    $stmt->execute();

    $cerveja = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cerveja) {
        echo json_encode(['status' => 'sucesso', 'cerveja' => $cerveja]);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Cerveja não encontrada.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao obter recomendação: ' . $e->getMessage()]);
}