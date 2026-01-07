<?php
use App\Core\Assets;

Assets::addStyle('/assets/css/beer_feed.css');
Assets::addScript('/assets/js/page-loader.js');
?>

<section class="container beerfeed-container">

    <div class="bf-hero">
        <div class="bf-hero-icon">🍻</div>
        <h1 class="bf-hero-title">BeerFeed</h1>
        <p class="subtitle">O seu sommelier de cervejas pessoal.</p>
        <p class="bf-hero-desc">
            Não sabe qual cerveja escolher? Com tantas opções artesanais incríveis, 
            entendemos a dificuldade. O BeerFeed foi criado para isso!
        </p>
        <div style="text-align:center;margin-top:2rem;">
        <a 
            href="/beerFeed/formulario"
            style="
                background:#f5b700;
                color:#2e1f1c;
                border:none;
                padding:0.75rem 1.5rem;
                font-weight:600;
                border-radius:8px;
                cursor:pointer;
                text-decoration:none;
            "
        data-show-loader>
            Descobrir Minha Cerveja
        </a>
    </div>
    </div>

    <div class="bf-how-it-works">
        <h2>Como Funciona?</h2>
        <div class="steps-container">
            
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Responda</h3>
                <p>Você nos conta suas preferências em um quiz rápido e divertido. É sobre o que você gosta!</p>
            </div>
            
            <div class="step-card">
                <div class="step-number">2</div>
                <h3>Analisamos</h3>
                <p>Nossa API C# cruza suas respostas com as características de centenas de cervejas em nosso banco de dados.</p>
            </div>
            
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Descubra</h3>
                <p>Você recebe uma recomendação personalizada, com foto e link, da cerveja que tem mais a ver com você.</p>
            </div>
            
        </div>
    </div>

</section>