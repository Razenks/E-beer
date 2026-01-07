<?php use App\Core\Assets; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'E-BEER - Acesso'; ?></title>
    <link rel="stylesheet" href="/assets/css/layout_auth.css">
    <link rel="stylesheet" href="/assets/css/all.css">
    <link rel="stylesheet" href="/assets/css/toast.css">

    <?php Assets::renderStyles(); ?>
</head>
<body class="auth-body">

    <div class="auth-container">
        <?php echo $content; ?>
    </div>

    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/acessibilidade.js"></script>
    
    <script src="/assets/js/toast.js"></script>
    
    <?php Assets::renderScripts(); ?>

    <?php
        // Prepara a mensagem (seja de erro, sucesso, etc.)
        $flashMessage = null;
        if (isset($error)) {
            $flashMessage = ['type' => 'error', 'message' => $error];
        } elseif (isset($success)) { // Vamos adicionar suporte a sucesso também
            $flashMessage = ['type' => 'success', 'message' => $success];
        } elseif (isset($warning)) {
            $flashMessage = ['type' => 'warning', 'message' => $warning];
        } elseif (isset($info)) {
            $flashMessage = ['type' => 'info', 'message' => $info];
        }

        // Se uma mensagem foi definida, chama nossa função JS
        if ($flashMessage):
    ?>
        <script>
            // Garante que o DOM esteja carregado antes de chamar o toast
            document.addEventListener('DOMContentLoaded', function() {
                showToast(
                    <?= json_encode($flashMessage['message']) ?>,
                    <?= json_encode($flashMessage['type']) ?>
                );
            });
        </script>
    <?php endif; ?>
</body>
</html>