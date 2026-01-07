<?php
use App\Core\Assets;

// Usaremos um CSS de "cartão de autenticação" reutilizável
Assets::addStyle('/assets/css/auth-card.css');
Assets::addScript('/assets/js/enter_code.js');
Assets::addScript('/assets/js/page-loader.js');
?>

<main class="auth-container">
    <div class="auth-card">
        
        <div class="logo-container">
            <img src="/assets/img/logo_ebeer_2.png" alt="Logo e-Beer">
        </div>

        <h1>Verifique seu E-mail</h1>
        <p class="subtitle">Enviamos um código de 6 dígitos para o seu e-mail. Digite-o abaixo para continuar.</p>

        <form action="/login/validar-codigo" method="post" id="form-enter-code" data-show-loader>
            <div id="code-box">
                <label for="codigo" class="sr-only">Código de 6 dígitos</label>
                <input type="text" maxlength="6" placeholder="______" id="codigo" name="codigo" required>
            </div>
            <button type="submit" class="btn btn-primary" id="submit-btn">Validar Código</button>
        </form>
    </div>
</main>