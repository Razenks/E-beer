<?php
// Registra os assets que esta página necessita
use App\Core\Assets;

Assets::addStyle('/assets/css/enter_code.css');
Assets::addStyle('/assets/css/all.css');
Assets::addScript('/assets/js/enter_code.js');
?>

<header>
    <img src="/assets/img/logo_ebeer_2.png" alt="">
</header>
<main>
    <h1>CÓDIGO</h1>

    <div class="success-container">
        <?php
        if (!empty($success)) {
            echo '<p class="success-msg">' . htmlspecialchars($success) . '</p>';
        }
        ?>
    </div>

    <div class="error-container">
        <?php
        if (!empty($error)) {
            echo '<p class="error-msg">' . htmlspecialchars($error) . '</p>';
        }
        ?>
    </div>

    <form action="/login/validar-codigo" method="post" id="form-enter-code">
        <div id="code-box">
            <input type="text" maxlength="6" placeholder="" id="codigo" name="codigo" required>
        </div>
        <button type="submit" id="submit-btn">Enviar</button>
    </form>
</main>
