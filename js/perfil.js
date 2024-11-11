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


