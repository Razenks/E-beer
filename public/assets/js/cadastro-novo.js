document.addEventListener('DOMContentLoaded', function () {
    form = document.querySelector('#form');
    nomeInput = document.querySelector('#nome');
    emailInput = document.querySelector('#email');
    cpfinput = document.querySelector('#cpf');
    senhaInput = document.querySelector('#senha');

    form.addEventListener('submit', function (e) {
        if (nomeInput.value.trim() == "") {
            alert("Por favor, Preencher o nome corretamente!");
            e.preventDefault();
        }
        if (emailInput.value.trim() == "") {
            alert("Por favor, Preencher o email corretamente!");
            e.preventDefault();
        }
        if (cpfinput.value.trim() == "") {
            alert("Por favor, Preencher o cpf corretamente!");
            e.preventDefault();
        }
        if (senhaInput.value.trim() == "") {
            alert("Por favor, Preencher a senha corretamente!");
            e.preventDefault();
        }
        if (senhaInput.value.length < 8) {
            alert("A senha deve ter mais de 8 caracteres!");
            e.preventDefault();
        }
    });

    // Função que valida e-mail
    function isEmailValid(email) {
        // Cria uma regex para validar o e-mail
        const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email);
    }
})

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('cpf').addEventListener('input', function (e) {
        let cpf = e.target.value;

        // Remove qualquer caractere que não seja número
        cpf = cpf.replace(/\D/g, "");

        // Adiciona os pontos e o hífen automaticamente
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

        // Atualiza o valor do campo de entrada
        e.target.value = cpf;
    });

})

document.addEventListener('DOMContentLoaded', function () {
    const passwordView = document.querySelector('#senha');
    const passwordViewSecond = document.querySelector('#confirm-senha')
    const view_button = document.querySelector('#view-button');
    const view_button_second = document.querySelector('#view-button-second')
    const n_view_button = document.querySelector('#n-view-button');
    const n_view_button_second = document.querySelector('#n-view-button-second');

    n_view_button.addEventListener('click', function () {
        view_button.style.display = 'block'
        n_view_button.style.display = 'none';
        passwordView.type = 'text';
    })

    view_button.addEventListener('click', function () {
        n_view_button.style.display = 'block';
        view_button.style.display = 'none';
        passwordView.type = 'password';
    })

    n_view_button_second.addEventListener('click', function () {
        view_button_second.style.display = 'block';
        n_view_button_second.style.display = 'none';
        passwordViewSecond.type = 'text';
    })

    view_button_second.addEventListener('click', function () {
        n_view_button_second.style.display = 'block';
        view_button_second.style.display = 'none';
        passwordViewSecond.type = 'password';
    })
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('enter').addEventListener('click', function (e) {
        const password = document.getElementById('senha').value;
        const confirmPassword = document.getElementById('confirm-senha').value;
        const message = document.getElementById('message-error');

        // Verifica se as senhas são iguais
        if (password !== confirmPassword) {
            e.preventDefault(); // Evita o envio se as senhas forem diferentes
            message.textContent = 'As senhas não estão iguais'; 
            message.style.color = 'red';
        } else {
            // Permite o envio se as senhas estiverem corretas
            message.textContent = ''; // Limpa a mensagem de erro
        }
    });
});