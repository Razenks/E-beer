<?php
// Registra os assets que esta página necessita
use App\Core\Assets;

Assets::addStyle('/assets/css/login.css');
Assets::addStyle('/assets/css/all.css');
Assets::addScript('/assets/js/login.js');
Assets::addScript('/assets/js/all.js');
Assets::addScript('https://www.google.com/recaptcha/api.js', ['async', 'defer']);
?>

<header>
    <img src="/assets/img/logo_ebeer_2.png" alt="">
</header>
<main>
    <h1>LOGIN</h1>

    <div class="success-container">
        <?php
        if (isset($success)) {
            echo '<p class="sucesso-msg">' . $success . '</p>';
        }
        ?>
    </div>

    <div class="error-container">
        <?php
        if (isset($error)) {
            echo '<p class="error-msg">' . $error . '</p>';
        }
        ?>
    </div>

    <form action="/api/login" method="post" id="form-login">
        <div id="email-box">
            <label for="email">E-mail</label>
            <input type="email" placeholder="" id="email" name="email" required>
        </div>
        <br>
        <div id="password-box">
            <label for="senha">Senha</label>
            <div id="view-password">
                <input type="password" placeholder="" id="senha" name="senha" required>
                <button id="n-view-button" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                        <path
                            d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                        <path
                            d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                    </svg>
                </button>
                <button id="view-button" style="display: none;" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-eye-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                        <path
                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="captcha-container">
            <div class="g-recaptcha" data-sitekey="6LfhFQ8rAAAAAEi55UaZDqBpP6rcQLMr3f3lQmT9"></div>
        </div>

        <button type="submit" id="submit-btn">ENTRAR</button>
    </form>
    <button id="sign-up" type="submit"><a href="/cadastro">Cadastrar</a></button>
    <br>
    <button id="forgot-password">Esqueceu a senha?</button>
</main>