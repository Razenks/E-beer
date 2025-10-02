<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - e-Beer</title>
  <link rel="stylesheet" href="../../../public/assets/css/global.css">
  <link rel="stylesheet" href="../../../public/assets/css/admin.css">
</head>

<body>
  <!-- Header -->
  <header class="header">
    <div class="brand">
      <img src="../../../public/assets/img/logo_ebeer_2.png" alt="e-Beer Logo">
    </div>
    <nav class="nav">
      <a href="./home.php" class="active">Home</a>
      <a href="../pages/register_beer.php">Cadastrar Cerveja</a>
      <a href="../pages/manage_users.php">Gerenciar Usuários</a>
    </nav>
    <div class="user-info">
      <span><?php echo $_SESSION['nome']; ?></span>
    </div>
  </header>

  <!-- Conteúdo principal -->
  <main class="container admin-container">
    <h2>Produtos Cadastrados</h2>
    <p class="subtitle">Gerencie os produtos disponíveis no catálogo</p>

    <div class="success-container">
      <?php
      if (!empty($msgSucessoUpdateBeer)) {
        echo '<p class="success-msg">' . htmlspecialchars($msgSucessoUpdateBeer) . '</p>';
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

    <div class="grid-admin-produtos">
      <!-- Linha 1 -->

      <?php
      if (!empty($cervejas)) {
        foreach ($cervejas as $cerveja) {
          echo '<div class="prod-card">';
          echo   '<img src="' . $cerveja['img_cerveja'] . '" alt="' . $cerveja['nome'] . '">';
          echo   '<h4>' . $cerveja['nome'] . '</h4>';
          echo   '<div class="acoes">';
          echo     '<button "edit_beer.php?id_cerveja=' . $cerveja['id_cerveja'] . '" class="btn-small edit">Editar</button>';
          echo     '<button class="btn-small delete">Excluir</button>';
          echo   '</div>';
          echo '</div>';
        }
      }
      ?>

    </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 e-Beer</p>
  </footer>
</body>

</html>