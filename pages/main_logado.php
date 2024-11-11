<?php
session_start(); // Inicia a sessão PHP para controlar as variáveis de sessão

// Verifica se o usuário está logado (se há dados na sessão)
if (empty($_SESSION)) {
    // Se a sessão estiver vazia (usuário não está autenticado), redireciona para a página de login com uma mensagem de erro
    header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
    // Outra redireção para a página inicial (pode ser redundante, pois a linha anterior já faz o redirecionamento)
    header("Location: index.php");
}

require_once '../config/conectaBD.php';

try {
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
    <!-- Meta tags para especificar o conjunto de caracteres e tornar o layout responsivo -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-beer</title> <!-- Título da página -->

    <!-- Vincula o arquivo CSS externo para estilizar a página -->
    <link rel="stylesheet" href="../css/main_logado.css">

    <!-- Vincula arquivos JavaScript externos para funcionalidades da página -->
    <script src="../js/main-novo.js"></script>
    <script src="../js/perfil.js"></script>
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
        <!-- Seção oculta com detalhes da conta do usuário -->
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

        <!-- Primeira seção da página principal -->
        <section id="first-section">
            <h1>Encontrar sua cerveja perfeita <br> nunca foi tao fácil</h1>
            <!-- Botão para acessar o "BeerFeed", provavelmente uma funcionalidade interativa -->
            <button id="beer-test">BeerFeed</button>
        </section>

        <!-- Segunda seção que lista produtos -->
        <section id="second-section">
            <h1>Produtos</h1>
            <!-- Botões de navegação para avançar e retroceder na lista de produtos -->
            <button id="button-back"><img src="../assets/icons8-voltar-72.png" alt=""></button>
            <button id="button-advance" type="button"><img src="../assets/icons8-avançar-72.png" alt=""></button>

            <!-- Galeria de produtos (imagens de diferentes tipos de cerveja) -->
            <div id="second-section-images">
                <?php
                if (!empty($cervejas)) {
                    foreach ($cervejas as $cervejas) {
                        echo '<div>';
                        echo '<div>';
                        echo '<img src="' . $cervejas['img_cerveja'] . '"alt="' . $cervejas['nome'] . '">';
                        echo '<p>' . $cervejas['nome'] . '</p>';
                        echo '</div>';
                        echo '<a href="beer_page.php?id_cerveja=' . $cervejas['id_cerveja'] . '">Ver Detalhes</a>';
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

        <!-- Terceira seção explicando como funciona o e-Beer -->
        <section id="third-section">
            <h2>Como funciona o e-Beer?</h2>
            <!-- Imagem decorativa -->
            <img src="../assets/canecas.png" alt="">
            <!-- Texto explicativo sobre o funcionamento do e-Beer -->
            <p id="third-section-text">Com o e-beer, você pode responder ao nosso questionário interativo, o BeerFeed, e
                receber recomendações personalizadas de cervejas artesanais que combinam perfeitamente com o seu
                paladar. Basta algumas respostas para encontrar a cerveja ideal para o seu gosto</p>
        </section>
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