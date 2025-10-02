<?php
use App\Core\Assets;

Assets::addStyle('/assets/css/home.css');
Assets::addStyle('/assets/css/acessibilidade.css');
Assets::addScript('/assets/js/acessibilidade.js');
?>
<!-- <head>
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
</head> -->

<!-- Hero -->
<section class="hero">
  <h2>Encontrar sua cerveja perfeita nunca foi tão fácil</h2>
  <p>Responda ao BeerFeed e receba recomendações personalizadas de cervejas artesanais.</p>
  <a href="beerfeed.html" class="btn">Começar BeerFeed</a>
</section>

<!-- Produtos -->
<section class="produtos container">
  <h3>Produtos em destaque</h3>
  <div class="carousel-wrapper">
    <button class="carousel-btn left" onclick="scrollCarousel(-1)">&#10094;</button>
    <div class="carousel" id="carousel">
      <div class="prod-card"><img src="/assets/apa.png" alt="APA"><h4>APA</h4><a href="cerveja.html" class="btn-small">Ver Detalhes</a></div>
      <div class="prod-card"><img src="/assets/american_premium.png" alt="American Premium"><h4>American Premium</h4><a href="cerveja.html" class="btn-small">Ver Detalhes</a></div>
      <div class="prod-card"><img src="/assets/weiss.png" alt="Weiss"><h4>Weiss</h4><a href="cerveja.html" class="btn-small">Ver Detalhes</a></div>
      <div class="prod-card"><img src="/assets/blond_ale.png" alt="Blond Ale"><h4>Blond Ale</h4><a href="cerveja.html" class="btn-small">Ver Detalhes</a></div>
      <div class="prod-card"><img src="/assets/witbier.png" alt="IPA"><h4>IPA</h4><a href="cerveja.html" class="btn-small">Ver Detalhes</a></div>
      <div class="prod-card"><img src="/assets/stout.png" alt="Stout"><h4>Stout</h4><a href="cerveja.html" class="btn-small">Ver Detalhes</a></div>
      <div class="prod-card"><img src="/assets/red_ale.png" alt="Red Ale"><h4>Red Ale</h4><a href="cerveja.html" class="btn-small">Ver Detalhes</a></div>
    </div>
    <button class="carousel-btn right" onclick="scrollCarousel(1)">&#10095;</button>
  </div>
</section>

<!-- Como funciona -->
<section class="como-funciona container">
  <h3>Como funciona o e-Beer?</h3>
  <p>Responda poucas perguntas no BeerFeed e receba recomendações que combinam com seu paladar — rápido e sem complicação.</p>
</section>