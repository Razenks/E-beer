document.addEventListener('DOMContentLoaded', function () {
    const wizardForm = document.getElementById('wizard-form');
    // Se o formulário não existir nesta página, pare o script
    if (!wizardForm) {
        return;
    }

    const steps = Array.from(wizardForm.querySelectorAll('.wizard-step'));
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');
    const progressBar = document.getElementById('progress-bar-inner');
    const categoryTitle = document.getElementById('category-title');

    // Para o caso de não haver perguntas
    if (steps.length === 0) {
        return;
    }

    let currentStep = 0;

    function showStep(stepIndex) {
        // Esconde todos os passos
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === stepIndex);
        });

        // Atualiza o título da categoria
        categoryTitle.textContent = steps[stepIndex].dataset.category || '';

        // Atualiza a barra de progresso
        const progress = ((stepIndex + 1) / steps.length) * 100;
        progressBar.style.width = `${progress}%`;

        // Atualiza os botões
        
        // MUDANÇA: 'visibility: hidden' mantém o espaço do botão,
        // o que força o .nav-right a ficar sempre na direita.
        prevBtn.style.visibility = stepIndex === 0 ? 'hidden' : 'visible';
        
        nextBtn.style.display = stepIndex === steps.length - 1 ? 'none' : 'inline-block';
        submitBtn.style.display = stepIndex === steps.length - 1 ? 'inline-block' : 'none';
    }

    function validateCurrentStep() {
        const activeStep = steps[currentStep];
        const radios = activeStep.querySelectorAll('input[type="radio"]');
        
        // Se não houver radios (ex: pergunta de texto), assume válido
        if (radios.length === 0) {
            return true;
        }

        // Verifica se pelo menos um radio está checado
        const isChecked = Array.from(radios).some(radio => radio.checked);
        
        if (!isChecked) {
            // Usa o seu sistema de toast para o erro!
            if (typeof showToast === 'function') {
                showToast('Por favor, selecione uma opção para continuar.', 'error');
            } else {
                alert('Por favor, selecione uma opção para continuar.');
            }
        }
        return isChecked;
    }

    // Event Listeners
    nextBtn.addEventListener('click', () => {
        if (validateCurrentStep()) {
            currentStep++;
            if (currentStep < steps.length) {
                showStep(currentStep);
            }
        }
    });

    prevBtn.addEventListener('click', () => {
        currentStep--;
        if (currentStep >= 0) {
            showStep(currentStep);
        }
    });

    // Inicia o wizard
    showStep(currentStep);
});