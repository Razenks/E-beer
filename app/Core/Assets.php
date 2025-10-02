<?php
namespace App\Core;

class Assets
{
    private static array $styles = [];
    private static array $scripts = [];

    public static function addStyle(string $path, array $attributes = []): void {
        if (!isset(self::$styles[$path])) {
            self::$styles[$path] = [
                'path' => $path,
                'attributes' => $attributes
            ];
        }
    }

    public static function addScript(string $path, array $attributes = []): void {
        if (!isset(self::$scripts[$path])) {
            self::$scripts[$path] = [
                'path' => $path,
                'attributes' => $attributes
            ];
        }
    }

    public static function renderStyles(): void {
        foreach (self::$styles as $styleData) {
            $path = htmlspecialchars($styleData['path']);
            $attributes = self::buildAttributeString($styleData['attributes']);
            echo '<link rel="stylesheet" href="' . $path . '"' . $attributes . '>';
        }
    }

    public static function renderScripts(): void {
        foreach (self::$scripts as $scriptData) {
            $path = htmlspecialchars($scriptData['path']);
            $attributes = self::buildAttributeString($scriptData['attributes']);
            echo '<script src="' . $path . '"' . $attributes . '></script>';
        }
    }

    private static function buildAttributeString(array $attributes): string
    {
        if (empty($attributes)) {
            return '';
        }

        $parts = [];
        foreach ($attributes as $key => $value) {
            // Modo 1: ['async', 'defer'] -> a chave é um inteiro (0, 1, ...)
            if (is_int($key)) {
                $parts[] = $value; // Adiciona apenas o valor (ex: 'defer')
            } 
            // Modo 2: ['id' => 'meu-id'] -> a chave é uma string
            else {
                $parts[] = $key . '="' . htmlspecialchars($value, ENT_QUOTES) . '"';
            }
        }

        return ' ' . implode(' ', $parts);
    }
}