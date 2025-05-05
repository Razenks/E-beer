
document.getElementById("submit").addEventListener("click", function () {
    const emailInput = document.getElementById("email");
    const message = document.getElementById("message");

    if (emailInput.value.trim() === "") {
        message.textContent = "Por favor, digite um email válido.";
        message.style.color = "red";
    } else {
        message.textContent = `Um link de recuperação foi enviado para ${emailInput.value}.`;
        message.style.color = "green";
    }
});

