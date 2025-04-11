<?php
namespace App\Service;

class Recaptcha
{
    private $secretKey;
    private $url = "https://www.google.com/recaptcha/api/siteverify?";

    public function __construct(string $secretkey)
    {
        $this->secretKey = $secretkey;
    }

    public function verify($captcha)
    {
        try {
            $url = $this->url . "secret=" . $this->secretKey . "&response=" . $captcha;
            $response = file_get_contents($url);
            $result = json_decode($response, true);
            if (!$result['success']) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            error_log("Erro do Exception :" . $e->getMessage());
            return false;
        }
    }
}
?>