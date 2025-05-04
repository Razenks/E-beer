<?php
session_start();

require '../config/conectaBD.php';

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 2) {
    // Redireciona para a página inicial com uma mensagem de erro
    header("Location: ../index.php?msgErro=Você precisa ser um administrador para acessar esta página.");
    session_destroy();
    exit();
}


try {
    $sql = "SELECT 
            cpf, nome, sobrenome, email, data_cadastro, tipo_usuario 
        FROM 
            usuario";

    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sql_usuario = "SELECT u.nome, u.email, u.senha, u.sobrenome, u.cpf, u.telefone, ft.img_foto_usuario
                    FROM usuario AS u
                    INNER JOIN 
                    foto_usuario AS ft ON u.id_foto_usuario = ft.id_foto_usuario
                    WHERE cpf = :cpf";

    $stmt_usuario = $conexao->prepare($sql_usuario);
    $stmt_usuario->bindParam(':cpf', $_SESSION['cpf']);
    $stmt_usuario->execute();
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo 'Erro ao conectar com o banco!';
}

$msgSucessoUser = isset($_GET['msgSucessoUser']) ? $_GET['msgSucessoUser'] : '';
$msgErroCadastro = isset($_GET['msgErro']) ? $_GET['msgErro'] : '';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/main_admin.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/manage_users.css">
    <link rel="stylesheet" href="../css/acessibilidade.css">
    <script src="../js/all.js"></script>
    <script src="../js/acessibilidade.js"></script>
    <script src="../js/main-adm.js"></script>
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
                <a href="main_admin.php"><img src="../assets/logo_ebeer.png" alt="logo_ebeer"
                        style="width: 110px; height: 50px;"></a>
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

        <div id="second-nav">
            <button id="register-beer"><a href="./register_beer.php">Cadastrar Cerveja</a></button>
            <button id="products"><a href="./main_admin.php">Produtos</a></button>
            <button id="user-manager"><a href="./manage_users.php">Gerenciamento de Usuários</a></button>
        </div>

        <section class="alert">
            <h2>Usuarios</h2>
            <div class="success-container">
                <?php
                if (!empty($msgSucessoUser)) {
                    echo '<p class="success-msg">' . htmlspecialchars($msgSucessoUser) . '</p>';
                }
                ?>
            </div>

            <div class="error-container">
                <?php
                if (isset($_GET['msgErro'])) {
                    echo '<p class="error-msg">' . $_GET['msgErro'] . '</p>';
                }
                ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>CPF</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de Cadastro</th>
                        <th>Tipo de Usuario</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <?php
                if (!empty($usuarios)) {
                    foreach ($usuarios as $usuarios) {
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>' . $usuarios['cpf'] . '</td>';
                        echo '<td>' . $usuarios['nome'] . ' ' . $usuarios['sobrenome'] . '</td>';
                        echo '<td>' . $usuarios['email'] . '</td>';
                        echo '<td>' . $usuarios['data_cadastro'] . '</td>';
                        echo '<td>' . $usuarios['tipo_usuario'] . '</td>';
                        echo '<td> <a href="./tela_user.php?cpf=' . $usuarios['cpf'] . '">Editar</td>';
                        echo '</tr>';
                        echo '</tbody>';
                    }
                }
                ?>
            </table>
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