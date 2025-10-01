<?php
namespace App\Services;

use App\Models\UserModel;
class CadastroService{
    
    private readonly UserModel $user;


    public function __construct(){
        $user = new UserModel();        
    }

    public function cadastrarUsuario($dados): bool{
     
        if ($this->user->criar($dados)){
            return true;
        }
        else{
            return false;
        }
        
    }
}   