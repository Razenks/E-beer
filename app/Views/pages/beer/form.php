<?php
use App\Core\Assets;

Assets::addScript('/assets/js/page-loader.js');
// Novos arquivos para o wizard
Assets::addStyle('/assets/css/form-wizard.css');
Assets::addScript('/assets/js/form-wizard.js', ['defer']);
?>

<main class="form-section container">
    
    <?php if (empty($form) || empty($form['categories'])): ?>
        
        <div class="wizard-container empty-state">
            <h2>Ops!</h2>
            <p>Nenhum formulário de recomendação disponível no momento.</p>
            <a href="/beerFeed" class="btn btn-secondary">Voltar</a>
        </div>
        
    <?php else: ?>
        
        <div class="wizard-container">
            
            <div class="wizard-header">
                <h1 id="wizard-title">Encontre sua Cerveja</h1>
                <p>Responda as perguntas para a categoria: <strong id="category-title"></strong></p>
                <div class="progress-bar">
                    <div id="progress-bar-inner" class="progress-bar-inner"></div>
                </div>
            </div>

            <form method="POST" action="/beerFeed/recomendacao" id="wizard-form" data-show-loader>
                <input type="hidden" name="form_id" value="<?= htmlspecialchars($form['formId']) ?>">

                <div class="wizard-steps-container">
                    <?php
                    // Vamos "achatar" todas as perguntas em uma lista de passos
                    foreach ($form['categories'] as $category):
                        foreach ($category['questions'] as $question):
                    ?>
                        <div class="wizard-step" data-category="<?= htmlspecialchars($category['name']) ?>">
                            
                            <label class="wizard-question-label">
                                <?= htmlspecialchars($question['question']) ?>
                            </label>

                            <?php if (!empty($question['options'])): ?>
                                <div class="options-group">
                                    <?php foreach ($question['options'] as $option): ?>
                                        <?php 
                                            $categoryName = htmlspecialchars($category['name']);
                                            $characteristicName = htmlspecialchars($question['characteristic']);
                                            $inputName = "answers[$categoryName][$characteristicName]";
                                            $inputId = htmlspecialchars($category['name'] . '_' . $question['characteristic'] . '_' . $option);
                                        ?>
                                        
                                        <input 
                                            type="radio"
                                            id="<?= $inputId ?>"
                                            class="option-radio"
                                            name="<?= $inputName ?>"
                                            value="<?= htmlspecialchars($option) ?>"
                                            required
                                        >
                                        <label for="<?= $inputId ?>" class="option-label">
                                            <?= htmlspecialchars($option) ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php 
                        endforeach; 
                    endforeach; 
                    ?>
                </div>

                <div class="wizard-navigation">
                    <button type="button" id="prev-btn" class="btn btn-secondary">Voltar</button>
                    
                    <div class="nav-right">
                        <button type="button" id="next-btn" class="btn btn-primary">Avançar</button>
                        <button type="submit" id="submit-btn" class="btn btn-primary" style="display:none;">Enviar Respostas</button>
                    </div>
                </div>

            </form>
        </div>
    <?php endif; ?>
</main>