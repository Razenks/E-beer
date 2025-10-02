<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil - e-Beer</title>
  <link rel="stylesheet" href="../../../public/assets/css/global.css">
  <link rel="stylesheet" href="../../../public/assets/css/perfil.css">
</head>
<body>
  <!-- Header fixo -->
  <header class="header">
    <div class="brand">
      <img src="../../../public/assets/img/logo_ebeer_2.png" alt="e-Beer Logo">
    </div>
    <nav class="nav">
      <a href="../home/home.php" class="active">Home</a>
      <a href="products.php">Produtos</a>
      <a href="beer_test.php">BeerFeed</a>
      <a href="perfil.php">Perfil</a>
      <a href="/login">Sair</a>
    </nav>
  </header>


  <!-- Conteúdo principal -->
  <main class="perfil-container">
    <div class="perfil-card">
      <h2>Meu Perfil</h2>
      <form action="../config/alterar_dados.php" method="POST" id="change-data-inputs" enctype="multipart/form-data">
        <div class="form-row">
          <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" id="nome" value="<?php echo $_SESSION['nome'] ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="sobrenome">Sobrenome</label>
            <input type="text" id="sobrenome" value="<?php echo $_SESSION['sobrenome'] ?>" class="form-control" required>
          </div>
        </div>

        <div class="form-group">
          <label for="email">E-mail</label>
          <input type="email" id="email" value="<?php echo $_SESSION['email'] ?>" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="senha">Nova senha</label>
          <input type="password" id="senha" class="form-control" placeholder="Digite nova senha">
        </div>

        <div class="form-group">
          <label for="confirmar">Confirmar nova senha</label>
          <input type="password" id="confirmar" class="form-control" placeholder="Confirme a nova senha">
        </div>

        <button type="submit" class="btn-primary">Salvar alterações</button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 e-Beer</p>
    </div>
  </footer>
</body>
</html>


