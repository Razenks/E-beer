const inputCode = document.getElementById('codigo');

inputCode.addEventListener('input', function () {
    // Remove tudo que no for nmero
    this.value = this.value.replace(/\D/g, '');

    // Garante que no passe de 6 ditos (extra, j que tem maxlength no HTML)
    if (this.value.length > 6) {
        this.value = this.value.slice(0, 6);
    }
});
