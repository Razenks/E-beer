<?php

use App\Core\Assets;

Assets::addStyle('/assets/css/beers.css');
Assets::addScript('/assets/js/page-loader.js');
?>

<!-- Conteúdo principal -->
<section class="container cervejas-lista">
    <h2>Nossas Cervejas</h2>
    <p class="subtitle">Explore a variedade de cervejas artesanais disponíveis</p>

    <?php 
        if (empty($beers)) {
            echo '<h4 id="empty-beers">Nenhuma cerveja encontrada.</h4>';
            return;
        }

        echo '<div class="grid-cervejas">';
        foreach ($beers as $beer) {
            echo '<div class="cerv-card">';
                // Aqui depende de como você salva as imagens no banco
                // Supondo que tenha um caminho base para imagens:

                echo '<img src="' . $beer->imgPath . '" alt="' . htmlspecialchars($beer->name) . '">';
                echo "<h4>" . htmlspecialchars($beer->name) . "</h4>";
                echo "<p>" . htmlspecialchars($beer->description) . "</p>";
                echo '<a href="/cerveja/' . urlencode($beer->id) . '" class="btn-small">Ver Detalhes</a>';
            echo '</div>';
        }
        echo '</div>';
    ?>
</section>
