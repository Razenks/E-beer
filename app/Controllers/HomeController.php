<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repository\BeerRepository;
use App\Services\BeerService;


class HomeController extends Controller {
    private readonly BeerService $beer_service;

    public function __construct() {
        $this->beer_service = new BeerService(new BeerRepository());
    }

    public function index(array $data = []): void {

        $data['featuredBeers'] = $this->beer_service->getFeaturedBeers();
        $data['title'] = 'E-BEER - Home';
        $data['user_type'] = $_SESSION['user_type'];
        $data['jwt'] = $_SESSION['jwt'];

        $this->render('pages.home.home', $data);
    }

    public function indexAdmin(array $data = []): void {
        $data['title'] = 'E-BEER - Admin';
        $data['user_type'] = $_SESSION['user_type'];
        $data['jwt'] = $_SESSION['jwt'];

        $this->render('pages.home.home_admin', $data);
    }
}