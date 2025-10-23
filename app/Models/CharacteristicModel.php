<?php
namespace App\Models;

class CharacteristicModel {
    public int $id;
    public string $name;
    public string $description;
    public string $creationDate;

    public static function fromArray(array $data): self {
        $characteristic = new self();
        $characteristic->id = $data['id'] ?? 0;
        $characteristic->name = $data['nome'] ?? '';
        $characteristic->description = $data['descricao'] ?? '';
        $characteristic->creationDate = $data['data_criacao'] ?? '';

        return $characteristic;
    }
}