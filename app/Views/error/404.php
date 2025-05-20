<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-beer</title>
</head>
<!---->
<body style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
    <h1>Página Não Encontrada</h1>
    <?php
        if($route)
        {
            echo "<p>Não foi possível localizar a página {$route}.</p>";
        }
    ?>
</body>
</html>