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

    <?php Assets::renderStyles(); Assets::renderScripts(); ?>
</head>
<body>
    
    <?php require_once __DIR__ . '/../components/header.php'; ?>

    <main class="container">
        <?php echo $content; ?>
    </main>

    <?php require_once __DIR__ . '/../components/footer.php'; ?>

</body>
</html>