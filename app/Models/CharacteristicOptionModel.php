<?php
namespace App\Models;

class CharacteristicOptionModel {
    public int $id;
    public int $CharacteristicId;
    public string $option;
    public string $creationDate;

    public static function fromArray(array $data): self {
        $characteristic = new self();
        $characteristic->id = $data['id'] ?? 0;
        $characteristic->CharacteristicId = $data['id_caracteristica'] ?? 0;
        $characteristic->option = $data['opcao'] ?? '';
        $characteristic->creationDate = $data['data_criacao'] ?? '';

        return $characteristic;
    }
}