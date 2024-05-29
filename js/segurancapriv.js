function aplicarDarkMode() {
    document.body.classList.add('dark-mode')
}

function aplicarLightMode() {
    document.body.classList.remove('dark-mode')
}

const radioButtons = document.querySelectorAll('input[name="mode"]');
radioButtons.forEach(function(radioButton){
    radioButton.addEventListener('change', function(){
        const mode = this.value;
        if (mode === 'dark') {
            aplicarDarkMode();
        } else {
            aplicarLightMode();
        }
    });
});