<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Services\CadastroService;

class CadastroController extends Controller {
    
    private readonly CadastroService $CadastarService;
     public function __construct(){
         
        $CadastarService = new CadastroService();    
    }
    

        // Mostra a tela de cadastro
    public function index() {
        self::render("cadastro.cadastro");
         $this->port  = $_ENV['PGHOST'] ?? '5432';
    }

    // Lida com envio do formulário
    public function salvar(Request $request): void {
        $nome = $request->post("nome");
        $email = $request->post("email");
        $senha = $request->post("senha");
        $cpf = $request->post("cpf");

        $dados = [
            "nome" => $nome,
            "email" => $email,
            "cpf" =>  $cpf,
            "senha" => $senha,
        ];

        $msgSuccess = "Cadastro realizado com sucesso";
        $msgFalid = "Não deu certo";
        
        if ($this->CadastarService->cadastrarUsuario($dados)){
            self::render("login.index", [ $msgSuccess]);
        }
        else{
            self::render("cadastro.cadastro", [ $msgFalid]);
        }
    }
}
