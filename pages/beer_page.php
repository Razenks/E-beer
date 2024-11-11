<?php
session_start(); // Inicia a sessão PHP para controlar as variáveis de sessão

// Verifica se o usuário está logado (se há dados na sessão)
if (empty($_SESSION)) {
    // Se a sessão estiver vazia (usuário não está autenticado), redireciona para a página de login com uma mensagem de erro
    header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
    // Outra redireção para a página inicial (pode ser redundante, pois a linha anterior já faz o redirecionamento)
    header("Location: index.php");
}

require_once '../config/conectaBD.php'; // Conexão com o banco de dados

$cervejaId = $_GET['id_cerveja']; // Ou a maneira como você obtém o ID

$sql = "
    SELECT c.*, 
           co.desc_cor, 
           a.desc_amargor, 
           ta.desc_teor, 
           cc.desc_corpo, 
           ar.desc_aroma, 
           sp.desc_sabor, 
           car.desc_carbona, 
           mf.desc_mouthfeel,
           img.img_cerveja
    FROM cerveja c
    LEFT JOIN cor co ON c.id_cor = co.id_cor
    LEFT JOIN amargor a ON c.id_amargor = a.id_amargor
    LEFT JOIN teor_alcoolico ta ON c.id_teor = ta.id_teor
    LEFT JOIN corpo_cerveja cc ON c.id_corpo = cc.id_corpo
    LEFT JOIN aroma ar ON c.id_aroma = ar.id_aroma
    LEFT JOIN sabor_principal sp ON c.id_sabor = sp.id_sabor
    LEFT JOIN carbonatacao car ON c.id_carbonatacao = car.id_carbonatacao
    LEFT JOIN mouthfeel mf ON c.id_mouthfeel = mf.id_mouthfeel
    LEFT JOIN img_cerveja img ON c.id_img_cerveja = img.id_img_cerveja
    WHERE c.id_cerveja = :id_cerveja
";

$stmt = $conexao->prepare($sql);
$stmt->execute([':id_cerveja' => $cervejaId]); // supondo que $idCerveja seja o ID da cerveja que você está editando
$cerveja = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->bindParam(':id_cerveja', $cervejaId, PDO::PARAM_INT);
$stmt->execute();
// Verifique se a cerveja foi encontrada
if (!$cerveja) {
    echo "Cerveja não encontrada!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerveja</title>
    <link rel="stylesheet" href="../css/cervejateste.css">
    <script src="../js/main-novo.js"></script>
    <script src="../js/perfil.js"></script>
</head>

<body>
    <header>
        <!-- Barra de navegação superior -->
        <nav id="navegation-bar">
            <div id="logo-image">
                <!-- Exibe a logo do site -->
                <a href="main_logado.php"><img src="../assets/logo_ebeer.png" alt="logo_ebeer"
                        style="width: 110px; height: 50px;"></a>
            </div>
            <div id="profile-config">
                <!-- Exibe o ícone de usuário e as informações de conta -->
                <img src="../assets/icons8-male-user-96.png" alt="" style="width: 50px; height: 50px;">
                <div id="name-account">
                    <!-- Exibe o nome do usuário logado obtido da sessão -->
                    <p>Olá,
                        <?php echo $_SESSION['nome']; ?>
                    </p>
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
        <div>
            <div id="corpo-main">
                <?php
                if ($cerveja) {
                    echo '<div id="beer-container">'; // Novo contêiner para o layout flex
                    echo '<div id="cerveja-img">';
                    echo '<img src="' . $cerveja['img_cerveja'] . '" alt="' . $cerveja['nome'] . '">';
                    echo '</div>';

                    echo '<div id="right-side">';

                    echo '<div id="top">';
                    echo '<h1>' . $cerveja['nome'] . '</h1>';
                    echo '<p id="descricao-text">' . $cerveja['descricao'] . '</p>';
                    echo '</div>';

                    echo '<div id="beer-characteristics">';
                    echo '<div><strong>Amargor:</strong> ' . $cerveja['desc_amargor'] . '</div>';
                    echo '<div><strong>Corpo:</strong> ' . $cerveja['desc_corpo'] . '</div>';
                    echo '<div><strong>Aroma:</strong> ' . $cerveja['desc_aroma'] . '</div>';
                    echo '<div><strong>Sabor:</strong> ' . $cerveja['desc_sabor'] . '</div>';
                    echo '<div><strong>Carbonatação:</strong> ' . $cerveja['desc_carbona'] . '</div>';
                    echo '<div><strong>Cor:</strong> ' . $cerveja['desc_cor'] . '</div>';
                    echo '<div><strong>Teor alcoólico:</strong> ' . $cerveja['desc_teor'] . '</div>';
                    echo '</div>'; // Fim da grid
                
                    echo '</div>'; // Fim do right-side
                    echo '</div>'; // Fim do beer-container
                } else {
                    echo '<p>Cerveja não encontrada.</p>';
                }
                ?>

            </div>
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