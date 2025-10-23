<?php
namespace App\ViewModels;

class BeerSummaryViewModel {
    public int $id;
    public string $name;
    public string $description;
    public string $imgPath;

    public function __construct(array $data) {
        $this->id = (int)$data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->imgPath = $data['img_path'] ?? '/assets/img/default_beer.png';
    }
}