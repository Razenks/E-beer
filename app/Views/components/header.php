<header class="header">
  <div class="brand">
    <img src="/assets/img/logo_ebeer_2.png" alt="e-Beer Logo">
  </div>
  <nav class="nav">
    <a href="/login/obter-home/<?= $user_type ?>" class="active">Home</a>
    <a href="/cervejas">Cervejas</a>
    <a href="/beerFeed">BeerFeed</a>
    <a href="/perfil/<?= $jwt ?>">Perfil</a>
    <a href="/logout">Sair</a>
  </nav>
</header>