let count = 1;
document.getElementById("radio1").checked = true;

setInterval( function(){
    nextImage();
}, 3400)

function nextImage() {
    count ++;
    if(count > 3) {
        count = 1;
    }

    document.getElementById("radio" +count).checked = true;
}

//mudar para a pagina da cerveja
const cerveja = document.querySelector('#cervejateste');

function mudarDePagina() {
    console.log("Valor de window.location.href:", window.location.href);
    window.location.replace("../HTML/cervejateste.html");
}

cerveja.addEventListener('click', function(){
    mudarDePagina();
})