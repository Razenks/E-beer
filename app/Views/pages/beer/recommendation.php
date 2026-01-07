<?php
// Usar o Assets para incluir o CSS (se você tiver um CSS de card)
use App\Core\Assets;
Assets::addStyle('/assets/css/beers.css'); // Reutilizando o CSS de cervejas
?>

<section class="result-section" style="max-width:800px;margin:auto;padding:2rem;">
    <h1 style="text-align:center;margin-bottom:1.5rem;">Sua Recomendação 🍻</h1>

    <?php if (empty($recommendation) || empty($recommendation['categories'])): ?>
        <div style="background:#ffe5e5;color:#900;padding:1rem;border-radius:8px;margin-bottom:1rem;">
            Não foi possível gerar uma recomendação.
        </div>
    <?php else: ?>
        <?php foreach ($recommendation['categories'] as $category): ?>
            <div class="category-block" style="margin-bottom:2rem;">
                <h2 style="margin-top:0;margin-bottom:1rem;color:#333;">
                    Recomendações para <?= htmlspecialchars($category['name']) ?>
                </h2>
                
                <?php if (empty($category['items'])): ?>
                    <p>Nenhuma recomendação encontrada para esta categoria.</p>
                <?php else: ?>
                    <div class="grid-cervejas" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                        
                        <?php foreach ($category['items'] as $beer): // $beer é um BeerSummaryViewModel ?>
                            <div class="cerv-card" style="border: 1px solid #ddd; border-radius: 12px; text-align: center; padding-bottom: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); overflow: hidden;">
                                
                                <img src="<?= htmlspecialchars($beer->imgPath ?? '/assets/img/default.png') ?>" 
                                     alt="<?= htmlspecialchars($beer->name) ?>" 
                                     style="width: 100%; height: 150px; object-fit: contain; background-color: #f9f9f9; margin-bottom: 1rem;">
                                
                                <h4 style="margin: 0.5rem 0; color: #2e1f1c;">
                                    <?= htmlspecialchars($beer->name) ?>
                                </h4>
                                
                                <a href="/cerveja/<?= urlencode($beer->id) ?>" 
                                   class="btn-small"
                                   style="
                                      display: inline-block;
                                      background: #333;
                                      color: white;
                                      padding: 0.5rem 1rem;
                                      border-radius: 5px;
                                      text-decoration: none;
                                      font-size: 0.9rem;
                                      margin-top: 0.5rem;
                                   ">
                                    Ver Detalhes
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div style="text-align:center;margin-top:2rem;">
        <a 
            href="/beerFeed"
            style="
                background:#f5b700;
                color:#2e1f1c;
                border:none;
                padding:0.75rem 1.5rem;
                font-weight:600;
                border-radius:8px;
                cursor:pointer;
                text-decoration:none;
            "
        >
            Nova Recomendação
        </a>
    </div>
</section>