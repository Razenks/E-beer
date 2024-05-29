const sair = document.querySelector('#sair');

function sairDoSite() {
    console.log("Valor de window.location.href:", window.location.href);
    window.location.replace("../index.html");
}

sair.addEventListener('click', function(){
    sairDoSite();
});