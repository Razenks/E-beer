<?php
session_start(); // Inicia a sessão PHP para controlar as variáveis de sessão

require '../config/conectaBD.php';

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 2) {
  // Redireciona para a página inicial com uma mensagem de erro
  header("Location: ../index.php?msgErro=Você precisa ser um administrador para acessar esta página.");
  session_destroy();
  exit();
}
// Verifica se o usuário está logado (se há dados na sessão)
if (empty($_SESSION)) {
  header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
}

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

// Captura possíveis mensagens de sucesso ou erro passadas via URL através do método GET.
// As variáveis são inicializadas como strings vazias se não houver mensagens.
$msgSucessoBeer = isset($_GET['msgSucessoBeer']) ? $_GET['msgSucessoBeer'] : '';
$msgErroCadastro = isset($_GET['msgError']) ? $_GET['msgError'] : '';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Cerveja - Admin e-Beer</title>
  <link rel="stylesheet" href="assets/css/global.css">
  <link rel="stylesheet" href="assets/css/cadastrar_cerveja.css">
</head>

<body>
  <!-- Header -->
  <header class="header">
    <div class="brand">
      <img src="/assets/logo_ebeer_2.png" alt="e-Beer Logo">
    </div>
    <nav class="nav">
      <a href="../home/homeAdmin.php" class="active">Home</a>
      <a href="./register_beer.php">Cadastrar Cerveja</a>
      <a href="./manage_users.php">Gerenciar Usuários</a>
    </nav>
    <div class="user-info">
      <span><?php echo $_SESSION['nome']; ?></span>
    </div>
  </header>

  <!-- Conteúdo principal -->
  <main>
    <div class="cadastrar-cerveja-container">
      <h2>Cadastrar Nova Cerveja</h2>
      <p>Preencha os dados abaixo para adicionar uma nova cerveja ao catálogo</p>

      <form action="../config/processa_cerveja.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="nome">Nome da Cerveja</label>
          <input type="text" id="nome" name="nome" placeholder="Ex: IPA Artesanal">
        </div>

        <div class="form-group">
          <label for="descricao">Descrição</label>
          <textarea id="descricao" name="descricao" placeholder="Breve descrição da cerveja..."></textarea>
        </div>

        <div class="form-group">
          <label for="teor">Teor Alcoólico (%)</label>
          <select name="teor" id="teor" required>
            <option value="" disabled selected></option>
            <option value="baixo">Baixo (até 3,5%)</option>
            <option value="moderado">Moderado (3,6% a 5,5%)</option>
            <option value="alto">Alto (5,6% a 7,5%)</option>
            <option value="muito alto">Muito alto (acima de 7,5%)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="">Como você descreveria o sabor principal da cerveja?</label>
          <select name="sabor" id="" required>
            <option value="" disabled selected></option>
            <option value="doce">Doce</option>
            <option value="amargo">Amargo</option>
            <option value="ácido">Ácido</option>
            <option value="salgado">Salgado</option>
          </select>
        </div>

        <div class="form-group">
          <label for="">Qual é a carbonatação da cerveja?</label>
          <select name="carbonacao" id="" required>
            <option value="" disabled selected></option>
            <option value="baixa">Baixa</option>
            <option value="moderada">Moderada</option>
            <option value="alta">Alta</option>
          </select>
        </div>

        <div class="form-group">
          <label for="">Como você descreveria a sensação na boca?(mouthfeel)?</label>
          <select name="mouthfeel" id="" required>
            <option value="" disabled selected></option>
            <option value="suave">Suave</option>
            <option value="cremosidade">Cremosidade</option>
            <option value="seco">Seco</option>
            <option value="efervescente">Efervescente</option>
            <option value="aveludado">Aveludado</option>
          </select>
        </div>

        <div class="form-group">
          <label for="amargor">Amargor (IBU)</label>
          <select name="amargor" id="amargor" required>
            <option value="" disabled selected></option>
            <option value="leve">Leve (0 - 20 IBU)</option>
            <option value="moderado">Moderado (21 - 40 IBU)</option>
            <option value="amargo">Amargo (41 - 60 IBU)</option>
            <option value="muito amargo">Muito amargo (61 - 100+ IBU)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="cor">Cor (EBC)</label>
          <select name="cor" id="cor" required>
            <option value="" disabled selected></option>
            <option value="clara">Clara (1-6 EBC)</option>
            <option value="dourada">Dourada (7-12 EBC)</option>
            <option value="âmbar">Âmbar (13-25 EBC)</option>
            <option value="cobre">Cobre (26-39 EBC)</option>
            <option value="marrom">Marrom (40-59 EBC)</option>
            <option value="preta">Preta (60+ EBC)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="corpo">Corpo</label>
          <select name="corpo" id="corpo" required>
            <option value="" disabled selected></option>
            <option value="leve">Leve</option>
            <option value="médio">médio</option>
            <option value="encorpado">Encorpado</option>
          </select>
        </div>

        <div class="form-group">
          <label for="">Aroma</label>
          <select name="aroma" id="aroma" required>
            <option value="" disabled selected></option>
            <option value="frutado">Frutado (cítricos, frutas tropicais)</option>
            <option value="floral">Floral (flores, ervas)</option>
            <option value="especiarias">Especiarias (cravo, canela)</option>
            <option value="torrado">Torrado (chocolate, café)</option>
            <option value="caramelo">Caramelo (açúcar queimado, toffee)</option>
          </select>
        </div>

        <div class="form-group">
          <label for="imagem">Imagem da Cerveja</label>
          <input type="file" id="imagem" name="img_cerveja" required>
        </div>

        <button type="submit" class="btn-submit">Cadastrar</button>
      </form>
    </div>
  </main>


  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 e-Beer</p>
  </footer>
</body>

</html>