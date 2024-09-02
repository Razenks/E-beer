<?php
require_once 'conectaBD.php';

//Definir a BD (e a tabela)
//Conectar ao BD (Com o PHP)
//Obter as informações do formulário($_POST)
//Preparar as informações
//Realizar a inserção das informações no banco de dados(Com o PHP)
//Redirecionar para a página inicial(Login) c/ mensagem de erro ou sucesso

/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/

if (!empty($_POST)) {
    //Esta chegando dados por POST e então posso tentar inserir no banco 
    try {
        //Preparar as informações
        //Montar a SQL (pgsql)
        $sql = "INSERT INTO usuario 
        (nome, email, cpf, senha)
        VALUES
        (:nome, :email, :cpf, :senha)";
        //Preparar a SQL (PDO)
        $sstmt = $pdo->prepare($sql);
        //Definir/Organizar os Dados p/ SQL
        $dados = array(
            ':nome' => $_POST['nome'],
            ':email' => $_POST['email'],
            ':cpf' => $_POST['cpf'],
            ':senha' => md5($_POST['senha'])
        );
        //Tentar Executar a SQL (INSERT)
        if ($sstmt->execute($dados)) {
            header('Location: index.php?msgSucesso=Cadastro realizado com sucesso!');
        }
    } catch (PDOException $e) {
        //die($e->getMessage());
        header("Location: index.php?msgErro=falha ao cadastrar...");
    }
} else {
    header("Location: index.php?msgErro=Erro de Acesso.");
}
die();



?>