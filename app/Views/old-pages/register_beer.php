<?php
session_start(); // Inicia a sessão PHP para controlar as variáveis de sessão

require '../config/conectaBD.php';

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 2) {
    // Redireciona para a página inicial com uma mensagem de erro
    header("Location: ../index.php?msgErro=Você precisa ser um administrador para acessar esta página.");
    session_destroy();
    exit();
}
// Verifica se o usuário está logado (se há dados na sessão)
if (empty($_SESSION)) {
    header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
}

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
    echo 'Erro' . $e -> getMessage();
}

// Captura possíveis mensagens de sucesso ou erro passadas via URL através do método GET.
// As variáveis são inicializadas como strings vazias se não houver mensagens.
$msgSucessoBeer = isset($_GET['msgSucessoBeer']) ? $_GET['msgSucessoBeer'] : '';
$msgErroCadastro = isset($_GET['msgError']) ? $_GET['msgError'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Cerveja</title>
    <link rel="stylesheet" href="../css/register_beer.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" href="../css/acessibilidade.css">
    <script src="../js/all.js"></script>
    <script src="../js/acessibilidade.js"></script>
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
    <div class="error-container">
        <?php
        // Verifica se uma mensagem de erro foi passada via GET e exibe na tela.
        if (isset($_GET['msgErro'])) {
            echo '<p class="error-msg">' . $_GET['msgErro'] . '</p>';
        }
        ?>
    </div>


    <!-- Div para exibir mensagens de sucesso, se houver -->
    <div class="success-container">
        <?php
        if (!empty($msgSucessoBeer)) {
            echo '<p class="success-msg">' . htmlspecialchars($msgSucessoBeer) . '</p>';
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