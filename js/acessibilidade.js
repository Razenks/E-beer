// Define o valor inicial do aumento
let fontSizeMultiplier = 1;

// Objeto para armazenar os tamanhos de fonte originais
const originalFontSizes = {};

// Função para armazenar os tamanhos de fonte originais
function armazenarFontesOriginais() {
    const elementos = document.querySelectorAll("*");
    elementos.forEach((elemento) => {
        const tamanhoAtual = window.getComputedStyle(elemento).fontSize;
        originalFontSizes[elemento] = parseFloat(tamanhoAtual);
    });
}

// Chamar a função ao carregar a página
window.onload = armazenarFontesOriginais;

function aumentarFonte() {
    fontSizeMultiplier += 0.05;
    aplicarTamanhoFonte();
}

function diminuirFonte() {
    fontSizeMultiplier -= 0.05;
    aplicarTamanhoFonte();
}

function aplicarTamanhoFonte() {
    const maxFontSize = 25; // Limite máximo de tamanho da fonte
    const minFontSize = 10; // Limite mínimo de tamanho da fonte

    const elementos = document.querySelectorAll("*");
    elementos.forEach((elemento) => {
        const tamanhoOriginal = originalFontSizes[elemento];
        if (tamanhoOriginal) {
            let novoTamanho = tamanhoOriginal * fontSizeMultiplier;

            // Aplica os limites
            if (novoTamanho > maxFontSize) {
                novoTamanho = maxFontSize;
            } else if (novoTamanho < minFontSize) {
                novoTamanho = minFontSize;
            }

            elemento.style.fontSize = `${novoTamanho}px`;
        }
    });
}

function resetarFonte() {
    fontSizeMultiplier = 1;
    aplicarTamanhoFonte();
}


function alterarAcessibilidade() {
    const acess = document.querySelector("#acessibilidade");

    if (acess.style.display === 'block') {
        acess.style.display = 'none'; // Exibe a div
    } else {
        acess.style.display = 'block'; // Esconde a div
    }
}


// Função para alternar entre modo claro e modo escuro
function alternarModoNoturno() {
    // Seleciona todos os elementos da página
    const elementos = document.querySelectorAll('*');

    // Percorre todos os elementos
    elementos.forEach((elemento) => {

        // Modo escuro: aplicar fundo escuro e texto branco
        elemento.style.backgroundColor = '#121212'; // Cor de fundo escura
        elemento.style.color = 'white';  // Texto branco

        const estiloBorda = window.getComputedStyle(elemento).border;

        if (estiloBorda.includes('1px solid rgb(0, 0, 0)')) {
            // Muda a borda para '1px solid white'
            elemento.style.border = '1px solid white';
        }

    });
}

function voltarModoOriginal() {
    // Seleciona todos os elementos da página
    const elementos = document.querySelectorAll('*');

    // Percorre todos os elementos
    elementos.forEach((elemento) => {
        // Restaura as cores de fundo e texto para o padrão
        elemento.style.backgroundColor = '';
        elemento.style.color = '';

        const estiloBorda = window.getComputedStyle(elemento).border;

        if (estiloBorda.includes('1px solid rgb(255, 255, 255)')) {
            // Muda a borda para '1px solid black'
            elemento.style.border = '1px solid  black';
        }
    });

}

// Função para definir e salvar o tema no localStorage
function setTheme(tema) {
    document.documentElement.className = tema; // Define a classe no <html>
    localStorage.setItem('tema', tema);       // Salva o tema no localStorage
}

// Ao carregar a página, aplica o tema salvo no localStorage
document.addEventListener("DOMContentLoaded", function () {
    const temaSalvo = localStorage.getItem('tema') || ''; // Tema padrão: vazio (modo claro)
    document.documentElement.className = temaSalvo;      // Aplica o tema salvo
});

// Alterna para o modo escuro
function alternarModoNoturno() {
    setTheme('tema-escuro'); // Aplica o tema escuro
}

// Retorna ao modo padrão
function voltarModoOriginal() {
    setTheme('tema-claro'); // Remove qualquer tema aplicado, voltando ao padrão
}


