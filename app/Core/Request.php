<?php
namespace App\Core;

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $files;

    public function __construct(array $get = [], array $post = [], array $server = [], array $files = [])
    {
        $this->get = $get ?: $_GET;
        $this->post = $post ?: $_POST;
        $this->server = $server ?: $_SERVER;
        $this->files = $files ?: $_FILES;
    }

    public function get(string $key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }

    public function method(): string
    {
        return strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
    }

    public function uri(): string
    { // Pega a URI, isola o caminho da URL, remove barras extras no começo e fim, Sanitiza a URI
        return filter_var(trim(parse_url($this->server['REQUEST_URI'], PHP_URL_PATH), '/'), FILTER_SANITIZE_URL);
    }

    public function ip(): string
    {
        return $this->server['REMOTE_ADDR'] ?? 'DESCONHECIDO';
    }
}