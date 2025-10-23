<?php
namespace App\Services;

use App\ViewModels\CharacteristicOptionsViewModel;
use App\ViewModels\CharacteristicViewModel;
use App\Repository\CharacteristicOptionRepository;

class CharacteristicService {
    private readonly CharacteristicOptionRepository $characteristic_option_repository;

    public function __construct(CharacteristicOptionRepository $characteristic_option_repository) {
        $this->characteristic_option_repository = $characteristic_option_repository;
    }

    public function createCharacteristic(string $name, string $value, array $options): CharacteristicViewModel {
        $c = new CharacteristicViewModel();
        $c->name = $name;
        $c->value = $value;
        $c->options = $options;
        return $c;
    }

    public function getAllOptionsByCharacteristicId(int $id): ?CharacteristicOptionsViewModel {
        if (!$id) return null;

        $characteristicOptions = $this->characteristic_option_repository->getAllOptionsByCharacteristicId($id);
        if (!$characteristicOptions) return null;

        return $characteristicOptions;
    }
}