<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>e-Beer — Página Inicial</title>
  <link rel="stylesheet" href="assets/css/global.css">
</head>

<body>
  <!-- Header -->
  <header class="header">
    <div class="brand">
      <img src="/assets/logo_ebeer_2.png" alt="e-Beer Logo">
    </div>
    <nav class="nav">
      <a href="home.php" class="active">Home</a>
      <a href="../pages/products.php">Produtos</a>
      <a href="../pages/beer_test.php">BeerFeed</a>
      <a href="../pages/perfil.php">Perfil</a>
      <a href="../login/index.php">Sair</a>
    </nav>
  </header>

  <!-- Hero -->
  <section class="hero">
    <h2>Encontrar sua cerveja perfeita nunca foi tão fácil</h2>
    <p>Responda ao BeerFeed e receba recomendações personalizadas de cervejas artesanais.</p>
    <a href="../pages/beer_test.php" class="btn">Começar BeerFeed</a>
  </section>

  <!-- Produtos -->
  <section class="produtos container">
    <h3>Produtos em destaque</h3>
    <div class="carousel-wrapper">
      <button class="carousel-btn left" onclick="scrollCarousel(-1)">&#10094;</button>
      <div class="carousel" id="carousel">
        <?php
        if (!empty($cervejas)) {
          foreach ($cervejas as $cerveja) {
            echo '<div class="prod-card">';
            echo    '<img src="' . $cerveja['img_cerveja'] . '" alt="' . $cerveja['nome'] . '">';
            echo    '<h4>' . $cerveja['nome'] . '</h4>';
            echo    '<a href="beer_page.php?id_cerveja=' . $cerveja['id_cerveja'] . '" class="btn-small">Ver Detalhes</a>';
            echo '</div>';
          }
        } else {
          echo '<p>Nenhuma Cerveja Cadastrada.<p>';
        }
        ?>
      </div>
      <button class="carousel-btn right" onclick="scrollCarousel(1)">&#10095;</button>
    </div>
  </section>

  <!-- Como funciona -->
  <section class="como-funciona container">
    <h3>Como funciona o e-Beer?</h3>
    <p>Responda poucas perguntas no BeerFeed e receba recomendações que combinam com seu paladar — rápido e sem complicação.</p>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 e-Beer</p>
  </footer>
</body>

</html>