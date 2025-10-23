<?php

use App\Core\Assets;

Assets::addStyle('/assets/css/beer.css');
?>

<!-- Conteúdo principal -->
<section class="container cerveja-detalhe">
    <div class="cerveja-card">
        <?php
            if (empty($beer)) {
                echo '<h4 id="empty-beer">Nenhuma cerveja encontrada.</h4>';
                return;
            }
            echo '<div class="cerveja-imagem">';
                echo '<img src="' . $beer->imgPath . '" alt="' . htmlspecialchars($beer->name) . '">';
            echo '</div>';
            echo '<div class="cerveja-info">';
                echo '<h2>' . htmlspecialchars($beer->name) . '</h2>';
                echo '<p class"descricao">' . htmlspecialchars($beer->description) . '</p>';
                echo '<ul class="caracteristicas">';
                    foreach ($beer->characteristics as $characteristic) {
                        echo "<li><strong>{$characteristic->characteristicName}:</strong> {$characteristic->option}</li>";
                    }
                echo '</ul>';
                echo '<a href="/cervejas" class="btn">Voltar</a>';
            echo '</div>';
        ?>
    </div>
</section>