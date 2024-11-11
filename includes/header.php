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
</header>