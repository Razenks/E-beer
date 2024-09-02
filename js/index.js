document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#form-login");
    const emailInput = document.querySelector("#email");
    const passwordInput = document.querySelector("#senha");
    const submitBtn = document.querySelector("#submit-btn");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        // Verifica se o email está preenchido e se é válido
        if (emailInput.value.trim() === "" || !isEmailValid(emailInput.value)) {
            alert("Por favor, preencha o seu email corretamente!");
            return;
        }

        // Verifica se a senha está preenchida e tem no mínimo 8 caracteres
        if (passwordInput.value.trim().length < 8) {
            alert("A senha precisa ter no mínimo 8 caracteres!");
            return;
        }


        // Verifica o valor de window.location.href antes do redirecionamento
        console.log("Valor de window.location.href:", window.location.href);

        // Redirecionamento alternativo usando JavaScript
        window.location.replace("./HTML/main.php");
    });

    // Função que valida e-mail
    function isEmailValid(email) {
        // Cria uma regex para validar o e-mail
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email);
    }
});


document.addEventListener('DOMContentLoaded', function () {
    // Seleciona os elementos do DOM
    const forgotPasswordButton = document.querySelector('#forgot-password-button');
    const closeButton = document.querySelector('#close-button');
    const forgotPasswordScreen = document.querySelector('#forgot-password');
    const send = document.querySelector('#recover-button');
    

    // Exibe o modal ao clicar no botão "Esqueceu sua senha?"
    forgotPasswordButton.addEventListener('click', function () {
        forgotPasswordScreen.style.display = 'block';
    });

    // Oculta o modal ao clicar no botão "X"
    closeButton.addEventListener('click', function () {
        forgotPasswordScreen.style.display = 'none';
    });

    // Oculta o modal se clicar fora dele
    window.addEventListener('click', function (event) {
        if (event.target === forgotPasswordScreen) {
            forgotPasswordScreen.style.display = 'none';
        }

        send.addEventListener('click', function () {
            send.textContent = 'Email enviado com sucesso!'
        })
    });
});


