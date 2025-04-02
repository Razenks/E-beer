<?php
session_start();
require_once 'conectaBD.php';

$cpf = $_SESSION['cpf'] ?? null;
if (!$cpf) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não autenticado.']);
    exit;
}

// Obter dados enviados pelo JavaScript
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Nenhuma resposta recebida.']);
    exit;
}

try {
    // Insere um novo registro no questionário
    $queryQuestionario = $conexao->prepare("INSERT INTO questionario (cpf) VALUES (:cpf) RETURNING id_questionario");
    $queryQuestionario->bindParam(':cpf', $cpf);
    $queryQuestionario->execute();
    $idQuestionario = $queryQuestionario->fetchColumn();

    foreach ($data as $perguntaId => $alternativaId) {
        $queryResposta = $conexao->prepare("
        INSERT INTO resposta_usuario (cpf, id_alternativa, data_preenchimento, id_questionario)
        VALUES (:cpf, :id_alternativa, NOW(), :id_questionario)
        ");
        $queryResposta->bindParam(':cpf', $cpf);
        $queryResposta->bindParam(':id_alternativa', $alternativaId);
        $queryResposta->bindParam(':id_questionario', $idQuestionario);
        $queryResposta->execute();
    }

    // Retorna a recomendação junto com a resposta
    echo json_encode([
        'status' => 'sucesso',
        'mensagem' => 'Respostas salvas com sucesso!'
    ]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao salvar respostas: ' . $e->getMessage()]);
}
?>