document.addEventListener('DOMContentLoaded', function () {
    const passwordView = document.querySelector('#senha');
    const view_button = document.querySelector('#view-button');
    const n_view_button = document.querySelector('#n-view-button');

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
});




