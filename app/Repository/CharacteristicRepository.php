<?php
namespace App\Repository;

use App\Core\BaseRepository;
use App\Models\CharacteristicModel;
use PDO;
use Exception;

class CharacteristicRepository extends BaseRepository {
    protected string $table = 'caracteristica';

    public function __construct() {
        parent::__construct();
    }

    public function getAllCharacteristics(): ?array {
        try {
            $sql = "
                SELECT * FROM {$this->table}
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($results)) {
                return null;
            }

            /// Cria uma lista de CharacteristicModel
            $characteristicsList = array_map(fn($row) => CharacteristicModel::fromArray($row), $results);

            return $characteristicsList;
        } catch (Exception $e) {
            error_log("Erro ao obter características ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function getCharacteristicById(int $id): ?CharacteristicModel {
        try {
            $sql = "
                SELECT * FROM {$this->table} WHERE id = :id
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return null;
            }

            $characteristic = new CharacteristicModel();
            $characteristic->id = $result['id'];
            $characteristic->name = $result['nome'];
            $characteristic->creationDate = $result['data_criacao'];

            return $characteristic;
        } catch (Exception $e) {
            error_log("Erro ao obter a característica com id '{$id}': ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }
}
