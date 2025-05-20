<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-beer</title>
    <link rel="stylesheet" href="assets/css/main_logado.css">
    <link rel="stylesheet" href="assets/css/all.css">
    <link rel="stylesheet" href="assets/css/acessibilidade.css">
    <script src="/assets/js/acessibilidade.js"></script>
    <script src="/assets/js/main-novo.js"></script>
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>new window.VLibras.Widget('https://vlibras.gov.br/app');</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
            <button class="alt-acess" onclick="voltarModoOriginal()"><img src="/assets/img/sol.png" alt=""></button>
            <button class="alt-acess" onclick="alternarModoNoturno()"><img src="/assets/img/lua.png" alt=""></button>
        </div>
    </div>

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>

    <header>
        <nav id="navegation-bar">
            <div id="logo-image">
                <a href="main_logado.php"><img src="/assets/img/logo_ebeer.png" alt="logo_ebeer"
                        style="width: 110px; height: 50px;"></a>
            </div>
            <div id="profile-config">
                <img src="/assets/img/icons8-male-user-96.png" alt="" style="width: 50px; height: 50px;">
                <div id="name-account">
                    <p>Olá, <?php echo $_SESSION['name']; ?></p>
                    <button id="account">Conta</button>
                </div>
            </div>
        </nav>
    </header>

    <section id="account-details" style="display: none;">
        <img src="/assets/botaox.png" alt="" id="button-close">
        <!-- Mostrar a foto do usuário, se disponível -->
        <img src="<?php echo $usuario['img_foto_usuario']; ?>" alt="Foto de perfil" id="profile-photo">

        <h1 id="titulo-account"><?php echo $_SESSION['name'] . ' ' . $_SESSION['lastname']; ?></h1>

        <p class="email-details"><?php echo $_SESSION['email']; ?></p>

        <p class="phone-details"><?php echo !empty($usuario['telefone']) ? $usuario['telefone'] : ''; ?></p>

        <button id="change-data" class="change-data">Alterar meus dados</button>

        <button id="button-quit">
            <a href="/login">
                <div id="img-quit"><img src="/assets/img/icons8-desligar-52 (1).png" alt=""></div>
                <div>Sair</div>
            </a>
        </button>
    </section>

    <section id="change-data-details" style="display: none;">
        <img src="/assets/botaox.png" alt="" id="button-back-details">
        <form action="../config/alterar_dados.php" method="POST" id="change-data-inputs" enctype="multipart/form-data">
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

    <section id="first-section">
        <h1 id="titulo-beer-test">Encontrar sua cerveja perfeita <br> nunca foi tao fácil</h1>
        <a href="beer_test.php" id="beer-test"><button>BeerFeed</button></a>
    </section>

    <section id="second-section">
        <h1>Produtos</h1>
        <button id="button-back"><img src="../assets/icons8-voltar-72.png" alt=""></button>
        <button id="button-advance" type="button"><img src="../assets/icons8-avançar-72.png" alt=""></button>

        <div id="second-section-images">
            <?php
            if (!empty($cervejas)) {
                foreach ($cervejas as $cerveja) {
                    echo '<div>';
                    echo '<div>';
                    echo '<img src="' . $cerveja['img_cerveja'] . '" alt="' . $cerveja['nome'] . '">';
                    echo '<p>' . $cerveja['nome'] . '</p>';
                    echo '</div>';
                    echo '<a href="beer_page.php?id_cerveja=' . $cerveja['id_cerveja'] . '">Ver Detalhes</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>Nenhuma cerveja cadastrada.</p>';
            }
            ?>
        </div>
    </section>

    <section id="third-section">
        <h2>Como funciona o e-Beer?</h2>
        <img src="../assets/canecas.png" alt="">
        <p id="third-section-text">Com o e-beer, você pode responder ao nosso questionário para encontrar a cerveja
            ideal para o seu paladar. Além disso, você pode explorar diversas opções em nosso catálogo de produtos.
        </p>
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