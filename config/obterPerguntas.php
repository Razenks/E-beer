<?php
require_once 'conectaBD.php'; // Conexão ao banco de dados

try {
    // Consultar perguntas e alternativas
    $sql = "
        SELECT pergunta.id_pergunta, pergunta.desc_pergunta, alternativa.id_alternativa, alternativa.desc_alternativa
        FROM pergunta
        LEFT JOIN alternativa ON pergunta.id_pergunta = alternativa.id_pergunta
        ORDER BY pergunta.id_pergunta, alternativa.id_alternativa
    ";
    
    $stmt = $conexao->query($sql);
    $perguntas = [];

    // Organizar perguntas e alternativas em um array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $idPergunta = $row['id_pergunta'];
        $descPergunta = $row['desc_pergunta'];
        $idAlternativa = $row['id_alternativa'];
        $descAlternativa = $row['desc_alternativa'];

        if (!isset($perguntas[$idPergunta])) {
            $perguntas[$idPergunta] = [
                'pergunta' => $descPergunta,
                'alternativas' => []
            ];
        }
        $perguntas[$idPergunta]['alternativas'][] = [
            'id' => $idAlternativa,
            'descricao' => $descAlternativa
        ];
    }

    // Enviar dados como JSON
    echo json_encode(array_values($perguntas));
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar perguntas: ' . $e->getMessage()]);
}
?>
