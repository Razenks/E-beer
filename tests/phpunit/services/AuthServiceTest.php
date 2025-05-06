<?php
namespace Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Models\UserModel;
use App\Services\AuthService;

class AuthServiceTest extends TestCase
{
    private function definedMockAndReturn(string $method, string $email, string $pass)
    {
        $userMock = $this->createMock(UserModel::class);
        $userMock->method("{$method}")->willReturn(
            [
                'email' => "{$email}",
                'senha' => password_hash("{$pass}", PASSWORD_DEFAULT)
            ]
        );
        return $userMock;
    }

    public function testValidateUserDataCorrect(): void
    {
        $userMock = $this->definedMockAndReturn('findByEmail', 'test@example.com', '123456');
        $authService = new AuthService($userMock);
        $result = $authService->validateUser('test@example.com', '123456');
        $this->assertIsArray($result);
        $this->assertEquals('test@example.com', $result['email']);
    }

    public function testValidateUserWrongPass(): void
    {
        $userMock = $this->definedMockAndReturn('findByEmail', 'test@example.com', '123456');
        $authService = new AuthService($userMock);
        $result = $authService->validateUser('test@example.com', 'user123');
        $this->assertFalse($result);
    }

    public function testValidateUserWrongEmail(): void
    {
        $userMock = $this->definedMockAndReturn('findByEmail', 'user123@example.com', '123456');
        $authService = new AuthService($userMock);
        $result = $authService->validateUser('user123@example.com', 'user123');
        $this->assertFalse($result);
    }
}