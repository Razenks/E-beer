<?php
session_start(); // Inicia a sessão PHP para controlar as variáveis de sessão

// Verifica se o usuário está logado (se há dados na sessão)
if (empty($_SESSION)) {
    // Se a sessão estiver vazia (usuário não está autenticado), redireciona para a página de login com uma mensagem de erro
    header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
}

require_once '../config/conectaBD.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beer-Test</title>
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/beer_test.css">
    <script src="../js/takequestions.js" type="module"></script>
    <script src="../js/main-novo.js"></script>
</head>

<body>
    <header>
        <!-- Barra de navegação superior -->
        <nav id="navegation-bar">
            <div id="logo-image">
                <!-- Exibe a logo do site -->
                <img src="../assets/logo_ebeer.png" alt="logo_ebeer" style="width: 110px; height: 50px;">
            </div>
            <div id="profile-config">
                <!-- Exibe o ícone de usuário e as informações de conta -->
                <img src="../assets/icons8-male-user-96.png" alt="" style="width: 50px; height: 50px;">
                <div id="name-account">
                    <!-- Exibe o nome do usuário logado obtido da sessão -->
                    <p>Olá, <?php echo $_SESSION['nome']; ?></p>
                    <!-- Botão para acessar a conta do usuário -->
                    <button id="account">Conta</button>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section id="account-details" style="display: none;">
            <!-- Ícone de fechar a seção -->
            <img src="../assets/botaox.png" alt="" id="button-close">

            <!-- Input para fazer o upload de uma foto de perfil -->
            <form action="../config/processa_main-logado.php" method="POST" enctype="multipart/form-data">
                <label for="picture_input" class="picture" tabindex="0">
                    <span class="picture_image">Foto</span>
                </label>
                <input type="file" accept="image/*" id="picture_input" name="perfil_foto">
                <button type="submit">Enviar</button>
            </form>

            <!-- Exibe o nome completo do usuário da sessão -->
            <h1><?php echo $_SESSION['nome'] . ' ' . $_SESSION['sobrenome']; ?></h1>
            <!-- Exibe o email do usuário -->
            <p class="email-details"><?php echo $_SESSION['email']; ?></p>
            <!-- Exibe um telefone de exemplo (pode ser substituído por dados reais) -->
            <p class="phone-details">+55(67)98411-3344</p>
            <!-- Botão para alterar os dados do usuário -->
            <p class="change-data"><button type="button" id="change-data">Alterar meus dados</button></p>

            <!-- Botão para logout com ícone de desligar -->
            <button id="button-quit">
                <a href="../config/logout.php">
                    <div id="img-quit"><img src="../assets/icons8-desligar-52 (1).png" alt=""></div>
                    <div>Sair</div>
                </a>
            </button>
        </section>

        <div id="main-container">
            <h2>Coffee Order</h2>
            <span class="question"></span>
            <div class="answers"></div>
        </div>
        <div class="show-info" style="display: none;">
            <span></span>
            <button>Next</button>
        </div>
        <div class="finish" style="display: none;">
            <span></span>
            <button>Refazer</button>
        </div>
    </main>
    <!-- Rodapé da página -->
    <footer id="footer">
        <div id="last-section">
            <!-- Link para voltar ao topo da página -->
            <a href="">Voltar ao topo</a>
        </div>
        <!-- Nome da marca no rodapé -->
        <p>e-Beer</p>
    </footer>
</body>

</html>