<?php
session_start();

// Verifica se o usuário está logado
if (empty($_SESSION)) {
    header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
    exit();
}

require_once '../config/conectaBD.php'; // Certifique-se de que o caminho está correto

try {
    // Recupera as cervejas do banco de dados
    $sql = "SELECT cerveja.id_cerveja, cerveja.nome, img_cerveja.img_cerveja 
            FROM cerveja 
            INNER JOIN img_cerveja ON cerveja.id_img_cerveja = img_cerveja.id_img_cerveja";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $cervejas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar cervejas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/main_admin.css">
    <link rel="stylesheet" href="../css/acessibilidade.css">

    <script src="../js/main-adm.js"></script>
    <script src="../js/perfil.js"></script>
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
            <p class="change-data"><button type="button" id="change-data">Alterar meus dados</button></p>

            <!-- Botão para logout com ícone de desligar -->
            <button id="button-quit">
                <a href="../config/logout.php">
                    <div id="img-quit"><img src="../assets/icons8-desligar-52 (1).png" alt=""></div>
                    <div>Sair</div>
                </a>
            </button>
        </section>

        <div id="first-section">

            <button id="register-beer"><a href="./register_beer.php">Cadastrar Cerveja</a></button>
            <button id="products">Produtos</button>
            <button id="user-manager">Gerenciamento de Usuários</button>
        </div>

        <!-- Segunda seção que lista produtos -->
        <section id="second-section">
            <h1>Produtos</h1>
            <!-- Botões de navegação para avançar e retroceder na lista de produtos -->

            <!-- Galeria de produtos (imagens de diferentes tipos de cerveja) -->
            <div id="second-section-images">
                <?php
                // Loop pelas cervejas recuperadas do banco de dados
                if (!empty($cervejas)) {
                    foreach ($cervejas as $cerveja) {
                        echo '<div>';
                        echo '<div>';
                        // Exibe a imagem da cerveja
                        echo '<img src="' . $cerveja['img_cerveja'] . '" alt="' . $cerveja['nome'] . '">';
                        // Exibe o nome da cerveja
                        echo '<p>' . $cerveja['nome'] . '</p>';
                        echo '</div>';
                        // Link para editar a cerveja
                        echo '<a href="edit_beer.php?id_cerveja=' . $cerveja['id_cerveja'] . '">Editar</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Nenhuma cerveja cadastrada.</p>';
                }
                ?>
            </div>
            <!-- Continua listando mais produtos da mesma forma -->
            <!-- O código repete a estrutura para cada tipo de cerveja disponível -->
        </section>
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