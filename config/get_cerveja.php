<?php
require_once 'conexao.php'; // Conexão com o banco de dados

// Verifica se o ID da cerveja foi enviado
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Query para buscar os dados da cerveja
    $sql = "SELECT * FROM cervejas WHERE id = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$id]);
    
    // Verifica se a cerveja existe
    if ($stmt->rowCount() > 0) {
        $cerveja = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Retorna os dados da cerveja em formato JSON
        echo json_encode($cerveja);
    } else {
        echo json_encode(['error' => 'Cerveja não encontrada']);
    }
}
?>
