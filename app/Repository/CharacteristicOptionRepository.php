<?php
namespace App\Repository;

use App\Core\BaseRepository;
use App\ViewModels\CharacteristicOptionsViewModel;
use PDO;
use Exception;

class CharacteristicOptionRepository extends BaseRepository {
    protected string $table = 'opcao_caracteristica';

    public function __construct() {
        parent::__construct();
    }

    public function getAllOptionsByCharacteristicId(int $id): ?CharacteristicOptionsViewModel {
        if (!$id) return null;
        try {
            $sql = "
                SELECT 
                    ct.nome AS nome_caracteristica,
                    oct.opcao
                FROM {$this->table} as oct
                INNER JOIN caracteristica AS ct ON oct.id_caracteristica = ct.id
                WHERE id_caracteristica = :id
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$results) return null;

            $characteristicOptions = new CharacteristicOptionsViewModel();
            $characteristicOptions->characteristicName = $results[0]['nome_caracteristica'];
            $options = [];
            foreach ($results as $row) {
                $options[] = $row['opcao'];
            }

            $characteristicOptions->options = $options;

            return $characteristicOptions;
        } catch (Exception $e) {
            error_log("Erro ao obter opções disponíveis para a característica com id '{$id}' ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }
}
