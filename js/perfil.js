const imageField = document.querySelector("#imagem-field");
const imagePreview = document.querySelector("#image-preview");

const loadImage = (e) => {
    const filePath = e.target || window.event.srcElement;

    const file = filePath.files;

    const fileReader = new FileReader();

    fileReader.onload = () => {
        imagePreview.src = fileReader.result;
    };

    fileReader.readAsDataURL(file[0])
}
imageField.addEventListener("change", loadImage)


// Função para mostrar o conteúdo da opção selecionada
function mostrarConteudo(opcao) {
    // Esconde todos os conteúdos
    const conteudos = document.querySelectorAll('.conteudo > div');
    conteudos.forEach(function (conteudo) {
        conteudo.style.display = 'none';
    });
    // Mostra o conteúdo da opção selecionada
    conteudoSelecionado = document.getElementById(opcao);
    conteudoSelecionado.style.display = 'block';
}


//Adicionar e verificar cartões
var cartoes = 0;

const verCartoes = document.querySelector('.vercartoes');
const button = document.querySelector('#button3');

function adicionarCartao() {
    cartoes += 1;
}

button.addEventListener('click', function(){
    adicionarCartao();
    window.alert('Cartão Adicionado com sucesso!');
});
    
verCartoes.addEventListener('click', function() {
    if (cartoes == 0){
        window.alert('Você nao tem cartões para ver. Adicione um!');
    } else {
        window.alert('transferindo para a pagina de Cartões');
        console.log("Valor de window.location.href:", window.location.href);
        window.location.replace("../HTML/main.html");
    }
});
