<?php
namespace App\Services;

use App\ViewModels\BeerDetailViewModel;
use App\Models\BeerModel;
use App\Repository\BeerRepository;
use App\ViewModels\BeerSummaryViewModel;
use Exception;

class BeerService {
    private readonly BeerRepository $beer_repository;

    public function __construct(BeerRepository $beer_repository) {
        $this->beer_repository = $beer_repository;
    }

    public function getAllBeers(): ?array {
        try {
            $beers = $this->beer_repository->getAllBeers();
            if (empty($beers)) {
                return null;
            }

            // Mapeia BeerModel → BeerSummaryViewModel
            $beersSummary = array_map(function (BeerModel $beer) {
                return new BeerSummaryViewModel([
                    'id' => $beer->id,
                    'name' => $beer->name,
                    'description' => $beer->description,
                    'img_path' => $beer->imgId ? "/assets/img/{$beer->imgId}.png" : null
                ]);
            }, $beers);

            return $beersSummary;
        } catch (Exception $e) {
            error_log("Erro ao obter cervejas ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function getBeerById(int $id): ?BeerDetailViewModel {
        if (!$id) return null;
        try {
            $beer = $this->beer_repository->getBeerById($id);
            if (!$beer) return null;

            // Obtém as características da cerveja
            $beerCharacteristics = $this->beer_repository->getBeerCharacteristicsByBeerId($id);
            // Popula o array de características da cerveja
            $beerWithDetails = new BeerDetailViewModel([
                'id' => $beer->id,
                'name' => $beer->name,
                'description' => $beer->description,
                'characteristics' => $beerCharacteristics ? $beerCharacteristics: [],
                'img_path' => $beer->imgId ? "/assets/img/{$beer->imgId}.png" : null,
                'creation_date' => $beer->creationDate
            ]);

            return $beerWithDetails;
        } catch (Exception $e) {
            error_log("Erro ao obter cerveja com id '{$id}' ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function getFeaturedBeers(): ?array {
        try {
            $beers = $this->beer_repository->getFeaturedBeers();
            if (empty($beers)) {
                return null;
            }

            // Mapeia BeerModel → BeerSummaryViewModel
            $beersSummary = array_map(function (BeerModel $beer) {
                return new BeerSummaryViewModel([
                    'id' => $beer->id,
                    'name' => $beer->name,
                    'description' => $beer->description,
                    'img_path' => $beer->imgId ? "/assets/img/{$beer->imgId}.png" : null
                ]);
            }, $beers);

            return $beersSummary;
        } catch (Exception $e) {
            error_log("Erro ao obter cervejas ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function getBeerSummaryByName(string $name): ?BeerSummaryViewModel {
        if (empty($name)) return null;
        try {
            $beer = $this->beer_repository->getBeerByName($name);
            if (!$beer) return null;

            // Mapeia BeerModel → BeerSummaryViewModel
            return new BeerSummaryViewModel([
                'id' => $beer->id,
                'name' => $beer->name,
                'description' => $beer->description, // A descrição pode ser útil
                'img_path' => $beer->imgId ? "/assets/img/{$beer->imgId}.png" : null
            ]);
            
        } catch (Exception $e) {
            error_log("Erro no service ao obter cerveja '{$name}' ({$e->getFile()}:{$e->getLine()}): " . $e->getMessage());
            return null;
        }
    }

    public function enrichRecommendationData(array $recommendation): array {
        if (empty($recommendation['categories'])) {
            return $recommendation;
        }

        // Itera sobre o array de recomendação
        foreach ($recommendation['categories'] as $catIndex => $category) {
            if (empty($category['items'])) {
                continue;
            }

            foreach ($category['items'] as $itemIndex => $item) {
                // $item['recommendation'] é o NOME da cerveja (ex: "IPA")
                $beerName = $item['recommendation'];
                
                // Busca no banco local os dados da cerveja pelo nome
                $beerData = $this->getBeerSummaryByName($beerName);

                if ($beerData) {
                    // Substitui o item (que era só um array com nome)
                    // pelo objeto BeerSummaryViewModel completo
                    $recommendation['categories'][$catIndex]['items'][$itemIndex] = $beerData;
                } else {
                    // Se não encontrar no banco local (raro), remove da lista
                    // para não quebrar a view.
                    unset($recommendation['categories'][$catIndex]['items'][$itemIndex]);
                }
            }
        }
        return $recommendation;
    }
}