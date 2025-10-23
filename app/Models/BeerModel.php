<?php
namespace App\Models;

class BeerModel {
    public int $id;
    public string $name;
    public string $description;
    public int $imgId;
    public string $creationDate;

    public static function fromArray(array $data): self {
        $beer = new self();
        $beer->id = $data['id'] ?? 0;
        $beer->name = $data['nome'] ?? '';
        $beer->description = $data['descricao'] ?? '';
        $beer->imgId = $data['id_img_cerveja'] ?? 0;
        $beer->creationDate = $data['data_criacao'] ?? '';

        return $beer;
    }
}
