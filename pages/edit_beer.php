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

// Aqui você deve ter uma query SQL para listar as cervejas
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
    <title>Editar Cerveja</title>
    <link rel="stylesheet" href="../css/register_beer.css">
    <script src="../js/main-adm.js"></script>
</head>

<body>

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

        <form action="../config/atualiza_cerveja.php" method="post" enctype="multipart/form-data">

            <div id="form-left">
                <h1>Editar Cerveja</h1>
                <form action="../config/atualiza_cerveja.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id_cerveja" value="<?php echo $cervejaId ?>">
                    
                    <label for="">Nome cerveja</label>
                    <input type="text" name="nome" value="<?php echo $cerveja['nome']; ?>" required>
                    <label for="">Descrição</label>
                    <textarea name="descricao" id="descricao" required><?php echo $cerveja['descricao']; ?></textarea>
                    <label for="">Qual a cor da cerveja?</label>
                    <select name="cor" id="" required>
                        <option value="" disabled selected></option>
                        <option value="clara" <?php echo ($cerveja['desc_cor'] == 'clara') ? 'selected' : ''; ?>>Clara
                            (1-6 EBC)
                        </option>
                        <option value="dourada" <?php echo ($cerveja['desc_cor'] == 'dourada') ? 'selected' : ''; ?>>
                            Dourada (7-12
                            EBC)</option>
                        <option value="âmbar" <?php echo ($cerveja['desc_cor'] == 'âmbar') ? 'selected' : ''; ?>>Âmbar
                            (13-25 EBC)
                        </option>
                        <option value="cobre" <?php echo ($cerveja['desc_cor'] == 'cobre') ? 'selected' : ''; ?>>Cobre
                            (26-39 EBC)
                        </option>
                        <option value="marrom" <?php echo ($cerveja['desc_cor'] == 'marrom') ? 'selected' : ''; ?>>Marrom
                            (40-59
                            EBC)</option>
                        <option value="preta" <?php echo ($cerveja['desc_cor'] == 'preta') ? 'selected' : ''; ?>>Preta
                            (60+ EBC)
                        </option>
                    </select>
                    <label for="">Qual o teor alcoólico da cerveja?</label>
                    <select name="teor" id="" required>
                        <option value="" disabled selected></option>
                        <option value="baixo" <?php echo ($cerveja['desc_teor'] == 'baixo') ? 'selected' : ''; ?>>Baixo
                            (até 3,5%)</option>
                        <option value="moderado" <?php echo ($cerveja['desc_teor'] == 'moderado') ? 'selected' : ''; ?>>
                            Moderado (3,6% a 5,5%)</option>
                        <option value="alto" <?php echo ($cerveja['desc_teor'] == 'alto') ? 'selected' : ''; ?>>Alto
                            (5,6% a 7,5%)</option>
                        <option value="muito alto" <?php echo ($cerveja['desc_teor'] == 'muito alto') ? 'selected' : ''; ?>>Muito alto (acima de 7,5%)</option>
                    </select>
                    <label for="">Qual o amargor da cerveja?</label>
                    <select name="amargor" id="" required>
                        <option value="" disabled selected></option>
                        <option value="leve" <?php echo ($cerveja['desc_amargor'] == 'leve') ? 'selected' : ''; ?>>Leve (0
                            - 20
                            IBU)</option>
                        <option value="moderado" <?php echo ($cerveja['desc_amargor'] == 'moderado') ? 'selected' : ''; ?>>Moderado
                            (21 - 40 IBU)</option>
                        <option value="amargo" <?php echo ($cerveja['desc_amargor'] == 'amargo') ? 'selected' : ''; ?>>
                            Amargo (41 -
                            60 IBU)</option>
                        <option value="muito amargo" <?php echo ($cerveja['desc_amargor'] == 'muito amargo') ? 'selected' : ''; ?>>
                            Muito amargo (61 - 100+ IBU)</option>
                    </select>
                    <label for="">Como você descreveria o corpo da cerveja?</label>
                    <select name="corpo" id="" required>
                        <option value="" disabled selected></option>
                        <option value="leve" <?php echo ($cerveja['desc_corpo'] == 'leve') ? 'selected' : ''; ?>>Leve
                        </option>
                        <option value="médio" <?php echo ($cerveja['desc_corpo'] == 'médio') ? 'selected' : ''; ?>>médio
                        </option>
                        <option value="encorpado" <?php echo ($cerveja['desc_corpo'] == 'encorpado') ? 'selected' : ''; ?>>
                            Encorpado</option>
                    </select>
                    <label for="">Quais notas de aroma predominam na cerveja?</label>
                    <select name="aroma" id="" required>
                        <option value="" disabled selected></option>
                        <option value="frutado" <?php echo ($cerveja['desc_aroma'] == 'frutado') ? 'selected' : ''; ?>>
                            Frutado
                            (cítricos, frutas tropicais)</option>
                        <option value="floral" <?php echo ($cerveja['desc_aroma'] == 'floral') ? 'selected' : ''; ?>>
                            Floral
                            (flores, ervas)</option>
                        <option value="especiarias" <?php echo ($cerveja['desc_aroma'] == 'especiarias') ? 'selected' : ''; ?>>
                            Especiarias (cravo, canela)</option>
                        <option value="torrado" <?php echo ($cerveja['desc_aroma'] == 'torrado') ? 'selected' : ''; ?>>
                            Torrado
                            (chocolate, café)</option>
                        <option value="caramelo" <?php echo ($cerveja['desc_aroma'] == 'caramelo') ? 'selected' : ''; ?>>
                            Caramelo
                            (açúcar queimado, toffee)</option>
                    </select>
                    <label for="">Como você descreveria o sabor principal da cerveja?</label>
                    <select name="sabor" id="" required>
                        <option value="" disabled selected></option>
                        <option value="doce" <?php echo ($cerveja['desc_sabor'] == 'doce') ? 'selected' : ''; ?>>Doce
                        </option>
                        <option value="amargo" <?php echo ($cerveja['desc_sabor'] == 'amargo') ? 'selected' : ''; ?>>
                            Amargo</option>
                        <option value="ácido" <?php echo ($cerveja['desc_sabor'] == 'ácido') ? 'selected' : ''; ?>>Ácido
                        </option>
                        <option value="salgado" <?php echo ($cerveja['desc_sabor'] == 'salgado') ? 'selected' : ''; ?>>
                            Salgado</option>
                    </select>
                    <label for="">Qual é a carbonatação da cerveja?</label>
                    <select name="carbonacao" id="" required>
                        <option value="" disabled selected></option>
                        <option value="baixa" <?php echo ($cerveja['desc_carbona'] == 'baixa') ? 'selected' : ''; ?>>Baixa
                        </option>
                        <option value="moderada" <?php echo ($cerveja['desc_carbona'] == 'moderada') ? 'selected' : ''; ?>>
                            Moderada</option>
                        <option value="alta" <?php echo ($cerveja['desc_carbona'] == 'alta') ? 'selected' : ''; ?>>Alta
                        </option>
                    </select>
                    <label for="">Como você descreveria a sensação na boca?(mouthfeel)?</label>
                    <select name="mouthfeel" id="" required>
                        <option value="" disabled selected></option>
                        <option value="suave" <?php echo ($cerveja['desc_mouthfeel'] == 'suave') ? 'selected' : ''; ?>>
                            Suave
                        </option>
                        <option value="cremosidade" <?php echo ($cerveja['desc_mouthfeel'] == 'cremosidade') ? 'selected' : ''; ?>>
                            Cremosidade</option>
                        <option value="seco" <?php echo ($cerveja['desc_mouthfeel'] == 'seco') ? 'selected' : ''; ?>>Seco
                        </option>
                        <option value="efervescente" <?php echo ($cerveja['desc_mouthfeel'] == 'efervescente') ? 'selected' : ''; ?>>Efervescente</option>
                        <option value="aveludado" <?php echo ($cerveja['desc_mouthfeel'] == 'aveludado') ? 'selected' : ''; ?>>
                            Aveludado</option>
                    </select>
                    <label for="img_cerveja">Imagem Atual:</label>
                    <?php if (!empty($cerveja['img_cerveja'])): ?>
                        <img src="../assets/<?php echo $cerveja['img_cerveja']; ?>" alt="Imagem da cerveja"
                            style="width: 200px; height: auto;">
                    <?php else: ?>
                        <p>Nenhuma imagem cadastrada.</p>
                    <?php endif; ?>
                    <!-- Input para alterar a imagem -->
                    <label for="file-upload" class="custom-file-upload">
                        Alterar Imagem (se desejar)
                    </label>
                    <input id="file-upload" type="file" name="img_cerveja">
                    <button type="submit" id="button-register">Salvar alterações</button>
                </form>
            </div>
            <div id="form-right">


            </div>

        </form>
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