<?php
namespace App\Repository;

use App\Core\BaseRepository;
use App\Models\BeerModel;
use App\ViewModels\BeerCharacteristicViewModel;
use PDO;
use Exception;

class BeerRepository extends BaseRepository {
    protected string $table = 'cerveja';

    public function __construct() {
        parent::__construct();
    }

    public function getAllBeers(): ?array {
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

            /// Cria uma lista de BeerModels
            $beerList = array_map(fn($row) => BeerModel::fromArray($row), $results);

            return $beerList;
        } catch (Exception $e) {
            error_log("Erro ao obter cervejas ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function getBeerById(int $id): ?BeerModel {
        try {
            $sql = "
                SELECT * FROM {$this->table} WHERE id = :id
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return null;
            }

            $beer = new BeerModel();
            $beer->id = $result['id'];
            $beer->name = $result['nome'];
            $beer->description = $result['descricao'];
            $beer->imgId = $result['id_img_cerveja'] ?? 0;
            $beer->creationDate = $result['data_criacao'];
            // Array de características ainda vazio, será preenchido no service

            return $beer;
        } catch (Exception $e) {
            error_log("Erro ao obter a cerveja com id '{$id}': ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function getFeaturedBeers(): ?array {
        try {
            $sql = "
                SELECT * FROM {$this->table}
                ORDER BY data_criacao
                DESC LIMIT 10
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($results)) {
                return null;
            }

            /// Cria uma lista de BeerModels
            $beerList = array_map(fn($row) => BeerModel::fromArray($row), $results);

            return $beerList;
        } catch (Exception $e) {
            error_log("Erro ao obter últimas cervejas cadastradas: ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function getBeerCharacteristicsByBeerId(int $id): ?array {
        if (!$id) return null;
        try {
            $sql = "
                SELECT 
                    ct.id AS id_caracteristica,
                    ct.nome AS nome_caracteristica,
                    oct.opcao
                FROM {$this->table} c
                INNER JOIN cerveja_caracteristica cct ON cct.id_cerveja = c.id
                INNER JOIN caracteristica ct ON ct.id = cct.id_caracteristica
                INNER JOIN opcao_caracteristica oct ON oct.id = cct.id_opcao_caracteristica
                WHERE c.id = :id
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$results) return null;

            $beerCharacteristicsList = [];
            foreach ($results as $row) {
                $beerCharacteristic = new BeerCharacteristicViewModel();
                $beerCharacteristic->characteristicId = $row['id_caracteristica'];
                $beerCharacteristic->characteristicName = $row['nome_caracteristica'];
                $beerCharacteristic->option = $row['opcao'];
                
                $beerCharacteristicsList[] = $beerCharacteristic;
            }

            return $beerCharacteristicsList;
        } catch (Exception $e) {
            error_log("Erro ao obter características da cerveja com id '{$id}': ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function getBeerByName(string $name): ?BeerModel {
        try {
            $sql = "
                SELECT * FROM {$this->table} WHERE nome = :nome LIMIT 1
            ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nome', $name, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (empty($result)) {
                return null;
            }

            return BeerModel::fromArray($result);

        } catch (Exception $e) {
            error_log("Erro ao obter cerveja pelo nome '{$name}': ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }
}
