<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - e-Beer</title>
  <link rel="stylesheet" href="assets/css/global.css">
  <link rel="stylesheet" href="assets/css/cadastro.css">
  <script src="/assets/js/cadastro-novo.js"></script>
  <script src="/assets/js/all.js"></script>
  <!-- Script do reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
  <main class="cadastro-container">
    <div class="cadastro-card">
      <div class="logo-cadastro">
        <img src="/assets/logo_ebeer_2.png" alt="Logo e-Beer">
      </div>

      <h2>Cadastro</h2>

      <!-- Div para exibir mensagens de erro, se houver -->
      <div class="error-container">
        <?php
        if (isset($error)) {
          echo '<p class="error-msg">' . $error . '</p>';
        }
        ?>
      </div>


      <!-- Div para exibir mensagens de sucesso, se houver -->
      <div class="sucesso-container">
        <?php
        // Verifica se uma mensagem de sucesso foi passada via GET e exibe na tela.
        if (isset($success)) {
          echo '<p class="sucesso-msg">' . $success . '</p>';
        }
        ?>
      </div>

      <form action="/api/start-registration" method="post" id="form">
        <div class="form-row">
          <div class="form-group">
            <input type="text" placeholder="Nome" name="nome" required>
          </div>
          <div class="form-group">
            <input type="text" placeholder="Sobrenome" name="sobrenome" required>
          </div>
        </div>

        <div class="form-group">
          <input type="email" placeholder="E-mail" name="email" required>
        </div>

        <div class="form-group">
          <input type="text" placeholder="CPF" name="cpf" maxlength="14" required>
        </div>

        <div class="form-group">
          <input type="password" placeholder="Senha" required>
        </div>

        <div class="form-group">
          <input type="password" placeholder="Confirmar senha" required>
        </div>

        <div id="captcha-container">
          <div class="g-recaptcha" data-sitekey="6LfhFQ8rAAAAAEi55UaZDqBpP6rcQLMr3f3lQmT9"></div>
        </div>

        <button type="submit" class="btn-primary">Cadastrar</button>
      </form>

      <div class="cadastro-links">
        <a href="../login/index.php">Já tenho conta</a>
      </div>
    </div>
  </main>
</body>

</html>