<?php
session_start(); // Inicia a sessão PHP para controlar as variáveis de sessão

// Verifica se o usuário está logado (se há dados na sessão)
if (empty($_SESSION)) {
    // Se a sessão estiver vazia (usuário não está autenticado), redireciona para a página de login com uma mensagem de erro
    header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
    // Outra redireção para a página inicial (pode ser redundante, pois a linha anterior já faz o redirecionamento)
    header("Location: index.php");
}

require_once '../config/conectaBD.php'; // Conexão com o banco de dados

$sql_usuario = "SELECT u.nome, u.email, u.senha, u.sobrenome, u.cpf, u.telefone, ft.img_foto_usuario
                FROM usuario AS u
                INNER JOIN 
                    foto_usuario AS ft ON u.id_foto_usuario = ft.id_foto_usuario
                WHERE cpf = :cpf";

try {
    $stmt_usuario = $conexao->prepare($sql_usuario);
    $stmt_usuario->bindParam(':cpf', $_SESSION['cpf']);
    $stmt_usuario->execute();
    $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo 'Erro' . $e->getMessage();
}


$cervejaId = $_GET['id_cerveja']; // Ou a maneira como você obtém o ID

$sql = "
    SELECT c.*, 
           co.desc_cor, 
           a.desc_amargor, 
           ta.desc_teor, 
           cc.desc_corpo, 
           ar.desc_aroma, 
           sp.desc_sabor, 
           car.desc_carbona, 
           mf.desc_mouthfeel,
           img.img_cerveja
    FROM cerveja c
    LEFT JOIN cor co ON c.id_cor = co.id_cor
    LEFT JOIN amargor a ON c.id_amargor = a.id_amargor
    LEFT JOIN teor_alcoolico ta ON c.id_teor = ta.id_teor
    LEFT JOIN corpo_cerveja cc ON c.id_corpo = cc.id_corpo
    LEFT JOIN aroma ar ON c.id_aroma = ar.id_aroma
    LEFT JOIN sabor_principal sp ON c.id_sabor = sp.id_sabor
    LEFT JOIN carbonatacao car ON c.id_carbonatacao = car.id_carbonatacao
    LEFT JOIN mouthfeel mf ON c.id_mouthfeel = mf.id_mouthfeel
    LEFT JOIN img_cerveja img ON c.id_img_cerveja = img.id_img_cerveja
    WHERE c.id_cerveja = :id_cerveja
";

$stmt = $conexao->prepare($sql);
$stmt->execute([':id_cerveja' => $cervejaId]); // supondo que $idCerveja seja o ID da cerveja que você está editando
$cerveja = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->bindParam(':id_cerveja', $cervejaId, PDO::PARAM_INT);
$stmt->execute();
// Verifique se a cerveja foi encontrada
if (!$cerveja) {
    echo "Cerveja não encontrada!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalhes da Cerveja - e-Beer</title>
  <link rel="stylesheet" href="assets/css/global.css">
  <link rel="stylesheet" href="assets/css/cerveja.css">
</head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="brand">
      <img src="/assets/logo_ebeer_2.png" alt="e-Beer Logo">
    </div>
    <nav class="nav">
      <a href="home.php">Home</a>
      <a href="products.php">Produtos</a>
      <a href="beer_test.php">BeerFeed</a>
      <a href="perfil.php">Perfil</a>
    </nav>
  </header>

  <!-- Conteúdo principal -->
  <main class="container produto-detalhe">
    <div class="produto-card">

    <?php
      echo '<div class="produto-imagem">';
      echo  '<img src="' . $cerveja['img_cerveja'] . '" alt="' . $cerveja['nome'] . '">';
      echo  '</div>';
      echo  '<div class="produto-info">';
      echo  '<h2>' . $cerveja['nome'] .'</h2>';
      echo  '<p class="descricao">' . $cerveja['descricao'] . '</p>';
        
      echo  '<ul class="caracteristicas">';
      echo   '<li><strong>Teor alcoólico:</strong>' . $cerveja['desc_teor'] . '</li>';
      echo   '<li><strong>Sabor:</strong> ' . $cerveja['desc_sabor'] . '</li>';
      echo   '<li><strong>Amargor:</strong>' . $cerveja['desc_amargor'] . '</li>';
      echo   '<li><strong>Cor:</strong>' . $cerveja['desc_cor'] . '</li>';
      echo   '<li><strong>Corpo:</strong>' . $cerveja['desc_corpo'] .'</li>';
      echo   '<li><strong>Aroma:</strong>' . $cerveja['desc_aroma'] .'</li>';
      echo   '<li><strong>Carbonatação:</strong>' . $cerveja['desc_carbona'] .'</li>';
      echo  '</ul>';

      echo   '<a href="/html/products.php" class="btn">Voltar para Produtos</a>';
      echo '</div>';
      ?>
      
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 e-Beer</p>
  </footer>
</body>
</html>
