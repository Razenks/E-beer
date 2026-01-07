<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Services\{
    RecommendationApiService,
    BeerService
};
use App\Repository\{
    BeerRepository,
    CharacteristicOptionRepository
};
use App\ViewModels\{
    AnswersViewModel,
    AnswersCategoryViewModel,
    SelectedAnswersViewModel
};

class RecommendationController extends Controller {

    private RecommendationApiService $recommendation_service;
    private BeerService $beer_service;

    public function __construct() {
        // Instancia os repositórios e o service
        $beerRepository = new BeerRepository();
        $characteristicOptionRepository = new CharacteristicOptionRepository();
        $this->recommendation_service = new RecommendationApiService(
            $beerRepository,
            $characteristicOptionRepository
        );
        $this->beer_service = new BeerService($beerRepository);
    }

    public function index(?Request $request = null, array $data = []): void {
        $data['title'] = 'E-beer - BeerFeed';
        $data['user_type'] = $_SESSION['user_type'] ?? null;
        $data['jwt'] = $_SESSION['jwt'] ?? null;

        $this->render('pages.beer.beer_feed', $data);
    }

    public function getForm(array $data = []): void {
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

    public function getRecommendation(Request $request, array $data = []): void {
        $formId = $request->post('form_id');
        $answersByCategories = $request->post('answers');

        if (empty($formId) || !is_array($answersByCategories) || empty($answersByCategories)) {
            // Se dados inválidos, volta ao formulário com erro
            self::redirect('/beerFeed/formulario?error=Dados do formulário inválidos.');
            return;
        }

        try {
            $answersVm = new AnswersViewModel();
            $answersVm->formId = $formId;

            foreach ($answersByCategories as $categoryName => $answers) {
                $categoryVm = new AnswersCategoryViewModel();
                $categoryVm->name = $categoryName;

                foreach ($answers as $characteristic => $option) {
                    $selectedAnswersVm = new SelectedAnswersViewModel();
                    $selectedAnswersVm->characteristicAsked = $characteristic;
                    $selectedAnswersVm->selectedOption = $option;
                    $categoryVm->selectedAnswers[] = $selectedAnswersVm;
                }
                $answersVm->categories[] = $categoryVm;
            }

            $recommendation = $this->recommendation_service->getRecommendation($answersVm);

            if (!$recommendation) {
                self::redirect('/beerFeed/formulario?error=Não foi possível obter a recomendação da API.');
                return;
            }

            $enrichedRecommendation = $this->beer_service->enrichRecommendationData($recommendation);

            $data['title'] = 'E-beer - Sua Recomendação';
            $data['user_type'] = $_SESSION['user_type'] ?? null;
            $data['jwt'] = $_SESSION['jwt'] ?? null;
            $data['recommendation'] = $enrichedRecommendation;

            $this->render('pages.beer.recommendation', $data);
        } catch (\Throwable $e) {
            error_log("Erro em getRecommendation: " . $e->getMessage());
            self::redirect('/beerFeed/formulario?error=Ocorreu um erro interno ao processar sua solicitação.');
        }
    }
}
