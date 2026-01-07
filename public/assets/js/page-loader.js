/**
 * Este script adiciona um toast de "Carregando..."
 * a qualquer elemento com o atributo 'data-show-loader'.
 * * - Em <form>, escuta o evento 'submit'.
 * - Em <a> ou <button>, escuta o evento 'click'.
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // --- LÓGICA 1: Para Formulários ---
    const formsToTrack = document.querySelectorAll('form[data-show-loader]');
    formsToTrack.forEach(form => {
        form.addEventListener('submit', function() {
            // Mostra o toast
            showToast('Carregando...', 'loading', 0);
            
            // Desabilita o botão de submit
            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Aguarde...';
            }
        });
    });

    // --- LÓGICA 2: Para Links e Botões Avulsos ---
    // Seleciona links OU botões que tenham o atributo E NÃO sejam type="submit"
    // (pois o type="submit" já é pego pela lógica 1)
    const elementsToTrack = document.querySelectorAll(
        'a[data-show-loader], button[data-show-loader]:not([type="submit"])'
    );
    
    elementsToTrack.forEach(element => {
        element.addEventListener('click', function() {
            // Mostra o toast
            showToast('Carregando...', 'loading', 0);

            // Desabilita o próprio elemento (seja <a> ou <button>)
            if (element.tagName === 'BUTTON') {
                element.disabled = true; // Desabilita botões
            }
            element.style.pointerEvents = 'none'; // Impede cliques duplos em links
            
            element.textContent = 'Aguarde...'; // Muda o texto
        });
    });
});