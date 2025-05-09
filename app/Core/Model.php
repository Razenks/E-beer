<?php
namespace App\Core;

use App\Core\Database;
use PDO;

abstract class Model
{
    protected static string $table;
    protected PDO $db;

    protected function __construct()
    {
        $this->db = (new Database())->connect();
        if(empty(static::$table))
        {   
            throw new \Exception("A propriedade \$table deve ser definida na classe filha de " . __CLASS__);
        }
    } 

    public function getAll(array $conditions = [], array $orderBy = []): array|bool
    {
        try {
            $sql = "SELECT * FROM " . static::$table;
            $params = [];

            // verifica se condições não está vazia
            if(!empty($conditions))
            {
                $whereClauses = [];
                foreach($conditions as $field => $value)
                {
                    // adiciona cada campo comparando com o placeholder
                    $whereClauses[] = "$field = ?"; 
                    // adiciona os valores dos campos no params
                    $params = $value;
                }
                // adiciona todas as condições ao sql, separando cada uma com AND
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }

            // verifica se a ordem não está vazia
            if(!empty($orderBy))
            {
                $orderByClauses = [];
                foreach($orderBy as $field => $direction)
                {
                    // transforma a direção de ordem em maiúscula
                    $direction = strtoupper($direction);
                    // verifica se a direção é realmente válida nas possibilidades
                    if(in_array($direction, ['ASC', 'DESC']))
                    {
                        // adiciona todos os campos que serão colocado em ordem, juntamento com a direção
                        $orderByClauses[] = "$field $direction";
                    }
                }
                if(!empty($orderByClauses))
                {
                    // adiciona todas as ordens ao sql, separando cada uma com ,
                    $sql .= " ORDER BY " . implode(", ", $orderByClauses);
                }
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Erro na função getAll na tabela " . static::$table . ': ' . $e->getMessage());
            return false;
        }
        
    }
}