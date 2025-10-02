<?php
session_start(); // Inicia a sessão PHP para controlar as variáveis de sessão

require_once '../config/conectaBD.php'; // Conexão com o banco de dados

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 2) {
  header("Location: ../index.php?msgErro=Você precisa ser um administrador para acessar esta página.");
  session_destroy();
  exit();
}
// Verifica se o usuário está logado (se há dados na sessão)
if (empty($_SESSION)) {
  header("Location: index.php?msgErro= Você precisa se autenticar no sistema.");
}

// Captura possíveis mensagens de sucesso ou erro passadas via URL através do método GET.
$msgSucessoCadastro = isset($_GET['msgSucesso']) ? $_GET['msgSucesso'] : '';
$msgErroCadastro = isset($_GET['msgError']) ? $_GET['msgError'] : '';

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
// Aqui você deve ter uma query SQL para listar as cervejas
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
  <title>Editar Cerveja - Admin e-Beer</title>
  <link rel="stylesheet" href="../../../public/assets/css/global.css">
  <link rel="stylesheet" href="../../../public/assets/css/editar_cerveja.css">
</head>

<body>
  <!-- Header -->
  <header class="header">
    <div class="brand">
      <img src="../../../public/assets/img/logo_ebeer_2.png" alt="e-Beer Logo">
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
  <main class="container editar-container">
    <h2>Editar Cerveja</h2>
    <p class="subtitle">Atualize as informações da cerveja selecionada</p>

    <div class="editar-form-card">
      <form action="../config/atualiza_cerveja.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_cerveja" value="<?php echo $cervejaId ?>">
        <div class="form-group">
          <label for="nome">Nome da Cerveja</label>
          <input type="text" name="nome" id="nome" value="<?php echo $cerveja['nome']; ?>" required>
        </div>

        <div class="form-group">
          <label for="descricao">Descrição</label>
          <textarea name="descricao" id="descricao" required><?php echo $cerveja['descricao']; ?></textarea>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="teor">Teor Alcoólico (%)</label>
            <select name="teor" id="teor" required>
              <option value="" disabled selected></option>
              <option value="baixo" <?php echo ($cerveja['desc_teor'] == 'baixo') ? 'selected' : ''; ?>>Baixo
                (até 3,5%)</option>
              <option value="moderado" <?php echo ($cerveja['desc_teor'] == 'moderado') ? 'selected' : ''; ?>>
                Moderado (3,6% a 5,5%)</option>
              <option value="alto" <?php echo ($cerveja['desc_teor'] == 'alto') ? 'selected' : ''; ?>>Alto
                (5,6% a 7,5%)</option>
              <option value="muito alto" <?php echo ($cerveja['desc_teor'] == 'muito alto') ? 'selected' : ''; ?>>Muito alto (acima de 7,5%)</option>
            </select>
          </div>
          <div class="form-group">
            <label for="ibu">Amargor (IBU)</label>
            <select name="amargor" id="ibu" required>
              <option value="" disabled selected></option>
              <option value="leve" <?php echo ($cerveja['desc_amargor'] == 'leve') ? 'selected' : ''; ?>>Leve (0
                - 20
                IBU)</option>
              <option value="moderado" <?php echo ($cerveja['desc_amargor'] == 'moderado') ? 'selected' : ''; ?>>Moderado
                (21 - 40 IBU)</option>
              <option value="amargo" <?php echo ($cerveja['desc_amargor'] == 'amargo') ? 'selected' : ''; ?>>
                Amargo (41 -
                60 IBU)</option>
              <option value="muito amargo" <?php echo ($cerveja['desc_amargor'] == 'muito amargo') ? 'selected' : ''; ?>>
                Muito amargo (61 - 100+ IBU)</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="cor">Cor (EBC)</label>
            <select name="cor" id="cor" required>
              <option value="" disabled selected></option>
              <option value="clara" <?php echo ($cerveja['desc_cor'] == 'clara') ? 'selected' : ''; ?>>Clara
                (1-6 EBC)
              </option>
              <option value="dourada" <?php echo ($cerveja['desc_cor'] == 'dourada') ? 'selected' : ''; ?>>
                Dourada (7-12
                EBC)</option>
              <option value="âmbar" <?php echo ($cerveja['desc_cor'] == 'âmbar') ? 'selected' : ''; ?>>Âmbar
                (13-25 EBC)
              </option>
              <option value="cobre" <?php echo ($cerveja['desc_cor'] == 'cobre') ? 'selected' : ''; ?>>Cobre
                (26-39 EBC)
              </option>
              <option value="marrom" <?php echo ($cerveja['desc_cor'] == 'marrom') ? 'selected' : ''; ?>>Marrom
                (40-59
                EBC)</option>
              <option value="preta" <?php echo ($cerveja['desc_cor'] == 'preta') ? 'selected' : ''; ?>>Preta
                (60+ EBC)
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="corpo">Corpo</label>
            <select name="corpo" id="corpo" required>
              <option value="" disabled selected></option>
              <option value="leve" <?php echo ($cerveja['desc_corpo'] == 'leve') ? 'selected' : ''; ?>>Leve
              </option>
              <option value="médio" <?php echo ($cerveja['desc_corpo'] == 'médio') ? 'selected' : ''; ?>>médio
              </option>
              <option value="encorpado" <?php echo ($cerveja['desc_corpo'] == 'encorpado') ? 'selected' : ''; ?>>
                Encorpado</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="aroma">Aroma</label>
            <select name="sabor" id="aroma" required>
              <option value="" disabled selected></option>
              <option value="doce" <?php echo ($cerveja['desc_sabor'] == 'doce') ? 'selected' : ''; ?>>Doce
              </option>
              <option value="amargo" <?php echo ($cerveja['desc_sabor'] == 'amargo') ? 'selected' : ''; ?>>
                Amargo</option>
              <option value="ácido" <?php echo ($cerveja['desc_sabor'] == 'ácido') ? 'selected' : ''; ?>>Ácido
              </option>
              <option value="salgado" <?php echo ($cerveja['desc_sabor'] == 'salgado') ? 'selected' : ''; ?>>
                Salgado</option>
            </select>
          </div>

          <div class="form-group">
            <label for="carbonatacao">Carbonatação</label>
            <select name="carbonacao" id="carbonatacao" required>
              <option value="" disabled selected></option>
              <option value="baixa" <?php echo ($cerveja['desc_carbona'] == 'baixa') ? 'selected' : ''; ?>>Baixa
              </option>
              <option value="moderada" <?php echo ($cerveja['desc_carbona'] == 'moderada') ? 'selected' : ''; ?>>
                Moderada</option>
              <option value="alta" <?php echo ($cerveja['desc_carbona'] == 'alta') ? 'selected' : ''; ?>>Alta
              </option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="mouthfeel">Mouthfeel</label>
            <select name="mouthfeel" id="mouthfeel" required>
              <option value="" disabled selected></option>
              <option value="suave" <?php echo ($cerveja['desc_mouthfeel'] == 'suave') ? 'selected' : ''; ?>>
                Suave
              </option>
              <option value="cremosidade" <?php echo ($cerveja['desc_mouthfeel'] == 'cremosidade') ? 'selected' : ''; ?>>
                Cremosidade</option>
              <option value="seco" <?php echo ($cerveja['desc_mouthfeel'] == 'seco') ? 'selected' : ''; ?>>Seco
              </option>
              <option value="efervescente" <?php echo ($cerveja['desc_mouthfeel'] == 'efervescente') ? 'selected' : ''; ?>>Efervescente</option>
              <option value="aveludado" <?php echo ($cerveja['desc_mouthfeel'] == 'aveludado') ? 'selected' : ''; ?>>
                Aveludado</option>
            </select>
          </div>
        </div>

        <!-- Exibição e edição da imagem -->
        <div class="form-group imagem-editar">
          <label>Imagem Atual</label>

          <div class="imagem-preview">
            <?php if (!empty($cerveja['img_cerveja'])): ?>
              <img src="../assets/<?php echo $cerveja['img_cerveja']; ?>" alt="Imagem da cerveja">
            <?php else: ?>
              <p>Nenhuma imagem cadastrada.</p>
            <?php endif; ?>
          </div>

          <input type="file" id="imagem" accept="image/*" name="img_cerveja">
          <small>Selecione uma nova imagem para atualizar</small>
        </div>

        <div class="botoes-acao">
          <button type="submit" class="btn-primary">Salvar Alterações</button>
          <a href="../home/homeAdmin.php" class="btn-cancelar">Cancelar</a>
        </div>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 e-Beer</p>
  </footer>
</body>

</html>