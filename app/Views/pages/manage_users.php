<?php
session_start();

require '../config/conectaBD.php';

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 2) {
  // Redireciona para a página inicial com uma mensagem de erro
  header("Location: ../index.php?msgErro=Você precisa ser um administrador para acessar esta página.");
  session_destroy();
  exit();
}


try {
  $sql = "SELECT 
            cpf, nome, sobrenome, email, data_cadastro, tipo_usuario 
        FROM 
            usuario";

  $stmt = $conexao->prepare($sql);
  $stmt->execute();
  $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $sql_usuario = "SELECT u.nome, u.email, u.senha, u.sobrenome, u.cpf, u.telefone, ft.img_foto_usuario
                    FROM usuario AS u
                    INNER JOIN 
                    foto_usuario AS ft ON u.id_foto_usuario = ft.id_foto_usuario
                    WHERE cpf = :cpf";

  $stmt_usuario = $conexao->prepare($sql_usuario);
  $stmt_usuario->bindParam(':cpf', $_SESSION['cpf']);
  $stmt_usuario->execute();
  $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo 'Erro ao conectar com o banco!';
}

$msgSucessoUser = isset($_GET['msgSucessoUser']) ? $_GET['msgSucessoUser'] : '';
$msgErroCadastro = isset($_GET['msgErro']) ? $_GET['msgErro'] : '';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Usuários - e-Beer</title>
  <link rel="stylesheet" href="assets/css/global.css">
  <link rel="stylesheet" href="assets/css/gerenciar_usuarios.css">
  <script src="../js/all.js"></script>
  <script src="../js/acessibilidade.js"></script>
  <script src="../js/main-adm.js"></script>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget('https://vlibras.gov.br/app');
  </script>
</head>

<body>
  <!-- Header Admin -->
  <header class="header">
    <div class="brand">
      <img src="/assets/logo_ebeer_2.png" alt="e-Beer Logo">
    </div>
    <nav class="nav">
      <a href="../home/home.php" class="active">Home</a>
      <a href="./register_beer.php">Cadastrar Cerveja</a>
      <a href="./manage_users.php">Gerenciar Usuários</a>
    </nav>
    <div class="user-info">
      <span><?php echo $_SESSION['nome']; ?></span>
    </div>
  </header>


  <!-- Conteúdo Principal -->
  <main class="usuarios-container">
    <h2>Gerenciamento de Usuários</h2>
    <p class="descricao">Aqui você pode visualizar, editar e remover usuários cadastrados no sistema.</p>

    <div class="success-container">
      <?php
      if (!empty($msgSucessoUser)) {
        echo '<p class="success-msg">' . htmlspecialchars($msgSucessoUser) . '</p>';
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

    <div class="usuarios-card">
      <table class="usuarios-tabela">
        <thead>
          <tr>
            <th>CPF</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Cadastro</th>
            <th>Tipo</th>
            <th>Ações</th>
          </tr>
        </thead>

        <?php
        if (!empty($usuarios)) {
          foreach ($usuarios as $usuarios) {
            echo '<tbody>';
            echo '<tr>';
            echo '<td>' . $usuarios['cpf'] . '</td>';
            echo '<td>' . $usuarios['nome'] . ' ' . $usuarios['sobrenome'] . '</td>';
            echo '<td>' . $usuarios['email'] . '</td>';
            echo '<td>' . $usuarios['data_cadastro'] . '</td>';
            echo '<td>' . $usuarios['tipo_usuario'] . '</td>';
            echo '<td>';
            echo '<a href="./tela_user.php?cpf=' . $usuarios['cpf'] . '" class="btn-edit">Editar';
            echo '<button class="btn-delete">Remover</button>';
            echo '</td>';
            echo '</tr>';
            echo '</tbody>';
          }
        }
        ?>
      </table>
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