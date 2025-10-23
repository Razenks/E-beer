<?php
namespace App\Services;

use App\Repository\{
    BeerRepository,
    CharacteristicOptionRepository
};
use App\ViewModels\{
    JsonViewModel,
    MenuViewModel,
    CategoryViewModel,
    ItemViewModel,
    CharacteristicViewModel
};

class RecommendationApiService {
    private readonly BeerRepository $beer_repository;
    private readonly CharacteristicOptionRepository $characteristic_option_repository;
    private string $api_url;

    public function __construct(BeerRepository $beer_repository, CharacteristicOptionRepository $characteristic_option_repository) {
        $this->beer_repository = $beer_repository;
        $this->characteristic_option_repository = $characteristic_option_repository;
        $this->api_url = $_ENV['API_RECOMMENDATION_URL'];
    }

    public function getForm(): ?array {
        $beers = $this->beer_repository->getAllBeers();
        if (!$beers) return null;

        $category = new CategoryViewModel();
        $category->name = 'Cervejas Artesanais';
        $category->items = [];

        foreach ($beers as $beer) {
            $item = new ItemViewModel();
            $item->name = $beer->name;
            $beerCharacteristics = $this->beer_repository->getBeerCharacteristicsByBeerId($beer->id);
            $characteristics = [];
            foreach ($beerCharacteristics as $beerCharacteristic) {
                $characteristicOptions = $this->characteristic_option_repository->getAllOptionsByCharacteristicId($beerCharacteristic->characteristicId);
                if (!$characteristicOptions) return null;
                $characteristic = $this->createCharacteristic($characteristicOptions->characteristicName, $beerCharacteristic->option, $characteristicOptions->options);
                $characteristics[] = $characteristic;
            }
            
            $item->characteristics = $characteristics;
            $category->items[] = $item;
        }

        $menu = new MenuViewModel();
        $menu->categories = [$category];

        $jsonViewModel = new JsonViewModel();
        $jsonViewModel->restaurant = 'E-Beer';
        $jsonViewModel->menu = $menu;

        return $this->sendToApi($jsonViewModel);
    }

    private function createCharacteristic(string $name, string $value, array $options): CharacteristicViewModel {
        $c = new CharacteristicViewModel();
        $c->name = $name;
        $c->value = $value;
        $c->options = $options;
        return $c;
    }

    private function sendToApi(JsonViewModel $json): ?array {
        try {
            $payload = json_encode($json, JSON_UNESCAPED_UNICODE);
            $url = 'http://api:5041/api/form/create';

            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_TIMEOUT => 15,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $response = curl_exec($ch);

            // Verifica erros do CURL
            if (curl_errno($ch)) {
                $err = curl_error($ch);
                curl_close($ch);
                error_log("Erro CURL: $err");
                return null;
            }

            // Verifica código HTTP
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode < 200 || $httpCode >= 300) {
                error_log("Erro HTTP ao chamar API ($httpCode): $response");
                return null;
            }

            // Decodifica a resposta
            $decoded = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("Erro ao decodificar JSON da API: " . json_last_error_msg());
                return null;
            }

            return $decoded;

        } catch (\Exception $ex) {
            error_log("Exceção ao chamar API: " . $ex->getMessage());
            return null;
        }
    }
}
