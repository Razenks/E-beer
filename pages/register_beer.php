<?php
session_start(); // Inicia a sessão PHP para controlar as variáveis de sessão

// Verifica se o usuário está logado (se há dados na sessão)
if (empty($_SESSION)) {
    // Se a sessão estiver vazia (usuário não está autenticado), redireciona para a página de login com uma mensagem de erro
    header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
    // Outra redireção para a página inicial (pode ser redundante, pois a linha anterior já faz o redirecionamento)
}

// Captura possíveis mensagens de sucesso ou erro passadas via URL através do método GET.
// As variáveis são inicializadas como strings vazias se não houver mensagens.
$msgSucessoCadastro = isset($_GET['msgSucesso']) ? $_GET['msgSucesso'] : '';
$msgErroCadastro = isset($_GET['msgError']) ? $_GET['msgError'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Cerveja</title>
    <link rel="stylesheet" href="../css/register_beer.css">
    <link rel="stylesheet" href="../css/acessibilidade.css">

    <script src="../js/main-adm.js"></script>
    <script src="..//js/acessibilidade.js"></script>

</head>

<body>
<div id="acessibilidade">
        <div id="fonte">
            <div>Tamanho da fonte: </div>
            <button class="alt-acess" onclick="diminuirFonte()" >A-</button>
            <button class="alt-acess" onclick="resetarFonte()">A</button>
            <button class="alt-acess" onclick="aumentarFonte()">A+</button>
        </div>

        <div id="cor">
            <div>Cor:</div>
            <button class="alt-acess" onclick="voltarModoOriginal()"><img src="../assets/sol.png" alt=""></button>
            <button class="alt-acess" onclick="alternarModoNoturno()"><img src="../assets/lua.png" alt=""></button>
        </div>


    </div>
    <div class="error-container">
        <?php
        // Verifica se uma mensagem de erro foi passada via GET e exibe na tela.
        if (isset($_GET['msgErro'])) {
            echo '<p class="error-msg">' . $_GET['msgErro'] . '</p>';
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

    <div id="first-section">

        <button id="register-beer"><a href="./register_beer.php">Cadastrar Cerveja</a></button>
        <button id="products"><a href="./main_admin.php">Produtos</a></button>
        <button id="user-manager">Gerenciamento de Usuários</button>
    </div>

    <main>
        <!-- Seção oculta com detalhes da conta do usuário -->
        <section id="account-details" style="display: none;">
            <!-- Ícone de fechar a seção -->
            <img src="../assets/botaox.png" alt="" id="button-close">

            <!-- Input para fazer o upload de uma foto de perfil -->
            <label for="picture_input" class="picture" tabindex="0">
                <span class="picture_image">Foto</span>
            </label>
            <input type="file" accept="image/*" id="picture_input">

            <!-- Exibe o nome completo do usuário da sessão -->
            <h1><?php echo $_SESSION['nome'] . ' ' . $_SESSION['sobrenome']; ?></h1>
            <!-- Exibe o email do usuário -->
            <p class="email-details"><?php echo $_SESSION['email']; ?></p>
            <!-- Exibe um telefone de exemplo (pode ser substituído por dados reais) -->
            <p class="phone-details">+55(67)98411-3344</p>
            <!-- Botão para alterar os dados do usuário -->
            <button type="button" id="change-data">Alterar meus dados</button>

            <!-- Botão para logout com ícone de desligar -->
            <button id="button-quit">
                <a href="../config/logout.php">
                    <div id="img-quit"><img src="../assets/icons8-desligar-52 (1).png" alt=""></div>
                    <div>Sair</div>
                </a>
            </button>
        </section>

        <form action="../config/processa_cerveja.php" method="post" enctype="multipart/form-data">

            <div id="form-left">
                <h1>Cadastrar Cerveja</h1>
                <label for="">Nome cerveja</label>
                <input type="text" name="nome" required>

                <label for="">Descrição</label>
                <textarea name="descricao" id="descricao" required></textarea>

                <label for="">Qual a cor da cerveja?</label>
                <select name="cor" id="" required>
                    <option value="" disabled selected></option>
                    <option value="clara">Clara (1-6 EBC)</option>
                    <option value="dourada">Dourada (7-12 EBC)</option>
                    <option value="âmbar">Âmbar (13-25 EBC)</option>
                    <option value="cobre">Cobre (26-39 EBC)</option>
                    <option value="marrom">Marrom (40-59 EBC)</option>
                    <option value="preta">Preta (60+ EBC)</option>
                </select>

                <label for="">Qual o teor alcoólico da cerveja?</label>
                <select name="teor" id="" required>
                    <option value="" disabled selected></option>
                    <option value="baixo">Baixo (até 3,5%)</option>
                    <option value="moderado">Moderado (3,6% a 5,5%)</option>
                    <option value="alto">Alto (5,6% a 7,5%)</option>
                    <option value="muito alto">Muito alto (acima de 7,5%)</option>
                </select>

                <label for="">Qual o amargor da cerveja?</label>
                <select name="amargor" id="" required>
                    <option value="" disabled selected></option>
                    <option value="leve">Leve (0 - 20 IBU)</option>
                    <option value="moderado">Moderado (21 - 40 IBU)</option>
                    <option value="amargo">Amargo (41 - 60 IBU)</option>
                    <option value="muito amargo">Muito amargo (61 - 100+ IBU)</option>
                </select>

                <label for="">Como você descreveria o corpo da cerveja?</label>
                <select name="corpo" id="" required>
                    <option value="" disabled selected></option>
                    <option value="leve">Leve</option>
                    <option value="médio">médio</option>
                    <option value="encorpado">Encorpado</option>
                </select>

                <label for="">Quais notas de aroma predominam na cerveja?</label>
                <select name="aroma" id="" required>
                    <option value="" disabled selected></option>
                    <option value="frutado">Frutado (cítricos, frutas tropicais)</option>
                    <option value="floral">Floral (flores, ervas)</option>
                    <option value="especiarias">Especiarias (cravo, canela)</option>
                    <option value="torrado">Torrado (chocolate, café)</option>
                    <option value="caramelo">Caramelo (açúcar queimado, toffee)</option>
                </select>

                <label for="">Como você descreveria o sabor principal da cerveja?</label>
                <select name="sabor" id="" required>
                    <option value="" disabled selected></option>
                    <option value="doce">Doce</option>
                    <option value="amargo">Amargo</option>
                    <option value="ácido">Ácido</option>
                    <option value="salgado">Salgado</option>
                </select>

                <label for="">Qual é a carbonatação da cerveja?</label>
                <select name="carbonacao" id="" required>
                    <option value="" disabled selected></option>
                    <option value="baixa">Baixa</option>
                    <option value="moderada">Moderada</option>
                    <option value="alta">Alta</option>
                </select>

                <label for="">Como você descreveria a sensação na boca?(mouthfeel)?</label>
                <select name="mouthfeel" id="" required>
                    <option value="" disabled selected></option>
                    <option value="suave">Suave</option>
                    <option value="cremosidade">Cremosidade</option>
                    <option value="seco">Seco</option>
                    <option value="efervescente">Efervescente</option>
                    <option value="aveludado">Aveludado</option>
                </select>
                <label for="file-upload" class="custom-file-upload">
                    Adicionar
                    <br>
                    Imagem
                </label>
                <input id="file-upload" type="file" name="img_cerveja" required />

                <button type="submit" id="button-register">CADASTRAR</button>
            </div>
            <div id="form-right">


            </div>

        </form>
    </main>

    <div id="imgAcess">
        <img src="../assets/acess.png" alt="" onclick="alterarAcessibilidade()">
    </div>
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