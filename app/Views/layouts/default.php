<?php use App\Core\Assets; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'E-BEER'; ?></title>
    <link rel="stylesheet" href="/assets/css/layout_default.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/acessibilidade.css">
    <link rel="stylesheet" href="/assets/css/all.css">
    <script src="/assets/js/all.js"></script>
    <script src="/assets/js/acessibilidade.js"></script>

    <?php Assets::renderStyles(); Assets::renderScripts(); ?>
</head>
<body>
    <?php require_once __DIR__ . '/../components/accessibility.php'; ?>
    <?php require_once __DIR__ . '/../components/header.php'; ?>

    <?php echo $content; ?>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>

</body>
</html>