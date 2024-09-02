<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="./js/index.js"></script>
    <link rel="stylesheet" href="./CSS/index.css">
</head>

<body>
    <header id="imagem-top">
        <img src="./img/logo_ebeer.png" alt="">
    </header>
    <main>
        <h1>LOGIN</h1>
        <form action="#" method="post" id="form-login">
            <div id="email-box">
                <label for="email">E-mail</label>
                <input type="email" placeholder="joaosildasilva@gmail.com" id="email">
            </div>
            <br>
            <div id="password-box">
                <label for="password">Senha</label>
                <input type="password" placeholder="**********" id="senha">
            </div>
            <button type="submit" id="submit-btn"><a href="./PHP/main.php">ENTRAR</a></button>
        </form>
        <button id="sign-up"><a href="./PHP/cadastro.php">Cadastrar</a></button>
        <br>
        <button id="forgot-password">Esqueceu a senha?</button>
    </main>
</body>

</html>