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

$sql_usuario = "SELECT u.nome, u.email, u.senha, u.sobrenome, u.cpf, u.telefone, ft.img_foto_usuario
                FROM usuario AS u
                INNER JOIN 
                    foto_usuario AS ft ON u.id_foto_usuario = ft.id_foto_usuario
                WHERE cpf = :cpf";

try {
    $stmt_usuario = $conexao->prepare($sql_usuario);
    $stmt_usuario->bindParam(':cpf', $_SESSION['cpf']);
    $stmt_usuario->execute();
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo 'Erro' . $e->getMessage();
}


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
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/acessibilidade.css">
    <script src="../js/acessibilidade.js"></script>
    <script src="../js/main-novo.js"></script>
    <script src="../js/all.js"></script>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>

</head>

<body>
    <div id="acessibilidade">
        <div id="fonte">
            <div>Tamanho da fonte: </div>
            <button class="alt-acess" onclick="diminuirFonte()">A-</button>
            <button class="alt-acess" onclick="resetarFonte()">A</button>
            <button class="alt-acess" onclick="aumentarFonte()">A+</button>
        </div>

        <div id="cor">
            <div>Cor:</div>
            <button class="alt-acess" onclick="voltarModoOriginal()"><img src="../assets/sol.png" alt=""></button>
            <button class="alt-acess" onclick="alternarModoNoturno()"><img src="../assets/lua.png" alt=""></button>
        </div>
    </div>

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>

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
            <img src="../assets/botaox.png" alt="" id="button-close">
            <!-- Mostrar a foto do usuário, se disponível -->
            <img src="<?php echo $usuario['img_foto_usuario']; ?>" alt="Foto de perfil" id="profile-photo">

            <h1 id="titulo-account"><?php echo $_SESSION['nome'] . ' ' . $_SESSION['sobrenome']; ?></h1>

            <p class="email-details"><?php echo $_SESSION['email']; ?></p>

            <p class="phone-details"><?php echo !empty($usuario['telefone']) ? $usuario['telefone'] : ''; ?></p>

            <button id="change-data" class="change-data">Alterar meus dados</button>

            <button id="button-quit">
                <a href="../config/logout.php">
                    <div id="img-quit"><img src="../assets/icons8-desligar-52 (1).png" alt=""></div>
                    <div>Sair</div>
                </a>
            </button>
        </section>

        <section id="change-data-details" style="display: none;">
            <img src="../assets/botaox.png" alt="" id="button-back-details">
            <form action="../config/alterar_dados.php" method="POST" id="change-data-inputs"
                enctype="multipart/form-data">
                <label for="picture_input" class="picture" tabindex="0">
                    <img id="picture_preview" alt="Pré-visualização da foto" class="picture_img">
                    <input type="file" accept="image/*" id="picture_input" name="foto">
                </label>


                <div>
                    <label for="nome">Nome: </label>
                    <input type="text" name="nome" value="<?php echo $_SESSION['nome'] ?>">
                </div>
                <div>
                    <label for="sobrenome">Sobrenome: </label>
                    <input type="text" name="sobrenome" value="<?php echo $_SESSION['sobrenome'] ?>">
                </div>
                <div>
                    <label for="email">Email: </label>
                    <input type="text" name="email" value="<?php echo $_SESSION['email'] ?>">
                </div>
                <div>
                    <label for="cpf">CPF: </label>
                    <input type="text" name="cpf" value="<?php echo $_SESSION['cpf'] ?>" readonly>
                </div>
                <div>
                    <label for="telefone">Telefone: </label>
                    <input type="text" name="telefone" id="change-telefone"
                        value="<?php echo !empty($usuario['telefone']) ? $usuario['telefone'] : ''; ?>" maxlength="15">
                </div>
                <button type="submit" id="save-data-changes">Salvar Alterações</button>
            </form>
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