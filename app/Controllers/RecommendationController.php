<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Services\RecommendationApiService;
use App\Repository\{
    BeerRepository,
    CharacteristicOptionRepository
};

class RecommendationController extends Controller {

    private RecommendationApiService $recommendation_service;

    public function __construct() {
        // Instancia os repositórios e o service
        $beerRepository = new BeerRepository();
        $characteristicOptionRepository = new CharacteristicOptionRepository();
        $this->recommendation_service = new RecommendationApiService(
            $beerRepository,
            $characteristicOptionRepository
        );
    }

    public function index(?Request $request = null, array $data = []) {
        $error = $request?->get('error');
        if ($error) {
            $data['error'] = $error;
        }

        $data['title'] = 'E-beer - BeerFeed';
        $data['user_type'] = $_SESSION['user_type'] ?? null;
        $data['jwt'] = $_SESSION['jwt'] ?? null;

        $this->render('pages.beer.beer_feed', $data);
    }

    public function getForm(?Request $request = null, array $data = []) {
        try {
            $form = $this->recommendation_service->getForm();

            if (!$form) {
                // Caso o serviço não retorne nada (erro na API ou banco vazio)
                $data['error'] = 'Não foi possível carregar o formulário de recomendação.';
                $data['form'] = [];
            } else {
                $data['form'] = $form;
            }

        } catch (\Throwable $e) {
            $data['error'] = 'Erro ao obter o formulário: ' . $e->getMessage();
            $data['form'] = [];
        }

        $data['title'] = 'E-beer - Recomendação';
        $data['user_type'] = $_SESSION['user_type'] ?? null;
        $data['jwt'] = $_SESSION['jwt'] ?? null;

        // Renderiza uma view (por exemplo: pages/beer/recommendation_form)
        $this->render('pages.beer.form', $data);
    }
}
