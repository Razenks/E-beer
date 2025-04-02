<?php
session_start();

require '../config/conectaBD.php';

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 2) {
    // Redireciona para a página inicial com uma mensagem de erro
    header("Location: ../index.php?msgErro=Você precisa ser um administrador para acessar esta página.");
    session_destroy();
    exit();
}
// Verifica se o CPF foi passado na URL
if (!isset($_GET['cpf'])) {
    header("Location: manage_users.php?msgErro=Usuário não encontrado.");
    exit();
}

$cpf_usuario = $_GET['cpf'];



try {
    $sql = "SELECT 
                cpf, nome, sobrenome, email, data_cadastro, tipo_usuario, telefone
            FROM 
                usuario
            WHERE 
                cpf = :cpf";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([':cpf' => $cpf_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql_admin = "SELECT u.nome, u.email, u.senha, u.sobrenome, u.cpf, u.telefone, ft.img_foto_usuario
                    FROM usuario AS u
                    INNER JOIN 
                    foto_usuario AS ft ON u.id_foto_usuario = ft.id_foto_usuario
                    WHERE cpf = :cpf";

    $stmt_admin = $conexao->prepare($sql_admin);
    $stmt_admin->bindParam(':cpf', $_SESSION['cpf']);
    $stmt_admin->execute();
    $admin = $stmt_admin->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("Location: manage_users.php?msgErro=Usuário não encontrado.");
        exit();
    }
} catch (PDOException $e) {
    echo 'Erro ao conectar com o banco!' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cerveja</title>
    <link rel="stylesheet" href="../css/register_beer.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/acessibilidade.css">
    <script src="../js/acessibilidade.js"></script>
    <script src="../js/main-adm.js"></script>
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

    <div id="second-nav">
        <button id="register-beer"><a href="./register_beer.php">Cadastrar Cerveja</a></button>
        <button id="products"><a href="./main_admin.php">Produtos</a></button>
        <button id="user-manager"><a href="./manage_users.php">Gerenciamento de Usuários</a></button>
    </div>

    <main>
        <!-- Seção oculta com detalhes da conta do usuário -->
        <section id="account-details" style="display: none;">
            <img src="../assets/botaox.png" alt="" id="button-close">
            <!-- Mostrar a foto do usuário, se disponível -->
            <img src="<?php echo $admin['img_foto_usuario']; ?>" alt="Foto de perfil" id="profile-photo">

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

        <form action="../config/atualiza_usuario.php" method="post" enctype="multipart/form-data">
            <div id="form-left">
                <h1>Editar Usuário</h1>
                <input type="hidden" name="cpf" value="<?php echo $usuario['cpf']; ?>">

                <label for="nome">Nome do Usuario/Adm</label>
                <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required>

                <label for="sobrenome">Sobrenome</label>
                <input type="text" name="sobrenome" value="<?php echo $usuario['sobrenome']; ?>" required>

                <label for="cpf">CPF</label>
                <input type="text" name="cpf" value="<?php echo $usuario['cpf']; ?>" required readonly>

                <label for="email">Email</label>
                <input type="text" name="email" value="<?php echo $usuario['email']; ?>" required>

                <label for="telefone">Telefone (Se tiver)</label>
                <!-- Verifica se o telefone é nulo ou vazio e ajusta o valor no campo -->
                <input type="text" name="telefone"
                    value="<?php echo !empty($usuario['telefone']) ? $usuario['telefone'] : ''; ?>">

                <label for="tipo_usuario">Tipo de Usuario</label>
                <input type="text" name="tipo_usuario" maxlength="1" value="<?php echo $usuario['tipo_usuario']; ?>"
                    required>

                <label for="data_cadastro">Data de Cadastro</label>
                <input type="text" name="data_cadastro" value="<?php echo $usuario['data_cadastro']; ?>" required
                    readonly>

                <button type="submit" id="button-register">Salvar alterações</button>
            </div>
        </form>
    </main>

    <div id="imgAcess">
        <img src="../assets/acess.png" alt="" onclick="alterarAcessibilidade()">
    </div>

    <footer id="footer">
        <div id="last-section">
            <a href="">Voltar ao topo</a>
        </div>
        <p>e-Beer</p>
    </footer>
</body>

</html>