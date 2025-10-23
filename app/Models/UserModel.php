<?php
namespace App\Models;


class UserModel {
    private string $name;
    private string $email;
    private string $pass;
    private int $user_type;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    public function getUserType(): ?int
    {
        return $this->user_type;
    }

    public function setUserType(int $user_type): void
    {
        $this->user_type = $user_type;
    }
}