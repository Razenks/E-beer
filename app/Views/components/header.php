<header class="header">
  <div class="brand">
    <img src="/assets/img/logo_ebeer_2.png" alt="e-Beer Logo">
  </div>
  <nav class="nav">
    <a href="/api/get-home/<?= $user_type ?>" class="active">Home</a>
    <a href="/produtos">Produtos</a>
    <a href="/beerFeed">BeerFeed</a>
    <a href="/perfil/<?= $jwt ?>">Perfil</a>
    <a href="/login">Sair</a>
  </nav>
</header>