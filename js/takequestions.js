import questions from './questions.js';

const conteudo = document.querySelector('#main-container');
const questao = document.querySelector('.question');
const respostasContainer = document.querySelector('.answers');
const showInfo = document.querySelector('.show-info');
const showInfotext = showInfo.querySelector('span');
const finish = document.querySelector('.finish');
const finishText = finish.querySelector('span');
const botaoRefazer = finish.querySelector('button');

let indiceAtual = 0;
const respostasUsuario = [];

// Função para mostrar a pergunta atual
function mostrarPergunta() {
    const perguntaAtual = questions[indiceAtual];
    questao.textContent = perguntaAtual.question;
    respostasContainer.innerHTML = '';

    perguntaAtual.answers.forEach((resposta) => {
        const botaoResposta = document.createElement('button');
        botaoResposta.textContent = resposta.option;
        botaoResposta.onclick = () => {
            respostasUsuario[indiceAtual] = resposta.option;
            indiceAtual++;
            if (indiceAtual < questions.length) {
                mostrarPergunta();
            } else {
                mostrarResultado();
            }
        };
        respostasContainer.appendChild(botaoResposta);
    });
}

// Função para mostrar o resultado baseado nas respostas do usuário
function mostrarResultado() {
    conteudo.style.display = 'none';
    finish.style.display = 'block';

    let mensagemFinal = 'Recomendação:  ';

    finishText.textContent = mensagemFinal;
}

// Evento para reiniciar o questionário
botaoRefazer.onclick = () => {
    indiceAtual = 0;
    respostasUsuario.length = 0; // Limpa as respostas do usuário
    conteudo.style.display = 'block';
    finish.style.display = 'none';
    mostrarPergunta();
};

// Inicializa o questionário ao carregar a página
mostrarPergunta();
