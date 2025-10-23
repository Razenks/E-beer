<?php

use App\Core\Assets;

Assets::addStyle('/assets/css/cadastro.css');
Assets::addScript('/assets/js/cadastro-novo.js');
Assets::addScript('https://www.google.com/recaptcha/api.js', ['async', 'defer']);
?>

<main class="cadastro-container">
    <div class="cadastro-card">
        <div class="logo-cadastro">
            <img src="/assets/img/logo_ebeer_2.png" alt="Logo e-Beer">
        </div>

        <h2>Cadastro</h2>

        <!-- Div para exibir mensagens de erro, se houver -->
        <div class="error-container">
            <?php
            if (isset($error)) {
                echo '<p class="error-msg">' . $error . '</p>';
            }
            ?>
        </div>


        <!-- Div para exibir mensagens de sucesso, se houver -->
        <div class="sucesso-container">
            <?php
            // Verifica se uma mensagem de sucesso foi passada via GET e exibe na tela.
            if (isset($success)) {
                echo '<p class="sucesso-msg">' . $success . '</p>';
            }
            ?>
        </div>

        <form action="/cadastrar" method="post" id="form">
            <div class="form-row">
                <div class="form-group">
                    <input type="text" placeholder="Nome" name="nome" required>
                </div>
                <div class="form-group">
                    <input type="text" placeholder="Sobrenome" name="sobrenome" required>
                </div>
            </div>

            <div class="form-group">
                <input type="email" placeholder="E-mail" name="email" required>
            </div>

            <div class="form-group">
                <input type="text" placeholder="CPF" name="cpf" maxlength="14" required>
            </div>

            <div class="form-group">
                <input type="password" placeholder="Senha" required>
            </div>

            <div class="form-group">
                <input type="password" placeholder="Confirmar senha" required>
            </div>

            <div id="captcha-container">
                <div class="g-recaptcha" data-sitekey="6LfhFQ8rAAAAAEi55UaZDqBpP6rcQLMr3f3lQmT9"></div>
            </div>

            <button type="submit" class="btn-primary">Cadastrar</button>
        </form>

        <div class="cadastro-links">
            <a href="/login">Já tenho conta</a>
        </div>
    </div>
</main>