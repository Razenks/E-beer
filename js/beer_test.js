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