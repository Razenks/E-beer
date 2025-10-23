<?php
namespace App\ViewModels;

class JsonViewModel {
    public string $restaurant;
    public MenuViewModel $menu;
    public ?int $questionLimitPerCategory;
}