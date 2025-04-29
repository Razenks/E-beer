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
    const button_advance = document.querySelector('#button-advance');
    
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

/* Upload da foto de perfil*/
const inputFile = document.querySelector("#picture_input");
const pictureImage = document.querySelector(".picture_image");
const pictureImageTxt = "Foto";
pictureImage.innerHTML = pictureImageTxt;

inputFile.addEventListener("change", function (e) {
  const inputTarget = e.target;
  const file = inputTarget.files[0];

  if (file) {
    const reader = new FileReader();

    reader.addEventListener("load", function (e) {
      const readerTarget = e.target;

      const img = document.createElement("img");
      img.src = readerTarget.result;
      img.classList.add("picture_img");

      pictureImage.innerHTML = "";
      pictureImage.appendChild(img);
    });

    reader.readAsDataURL(file);
  } else {
    pictureImage.innerHTML = pictureImageTxt;
  }
});

/* Formularios */
document.addEventListener('DOMContentLoaded', function(){
  const menuItems = document.querySelectorAll('.menu-item');
  const sections = document.querySelectorAll('.section');

  menuItems.forEach(item => {
    item.addEventListener('click', function(event){
      event.preventDefault();
      const sectionId = this.getAttribute('data-section');

      sections.forEach(section => {
        section.classList.remove('active');
      });

      document.getElementById(sectionId).classList.add('active');
    });
  });

  // Ativar a primeira seção por padrão
  document.querySelector('.menu-item').click();
});


document.querySelectorAll('.edit-beer').forEach(button => {
  button.addEventListener('click', function() {
      const beerId = this.dataset.id;

      // Faz a requisição AJAX para buscar os dados da cerveja
      fetch(`../config/get_cerveja.php?id=${beerId}`)
          .then(response => response.json())
          .then(data => {
              // Preencher o formulário com os dados recebidos
              document.querySelector('input[name="nome"]').value = data.nome;
              document.querySelector('textarea[name="descricao"]').value = data.descricao;
              document.querySelector('select[name="cor"]').value = data.cor;
              document.querySelector('select[name="teor"]').value = data.teor;
              document.querySelector('select[name="amargor"]').value = data.amargor;
              document.querySelector('select[name="corpo"]').value = data.corpo;
              document.querySelector('select[name="aroma"]').value = data.aroma;
              document.querySelector('select[name="sabor"]').value = data.sabor;
              document.querySelector('select[name="carbonacao"]').value = data.carbonacao;
              document.querySelector('select[name="mouthfeel"]').value = data.mouthfeel;
              // etc. para os outros campos
          });
  });
});


