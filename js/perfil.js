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
