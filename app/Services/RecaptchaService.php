<?php
namespace App\Services;

class RecaptchaService
{
    private $secretKey;
    private $url = "https://www.google.com/recaptcha/api/siteverify?";

    public function __construct()
    {
        $this->secretKey = $_ENV['API_KEY_RECAPTCHA'];
    }

    public function validateCaptcha($captcha): bool
    {
        try {
            if(!$captcha)
            {
                return false;
            }
            
            $url = $this->url . "secret=" . $this->secretKey . "&response=" . $captcha;
            $response = file_get_contents($url);
            $result = json_decode($response, true);
            if (!$result['success']) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            error_log("Erro na função validateCaptcha :" . $e->getMessage());
            return false;
        }
    }
}
?>