document.addEventListener('DOMContentLoaded', function() {
    const button_account = document.querySelector('#account');
    const account_details = document.querySelector('#account-details');
    const button_close = document.querySelector('#button-close');
    const button_quit = document.querySelector('#button-quit');

    button_account.addEventListener('click', function () {
        account_details.style.display = 'block';
    })

    button_close.addEventListener('click', function () {
        account_details.style.display ='none';
    } )

    function quitWebsite () {
            window.location.replace("./index.php")
    }

    button_quit.addEventListener('click', function() {
        quitWebsite();
    })

})

document.addEventListener('DOMContentLoaded', function() {
    button_beer = document.querySelector('#beer-test');

    button_beer.addEventListener('click', function () {
        window.location.replace('../pages/beer_test.php')
    })
})

document.addEventListener("DOMContentLoaded", function() {
    const scrollContainer = document.querySelector("#second-section-images");
    const buttonBack = document.querySelector("#button-back");
    const buttonAdvance = document.querySelector("#button-advance");

    const scrollAmount = 200; // Valor de rolagem em pixels

    // Função para avançar na barra de rolagem
    buttonAdvance.addEventListener("click", function() {
        scrollContainer.scrollBy({
            left: scrollAmount,
            behavior: 'smooth' // Suaviza a rolagem
        });
    });

    // Função para voltar na barra de rolagem
    buttonBack.addEventListener("click", function() {
        scrollContainer.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth' // Suaviza a rolagem
        });
    });
});