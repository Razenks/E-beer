document.addEventListener('DOMContentLoaded', function () {
    const button_account = document.querySelector('#account');
    const account_details = document.querySelector('#account-details');
    const button_close = document.querySelector('#button-close');
    const button_quit = document.querySelector('#button-quit');

    button_account.addEventListener('click', function () {
        account_details.style.display = 'block';
    })

    button_close.addEventListener('click', function () {
        account_details.style.display = 'none';
    })

    button_quit.addEventListener('click', function () {
        quitWebsite();
    })

})


document.addEventListener("DOMContentLoaded", function () {
    const scrollContainer = document.querySelector("#second-section-images");
    const buttonBack = document.querySelector("#button-back");
    const buttonAdvance = document.querySelector("#button-advance");

    const scrollAmount = 200; // Valor de rolagem em pixels

    // Função para avançar na barra de rolagem
    buttonAdvance.addEventListener("click", function () {
        scrollContainer.scrollBy({
            left: scrollAmount,
            behavior: 'smooth' // Suaviza a rolagem
        });
    });

    // Função para voltar na barra de rolagem
    buttonBack.addEventListener("click", function () {
        scrollContainer.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth' // Suaviza a rolagem
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const button_change_data = document.querySelector('#change-data');
    const change_data_details = document.querySelector('#change-data-details');
    const button_back_details = document.querySelector('#button-back-details');
    const account_details = document.querySelector('#account-details');

    button_change_data.addEventListener('click', function () {
        change_data_details.style.display = 'block';
        account_details.style.display = 'none';
    });

    button_back_details.addEventListener('click', function () {
        change_data_details.style.display = 'none';
        account_details.style.display = 'block';
    })

    $(document).ready(function () {
        $('#change-telefone').mask('(00) 00000-0000');
    });
    $(document).ready(function () {
        $('.phone-details').mask('(00) 00000-0000');
    });
})

document.getElementById('save-data-changes').addEventListener('click', () => {
    const fileInput = document.getElementById('upload-photo');
    const file = fileInput.files[0];

    if (!file) {
        alert('Por favor, selecione uma imagem.');
        return;
    }

    const formData = new FormData();
    formData.append('foto', file);

    fetch('../config/alterar_dados.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualiza a imagem de perfil
                document.getElementById('profile-photo').src = data.foto;
                alert('Foto alterada com sucesso!');
            } else {
                alert('Erro: ' + data.message);
            }
        })
        .catch(error => console.error('Erro ao alterar a foto:', error));
});

