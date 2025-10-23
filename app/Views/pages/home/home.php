<?php
use App\Core\Assets;

Assets::addStyle('/assets/css/home.css');
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
<section class="hero container">
  <h2>Encontrar sua cerveja perfeita nunca foi tão fácil</h2>
  <p>Responda ao BeerFeed e receba recomendações personalizadas de cervejas artesanais.</p>
  <a href="/beerFeed" class="btn">Começar BeerFeed</a>
</section>

<!-- Cervejas -->
<section class="cervejas container">
  <h3>Cervejas em destaque</h3>
  <?php 
    if (empty($featuredBeers)) { 
        echo '<h4 id="empty-beers">Nenhuma cerveja encontrada.</h4>';
        return;
    } else {
      echo '  <div class="carousel-wrapper">';
      echo '    <button class="carousel-btn left" onclick="scrollCarousel(-1)">&#10094;</button>';
      echo '    <div class="carousel" id="carousel">';

      foreach ($featuredBeers as $featuredBeer) {
          echo '      <div class="cerv-card">';
          echo '        <img src="' . $featuredBeer->imgPath . '" alt="' . htmlspecialchars($featuredBeer->name) . '">';
          echo '        <h4>' . htmlspecialchars($featuredBeer->name) . '</h4>';
          echo '        <a href="/cerveja/' . urlencode($featuredBeer->id) . '" class="btn-small">Ver Detalhes</a>';
          echo '      </div>';
      }

      echo '    </div>';
      echo '    <button class="carousel-btn right" onclick="scrollCarousel(1)">&#10095;</button>';
      echo '  </div>';
    }
  ?>
</section>

<!-- Como funciona -->
<section class="como-funciona container">
  <h3>Como funciona o e-Beer?</h3>
  <p>Responda poucas perguntas no BeerFeed e receba recomendações que combinam com seu paladar — rápido e sem complicação.</p>
</section>