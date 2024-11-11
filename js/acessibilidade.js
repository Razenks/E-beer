//Botao de Acessibilidade
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM totalmente carregado e analisado');

    const buttonAcess = document.querySelector('#acessibilidade');
    const item_1 = document.querySelector('#item-1');

    console.log('buttonAcess:', buttonAcess);
    console.log('item_1:', item_1);

    if (buttonAcess && item_1) {
        buttonAcess.addEventListener('click', function() {
            console.log('Botão clicado');
            if (item_1.style.display === 'block') {
                item_1.style.display = 'none';
            } else {
                item_1.style.display = 'block';
            }
        });
    } else {
        console.error('Elemento não encontrado');
    }
});

//DarkMode
document.addEventListener('DOMContentLoaded', function () {
    function aplicarDarkMode() {
        document.body.classList.add('dark-mode')
    }

    function aplicarLightMode() {
        document.body.classList.remove('dark-mode')
    }

    const radioButtons = document.querySelectorAll('input[name="mode"]');
    radioButtons.forEach(function (radioButton) {
        radioButton.addEventListener('change', function () {
            const mode = this.value;
            if (mode === 'dark') {
                aplicarDarkMode();
            } else {
                aplicarLightMode();
            }
        });
    });

});

//tamanho da fonte - Acessibilidade
document.addEventListener('DOMContentLoaded', function() {

    const smallFont = document.querySelector('#small');
    const normalFont = document.querySelector('#normal');
    const bigFont = document.querySelector('#big');

    function setFontSize(fontSize) {
        document.body.style.fontSize = fontSize;
    }

    smallFont.addEventListener('change', function() {
        if (this.checked) {
            setFontSize('12px');
        }
    });

    normalFont.addEventListener('change', function() {
        if (this.checked) {
            setFontSize('16px');
        }
    });

    bigFont.addEventListener('change', function() {
        if (this.checked) {
            setFontSize('22px');
        }
    });

})