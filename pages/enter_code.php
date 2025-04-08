<?php
session_start();
if (!isset($_SESSION['email'], $_SESSION['code'], $_SESSION['tipo_usuario'])) {
    header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
   exit();
}
// Verifica se há mensagem de sucesso ou erro
$msgSucessoCode = isset($_GET['msgSucesso']) ? $_GET['msgSucesso'] : '';
$msgErroCode = isset($_GET['msgErro']) ? $_GET['msgErro'] : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Codigo</title>
    <link rel="stylesheet" href="../css/enter_code.css">
    <link rel="stylesheet" href="../css/all.css">
    <script src="../js/enter_code.js"></script>
</head>
<!---->
<body>
    <header id="imagem-top">
        <img src="../assets/logo_ebeer.png" alt="">
    </header>
    <main>
        <h1>CODIGO</h1>

        <div class="success-container">
            <?php
            if (!empty($msgSucessoCode)) {
                echo '<p class="success-msg">' . htmlspecialchars($msgSucessoCode) . '</p>';
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

        <form action="../config/verify_code.php" method="post" id="form-enter-code">
            <div id="code-box">
                <input type="text" maxlength="6" placeholder="" id="codigo" name="codigo" required>
            </div>
            <button type="submit" id="submit-btn">Enviar</button>
        </form>
    </main>
    <script>
      const inputCode = document.getElementById('codigo');

      inputCode.addEventListener('input', function () {
        // Remove tudo que não for número
        this.value = this.value.replace(/\D/g, '');

        // Garante que não passe de 6 dígitos (extra, já que tem maxlength no HTML)
        if (this.value.length > 6) {
          this.value = this.value.slice(0, 6);
        }
      });
    </script>
</body>
</html>