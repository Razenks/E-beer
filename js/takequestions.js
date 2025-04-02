let perguntas = [];
let respostasUsuario = {};

// Função para carregar perguntas e alternativas do PHP
async function carregarPerguntas() {
    const response = await fetch('../config/obterPerguntas.php');
    perguntas = await response.json();
    mostrarPergunta(0);
}

// Função para mostrar uma pergunta e suas alternativas
function mostrarPergunta(indice) {
    const questionContainer = document.getElementById('question-container');
    questionContainer.innerHTML = '';

    if (indice < perguntas.length) {
        const pergunta = perguntas[indice];

        // Cria e estiliza o título da pergunta (h3)
        const perguntaElem = document.createElement('h3');
        perguntaElem.textContent = pergunta.pergunta;
        perguntaElem.classList.add('pergunta-titulo');
        questionContainer.appendChild(perguntaElem);

        pergunta.alternativas.forEach(alternativa => {
            // Cria o botão para cada alternativa
            const button = document.createElement('button');
            button.textContent = alternativa.descricao;
            button.classList.add('alternativa-botao'); // Adiciona uma classe CSS para estilizar
            button.onclick = () => {
                // Armazena a resposta do usuário
                respostasUsuario[`pergunta_${indice}`] = alternativa.id;
                // Passa para a próxima pergunta
                mostrarPergunta(indice + 1);
            };
            questionContainer.appendChild(button);
        });
    } else {
        // Exibe o botão de enviar ao final do questionário
        document.getElementById('submit-button').style.display = 'block';
    }
}


// Função para enviar respostas ao PHP
// Função para enviar respostas ao PHP
document.getElementById('submit-button').onclick = async function () {
    const save_answer = document.querySelector('.save-answer');
    const response = await fetch('../config/salvarRespostas.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(respostasUsuario)
    });
    const result = await response.json();
    save_answer.style.display = 'block';
    save_answer.style.backgroundColor = 'green'; 
    save_answer.style.margin = 'auto';
    save_answer.style.textAlign = 'center';
    save_answer.style.justifyContent = 'center';
    //alert(result.mensagem);

    if (result.status === 'sucesso') {
        // Após o envio bem-sucedido, buscar a recomendação da cerveja
        const recomendacaoResponse = await fetch('../config/recomendarCerveja.php', {
            method: 'GET',
        });

        const recomendacao = await recomendacaoResponse.json();

        if (recomendacao.status === 'sucesso') {
            exibirRecomendacaoCerveja(recomendacao.cerveja);
        } else {
            alert('Erro ao obter a recomendação.');
        }
    }
};

// Função para exibir a recomendação de cerveja
function exibirRecomendacaoCerveja(cerveja) {
    const mainContainer = document.getElementById('main-container');
    mainContainer.innerHTML = ''; // Limpa a tela atual

    const recomendacaoContainer = document.createElement('div');
    recomendacaoContainer.id = 'beer-container'; // Usa o mesmo id do estilo CSS

    // Imagem da cerveja
    const cervejaImg = document.createElement('div');
    cervejaImg.id = 'cerveja-img';
    const img = document.createElement('img');
    img.src = cerveja.img_cerveja;
    img.alt = cerveja.nome;
    cervejaImg.appendChild(img);
    recomendacaoContainer.appendChild(cervejaImg);

    // Informações da cerveja
    const rightSide = document.createElement('div');
    rightSide.id = 'right-side';

    // Nome e descrição
    const topSection = document.createElement('div');
    topSection.id = 'top';
    const titulo = document.createElement('h1');
    titulo.textContent = cerveja.nome;
    const descricao = document.createElement('p');
    descricao.id = 'descricao-text';
    descricao.textContent = cerveja.descricao;
    topSection.appendChild(titulo);
    topSection.appendChild(descricao);
    rightSide.appendChild(topSection);

    // Características em grid
    const caracteristicas = document.createElement('div');
    caracteristicas.id = 'beer-characteristics';

    const atributos = [
        { label: 'Amargor', valor: cerveja.desc_amargor },
        { label: 'Corpo', valor: cerveja.desc_corpo },
        { label: 'Aroma', valor: cerveja.desc_aroma },
        { label: 'Sabor', valor: cerveja.desc_sabor },
        { label: 'Carbonatação', valor: cerveja.desc_carbona },
        { label: 'Cor', valor: cerveja.desc_cor },
        { label: 'Teor alcoólico', valor: cerveja.desc_teor }
    ];

    atributos.forEach(attr => {
        const item = document.createElement('div');
        item.innerHTML = `<strong>${attr.label}:</strong> ${attr.valor}`;
        caracteristicas.appendChild(item);
    });

    rightSide.appendChild(caracteristicas);
    recomendacaoContainer.appendChild(rightSide);
    mainContainer.appendChild(recomendacaoContainer);
}

// Carregar o questionário ao carregar a página
carregarPerguntas();
