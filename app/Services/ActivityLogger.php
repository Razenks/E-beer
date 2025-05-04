<?php
namespace App\Services;

class ActivityLogger 
{
    protected string $logPath;

    public function __construct()
    {
        $this->logPath = __DIR__ . "/../../storage/logs/activiry.log";

        if(!file_exists(dirname($this->logPath)))
        {
            mkdir(dirname($this->logPath), 0777, true);
        }
    }

    public function log(string $action, ?array $extra = []): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'DESCONHECIDO';
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'DESCONHECIDO';
        $sessionId = session_id() ?: 'NO-SESSION';

        $extraData = json_encode($extra, JSON_UNESCAPED_UNICODE);

        $entry = sprintf(
            "[%s] IP: %s - Sessão: %s - Ação: %s - URI: %s - UA: %s - Extra: %s\n",
            date('Y-m-d H:i:s'),
            $ip,
            $sessionId,
            $action,
            $uri,
            $userAgent,
            $extraData
        );

        file_put_contents($this->logPath, $entry, FILE_APPEND | LOCK_EX);
    }
}