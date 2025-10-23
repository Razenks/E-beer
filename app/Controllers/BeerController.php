<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Repository\BeerRepository;
use App\Services\BeerService;

class BeerController extends Controller {
    private readonly BeerService $beer_service;

    public function __construct() {
        $this->beer_service = new BeerService(new BeerRepository());
    }

    public function index(?Request $request = null, array $data = []): void {
        $error = $request?->get('error');
        if ($error) {
            $data['error'] = $error;
        } else {
            $data['beers'] = $this->beer_service->getAllBeers();
        }
        $data['title'] = 'E-beer - Cervejas';
        $data['user_type'] = $_SESSION['user_type'];
        $data['jwt'] = $_SESSION['jwt'];

        $this->render('pages.beer.beers', $data);
    }

    public function getDetailedBeerPage(int $id): void {
        if (!$id) {
            http_response_code(400);
            echo "Não foi informado o id da cerveja.";
            return;
        }
        $beer = $this->beer_service->getBeerById($id); 

        if (!$beer) {
            http_response_code(404);
            echo "Cerveja não encontrada";
            return;
        }

        $data['beer'] = $beer;
        $data['title'] = 'E-beer - Detalhes da Cerveja';
        $data['user_type'] = $_SESSION['user_type'];
        $data['jwt'] = $_SESSION['jwt'];
        $this->render('pages.beer.beer', $data);
    }   

}
