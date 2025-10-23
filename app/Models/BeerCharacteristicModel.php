<?php
namespace App\Models;

class BeerCharacteristicModel {
    public int $id;
    public int $BeerId;
    public int $CharacteristicId;
    public int $CharacteristicOptionId;
    public string $creationDate;

    public static function fromArray(array $data): self {
        $characteristic = new self();
        $characteristic->id = $data['id'] ?? 0;
        $characteristic->BeerId = $data['id_cerveja'] ?? '';
        $characteristic->CharacteristicId = $data['id_caracteristica'] ?? 0;
        $characteristic->CharacteristicOptionId = $data['id_opcao_caracteristica'] ?? 0;
        $characteristic->creationDate = $data['data_criacao'] ?? '';

        return $characteristic;
    }
}