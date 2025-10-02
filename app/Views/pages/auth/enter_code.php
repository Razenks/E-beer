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
        if (!empty($msgSucessoCode)) {
            echo '<p class="success-msg">' . htmlspecialchars($msgSucessoCode) . '</p>';
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

    <form action="/api/validate-code" method="post" id="form-enter-code">
        <div id="code-box">
            <input type="text" maxlength="6" placeholder="" id="codigo" name="codigo" required>
        </div>
        <button type="submit" id="submit-btn">Enviar</button>
    </form>
</main>
