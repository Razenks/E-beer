document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#form-cadastro");
    const nameInput = document.querySelector("#name");
    const emailInput = document.querySelector("#email");
    const passwordInput = document.querySelector("#senha");
    const confirmPasswordInput = document.querySelector("#confirm-senha");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // Verifica se o nome está vazio
        if (nameInput.value.trim() === "") {
            alert("Por favor, preencha o seu nome!");
            return;
        }

        // Verifica se o email está preenchido e se é válido
        if (emailInput.value.trim() === "" || !isEmailValid(emailInput.value)) {
            alert("Por favor, preencha o seu email corretamente!");
            return;
        }

        // Verifica se a senha tem pelo menos 8 caracteres
        if (passwordInput.value.trim().length < 8) {
            alert("A senha precisa ter no mínimo 8 caracteres!");
            return;
        }

        // Verifica se a confirmação de senha é igual à senha
        if (confirmPasswordInput.value.trim() !== passwordInput.value.trim()) {
            alert("A confirmação de senha não corresponde à senha digitada!");
            return;
        }

        // Se todas as validações passarem, pode prosseguir com o envio do formulário ou fazer o que desejar aqui
        alert("Formulário válido! Você pode prosseguir com o envio.");
    });

    // Função que valida e-mail
    function isEmailValid(email) {
        // Cria uma regex para validar o e-mail
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email);
    }
});
