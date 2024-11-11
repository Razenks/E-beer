<?php
// Captura possíveis mensagens de sucesso ou erro passadas via URL através do método GET.
// As variáveis são inicializadas como strings vazias se não houver mensagens.
$msgSucessoCadastro = isset($_GET['msgSucesso']) ? $_GET['msgSucesso'] : '';
$msgErroCadastro = isset($_GET['msgErro']) ? $_GET['msgErro'] : '';
$msgErroCadastroRepetidade = isset($_GET['msgErroCadastro']) ? $_GET['msgErroCadastro'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <!-- Link para o arquivo CSS que contém as definições de estilo da página -->
    <link rel="stylesheet" href="../css/cadastro-novo.css">
    <!-- Script JavaScript para a lógica associada à página de cadastro -->
    <script src="../js/cadastro-novo.js"></script>
</head>

<body>
    <header id="imagem-top">
        <!-- Exibe o logo no topo da página -->
        <img src="../assets/logo_ebeer.png" alt="">
    </header>
    
    <main>
        <h1>CADASTRO</h1>

        <!-- Div para exibir mensagens de erro, se houver -->
        <div class="error-container">
            <?php
            // Verifica se uma mensagem de erro foi passada via GET e exibe na tela.
            if (isset($_GET['msgErro'])) {
                echo '<p class="error-msg">' . $_GET['msgErro'] . '</p>';
            }
            ?>
        </div>

        <!-- Segunda div para mensagens de erro repetidas ou específicas de cadastro -->
        <div class="error-container">
            <?php
            // Verifica se há uma mensagem específica de erro de cadastro e a exibe.
            if (isset($_GET['msgErroCadastro'])) {
                echo '<p class="error-msg">' . $_GET['msgErroCadastro'] . '</p>';
            }
            ?>
        </div>

        <div class="error-container">
            <?php
            // Verifica se há uma mensagem específica de erro de cadastro e a exibe.
            if (isset($_GET['MsgErrorName'])) {
                echo '<p class="error-msg">' . $_GET['MsgErrorName'] . '</p>';
            }
            ?>
        </div>

        <div class="error-container">
            <?php
            // Verifica se há uma mensagem específica de erro de cadastro e a exibe.
            if (isset($_GET['msgErrorEmail'])) {
                echo '<p class="error-msg">' . $_GET['msgErrorEmail'] . '</p>';
            }
            ?>
        </div>

        <div class="error-container">
            <?php
            // Verifica se há uma mensagem específica de erro de cadastro e a exibe.
            if (isset($_GET['msgErrorSenha'])) {
                echo '<p class="error-msg">' . $_GET['msgErrorSenha'] . '</p>';
            }
            ?>
        </div>

        <!-- Div para exibir mensagens de sucesso, se houver -->
        <div class="sucesso-container">
            <?php
            // Verifica se uma mensagem de sucesso foi passada via GET e exibe na tela.
            if (isset($_GET['msgSucesso'])) {
                echo '<p class="sucesso-msg">' . $_GET['msgSucesso'] . '</p>';
            }
            ?>
        </div>


        <!-- Formulário de cadastro que envia os dados para "processa_usuario.php" via POST -->
        <form action="../config/processa_usuario.php" method="post" id="form">
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

            <br>

            <!-- Campo de entrada para a senha com botão para exibir/esconder a senha -->
            <div id="senha-box">
                <label for="senha">Senha</label>
                <div id="view-password">
                    <!-- Campo de senha do usuário -->
                    <input type="password" placeholder="" id="senha" name="senha" required>
                    <!-- Botão para alternar entre mostrar/esconder a senha -->
                    <button id="n-view-button" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                            <!-- Ícone de olho com um traço indicando que a senha está oculta -->
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                        </svg>
                    </button>

                    <!-- Botão para alternar para mostrar a senha -->
                    <button id="view-button" style="display: none;" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <!-- Ícone de olho indicando que a senha está visível -->
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <br>

            <!-- Campo de entrada para a confirmação da senha com botão para mostrar/esconder -->
            <div id="confirm-senha-box">
                <label for="senha">Confirmar Senha</label>
                <div id="view-password-second">
                    <!-- Campo para confirmar a senha -->
                    <input type="password" placeholder="" id="confirm-senha" name="confirm-senha" required>
                    <!-- Botão para esconder a confirmação de senha -->
                    <button id="n-view-button-second" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                            <!-- Ícone de olho com traço indicando que a senha está oculta -->
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                        </svg>
                    </button>

                    <!-- Botão para mostrar a confirmação de senha -->
                    <button id="view-button-second" style="display: none;" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <!-- Ícone de olho indicando que a senha está visível -->
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Exibe erros de validação, se houver, em um parágrafo -->
            <p id="message-error"></p>

            <!-- Botão para submeter o formulário -->
            <button type="submit" id="enter">CADASTRAR</button>
        </form>

        <!-- Botão para cancelar o cadastro, redirecionando para a página inicial -->
        <button id="cancel"><a href="../index.php">Cancelar</a></button>
    </main>

</body>

</html>
