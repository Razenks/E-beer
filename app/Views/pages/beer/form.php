<?php

?>

<section class="form-section" style="max-width:800px;margin:auto;padding:2rem;">
    <h1 style="text-align:center;margin-bottom:1.5rem;">Recomendações de Cervejas 🍺</h1>

    <?php if (!empty($error)): ?>
        <div style="background:#ffe5e5;color:#900;padding:1rem;border-radius:8px;margin-bottom:1rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($form) || empty($form['categories'])): ?>
        <p style="text-align:center;color:#666;">Nenhum formulário disponível no momento.</p>
    <?php else: ?>
        <form method="POST" action="/recommendation/submit" style="display:flex;flex-direction:column;gap:2rem;">
            <input type="hidden" name="form_id" value="<?= htmlspecialchars($form['formId']) ?>">

            <?php foreach ($form['categories'] as $category): ?>
                <div class="category-block" style="border:1px solid #ddd;border-radius:12px;padding:1.5rem;">
                    <h2 style="margin-top:0;margin-bottom:1rem;color:#333;">
                        <?= htmlspecialchars($category['name']) ?>
                    </h2>

                    <?php foreach ($category['questions'] as $question): ?>
                        <div class="question-block" style="margin-bottom:1.5rem;">
                            <label style="font-weight:600;display:block;margin-bottom:0.5rem;">
                                <?= htmlspecialchars($question['question']) ?>
                            </label>

                            <?php if (!empty($question['options'])): ?>
                                <div class="options-group" style="display:flex;flex-wrap:wrap;gap:0.75rem;">
                                    <?php foreach ($question['options'] as $option): ?>
                                        <?php 
                                            $inputName = 'answers[' . htmlspecialchars($question['characteristic']) . ']';
                                            $inputId = htmlspecialchars($question['characteristic'] . '_' . $option);
                                        ?>
                                        <label for="<?= $inputId ?>" style="cursor:pointer;display:flex;align-items:center;gap:0.4rem;">
                                            <input 
                                                type="radio"
                                                id="<?= $inputId ?>"
                                                name="<?= $inputName ?>"
                                                value="<?= htmlspecialchars($option) ?>"
                                                required
                                            >
                                            <?= htmlspecialchars($option) ?>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <div style="text-align:center;margin-top:1rem;">
                <button 
                    type="submit"
                    style="
                        background:#f5b700;
                        color:#2e1f1c;
                        border:none;
                        padding:0.75rem 1.5rem;
                        font-weight:600;
                        border-radius:8px;
                        cursor:pointer;
                        transition:background 0.2s;
                    "
                    onmouseover="this.style.background='#e0a600'"
                    onmouseout="this.style.background='#f5b700'"
                >
                    Enviar Respostas
                </button>
            </div>
        </form>
    <?php endif; ?>
</section>
