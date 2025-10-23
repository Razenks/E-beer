<?php

use App\Core\Assets;

Assets::addStyle('/assets/css/home_admin.css');
?>

<!-- Conteúdo principal -->
<section class="container admin-container">
    <h2>Produtos Cadastrados</h2>
    <p class="subtitle">Gerencie os produtos disponíveis no catálogo</p>

    <div class="success-container">
        <?php
        if (!empty($msgSucessoUpdateBeer)) {
            echo '<p class="success-msg">' . htmlspecialchars($msgSucessoUpdateBeer) . '</p>';
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

    <?php 
        if (empty($registeredBeers)) { 
            echo '<h4>Nenhuma cerveja cadastrada.</h4>';
            return;
        } else {
            echo '<div class="grid-admin-produtos">';
            foreach ($registeredBeers as $registeredBeer) {
                echo '<div class="prod-card">';
                echo   '<img src="' . $registeredBeer['img_cerveja'] . '" alt="' . $registeredBeer['nome'] . '">';
                echo   '<h4>' . $registeredBeer['nome'] . '</h4>';
                echo   '<div class="acoes">';
                echo     '<button "edit_beer.php?id_cerveja=' . $registeredBeer['id_cerveja'] . '" class="btn-small edit">Editar</button>';
                echo     '<button class="btn-small delete">Excluir</button>';
                echo   '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
    ?>
</section>