/**
 * Exibe um toast no canto da tela.
 * @param {string} message A mensagem a ser exibida.
 * @param {string} type O tipo de toast (success, error, info, warning, loading).
 * @param {number} duration Duração em milissegundos. (Use 0 para infinito).
 */
function showToast(message, type = 'info', duration = 5000) {
    // 1. Encontra ou cria o container
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container'; // <<< CORREÇÃO DA ÚLTIMA VEZ (só para garantir que está no seu)
        document.body.appendChild(container);
    }

    // 2. Cria o elemento do toast
    const toast = document.createElement('div');
    toast.className = `toast ${type}`; // Ex: "toast loading"
    toast.textContent = message;

    // 3. Adiciona ao container
    container.appendChild(toast);

    // 4. Inicia animação de entrada
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);

    // ==========================================================
    // MUDANÇA CRÍTICA AQUI
    // ==========================================================
    // Só agenda a remoção se a duração for positiva
    if (duration > 0) {
        // 5. Prepara a remoção
        // Inicia a animação de saída
        setTimeout(() => {
            toast.classList.remove('show');
            toast.classList.add('hide');
        }, duration - 500); // Começa a sair 500ms antes do fim

        // Remove o elemento do DOM após a animação de saída
        setTimeout(() => {
            toast.remove();
        }, duration); // Remove no tempo exato
    }
    // Se duration for 0, o toast fica na tela até a página ser recarregada.
    // ==========================================================
    // FIM DA MUDANÇA
    // ==========================================================
}