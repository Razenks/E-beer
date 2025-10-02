<?php use App\Core\Assets; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'E-BEER - Acesso'; ?></title>
    <link rel="stylesheet" href="/assets/css/layout_auth.css">

    <?php Assets::renderStyles(); Assets::renderScripts(); ?>
</head>
<body class="auth-body">

    <div class="auth-container">
        <?php echo $content; ?>
    </div>

</body>
</html>