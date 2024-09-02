<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../CSS/cadastro-novo.css">
</head>

<body>
    <header id="imagem-top">
        <img src="../img/logo_ebeer.png" alt="">
    </header>
    <main>
        <h1>CADASTRO</h1>
        <form action="processa_usuario.php" method="post">
            <div id="nome-box">
                <label for="nome">Nome completo</label>
                <input type="text" placeholder="João Silva da Silva" id="nome" name="nome">
            </div>
            <br>
            <div id="email-box">
                <label for="email">E-mail</label>
                <input type="email" placeholder="joaosildasilva@gmail.com" id="email" name="email">
            </div>
            <br>
            <div id="cpf-box">
                <label for="cpf">CPF</label>
                <input type="number" placeholder="000.000.000-00" id="cpf" name="cpf">
            </div>
            <br>
            <div id="senha-box">
                <label for="senha">Senha</label>
                <input type="password" placeholder="**********" id="senha" name="senha">
            </div>
            <button type="submit" id="enter">CADASTRAR</button>
        </form>
    </main>
</body>

</html>