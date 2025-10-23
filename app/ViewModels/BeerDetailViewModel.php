<?php
namespace App\ViewModels;

class BeerDetailViewModel {
    public int $id;
    public string $name;
    public string $description;
    public array $characteristics;
    public string $imgPath;
    public string $creationDate;

    public function __construct(array $data) {
        $this->id = (int)$data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->description = ucfirst($data['description']) ?? '';
        $this->characteristics = $data['characteristics'] ?? [];
        $this->imgPath = $data['img_path'] ?? '/assets/img/default_beer.png';
        $this->creationDate = $data['creation_date'] ?? '';
    }
}