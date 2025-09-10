<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="/assets/css/cadastro-novo.css">
    <link rel="stylesheet" href="/assets/css/all.css">
    <script src="/assets/js/cadastro-novo.js"></script>
    <script src="/assets/js/all.js"></script>
    <!-- Script do reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <header id="imagem-top">
        <!-- Exibe o logo no topo da página -->
        <img src="/assets/img/logo_ebeer.png" alt="">
    </header>
    
    <main>
        <h1>CADASTRO</h1>

        <!-- Div para exibir mensagens de erro, se houver -->
        <div class="error-container">
            <?php
            if (isset($error)) {
                echo '<p class="error-msg">' . $error . '</p>';
            }
            ?>
        </div>


        <!-- Div para exibir mensagens de sucesso, se houver -->
        <div class="sucesso-container">
            <?php
            // Verifica se uma mensagem de sucesso foi passada via GET e exibe na tela.
            if (isset($success)) {
                echo '<p class="sucesso-msg">' . $success . '</p>';
            }
            ?>
        </div>

        <!-- Formulário de cadastro que envia os dados para "processa_usuario.php" via POST -->
        <form action="/api/start-registration" method="post" id="form">
            <!-- Seção de entrada para nome e sobrenome -->
            <div id="nomes-box">
                <div id="nome-box">
                    <!-- Campo para o nome do usuário -->
                    <label for="nome">Nome</label>
                    <input type="text" placeholder="" id="nome" name="nome" required>
                </div>
                <div id="sobrenome-box">
                    <!-- Campo para o sobrenome do usuário -->
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" placeholder="" id="sobrenome" name="sobrenome" required>
                </div>
            </div>

            <br>

            <!-- Campo de entrada para o e-mail -->
            <div id="email-box">
                <label for="email">E-mail</label>
                <input type="email" placeholder="" id="email" name="email" required>
            </div>

            <br>

            <!-- Campo de entrada para o CPF -->
            <div id="cpf-box">
                <label for="cpf">CPF</label>
                <input type="text" placeholder="" id="cpf" name="cpf" maxlength="14" required>
            </div>
            <!-- Exibe erros de validação, se houver, em um parágrafo -->
            <p id="message-error"></p>

            <div id="captcha-container">
                <div class="g-recaptcha" data-sitekey="6LfhFQ8rAAAAAEi55UaZDqBpP6rcQLMr3f3lQmT9"></div>
            </div>

            <!-- Botão para submeter o formulário -->
            <button type="submit" id="enter">CADASTRAR</button>
        </form>

        <!-- Botão para cancelar o cadastro, redirecionando para a página inicial -->
        <button id="cancel"><a href="/login">Cancelar</a></button>
    </main>

</body>

</html>
