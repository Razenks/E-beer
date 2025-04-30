<?php
// login.php

// Inicie a sessão se necessário
// session_start();

// Verifica se há mensagem de sucesso ou erro
$msgSucessoCadastro = isset($_GET['msgSucesso']) ? $_GET['msgSucesso'] : '';
$msgErroCadastro = isset($_GET['msgErro']) ? $_GET['msgErro'] : '';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/all.css">
    <script src="./js/all.js"></script>
    <script src="./js/login.js"></script>
    <!-- Script do reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<!---->

<body>
    <header id="imagem-top">
        <img src="./assets/logo_ebeer.png" alt="">
    </header>
    <main>
        <h1>LOGIN</h1>

        <div class="success-container">
            <?php
            if (!empty($msgSucessoCadastro)) {
                echo '<p class="success-msg">' . htmlspecialchars($msgSucessoCadastro) . '</p>';
            }
            ?>
        </div>

        <div class="error-container">
            <?php
            if (isset($_GET['msgErro'])) {
                echo '<p class="error-msg">' . $_GET['msgErro'] . '</p>';
            }
            ?>
        </div>

        <form action="./config/processa_login.php" method="post" id="form-login">
            <div id="email-box">
                <label for="email">E-mail</label>
                <input type="email" placeholder="" id="email" name="email" required>
            </div>
            <br>
            <div id="password-box">
                <label for="senha">Senha</label>
                <div id="view-password">
                    <input type="password" placeholder="" id="senha" name="senha" required>
                    <button id="n-view-button" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-eye-slash-fill" viewBox="0 0 16 16">
                            <path
                                d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z" />
                            <path
                                d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z" />
                        </svg>
                    </button>
                    <button id="view-button" style="display: none;" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-eye-fill" viewBox="0 0 16 16">
                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                            <path
                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="terms-box">
                <input type="checkbox" name="aceito_termos" id="aceito_termos" required>
                <label for="aceito_termos">
                    Aceito os <a href="#" onclick="abrirModal('termos')">termos e condições</a> e as
                    <a href="#" onclick="abrirModal('privacidade')">políticas de privacidade</a>.
                </label>
            </div>



            <div id="captcha-container">
                <div class="g-recaptcha" data-sitekey="6LfhFQ8rAAAAAEi55UaZDqBpP6rcQLMr3f3lQmT9"></div>
            </div>

            <button type="submit" id="submit-btn">ENTRAR</button>
        </form>
        <button id="sign-up" type="submit"><a href="./pages/cadastro.php">Cadastrar</a></button>
        <br>
        <button id="forgot-password">Esqueceu a senha?</button>


        <!-- TEXTO MODAL TERMOS E CONDIÇÕES -->
        <!-- Modal Termos e Condições -->
        <div id="modal-termos" class="modal" style="display:none;">
            <button onclick="fecharModal('termos')">X</button>

            <div class="modal-content">
                <h2>Termos e Condições</h2>
                <p>1. Termos:
                    Ao acessar ao site E-beer, concorda em cumprir estes termos de serviço, todas as leis e regulamentos
                    aplicáveis ​​e concorda que é responsável pelo cumprimento de todas as leis locais aplicáveis. Se
                    você não concordar com algum desses termos, está proibido de usar ou acessar este site. Os materiais
                    contidos neste site são protegidos pelas leis de direitos autorais e marcas comerciais aplicáveis.
                </p>
                <p>
                    2. Uso de Licença:
                    É concedida permissão para baixar temporariamente uma cópia dos materiais (informações ou software)
                    no site E-beer , apenas para visualização transitória pessoal e não comercial. Esta é a concessão de
                    uma licença, não uma transferência de título e, sob esta licença, você não pode:

                    modificar ou copiar os materiais;
                    usar os materiais para qualquer finalidade comercial ou para exibição pública (comercial ou não
                    comercial);
                    tentar descompilar ou fazer engenharia reversa de qualquer software contido no site E-beer;
                    remover quaisquer direitos autorais ou outras notações de propriedade dos materiais; ou
                    transferir os materiais para outra pessoa ou 'espelhe' os materiais em qualquer outro servidor.
                    Esta licença será automaticamente rescindida se você violar alguma dessas restrições e poderá ser
                    rescindida por E-beer a qualquer momento. Ao encerrar a visualização desses materiais ou após o
                    término desta licença, você deve apagar todos os materiais baixados em sua posse, seja em formato
                    eletrónico ou impresso.
                </p>
                <p>
                    3. Isenção de responsabilidade:
                    Os materiais no site da E-beer são fornecidos 'como estão'. E-beer não oferece garantias, expressas
                    ou implícitas, e, por este meio, isenta e nega todas as outras garantias, incluindo, sem limitação,
                    garantias implícitas ou condições de comercialização, adequação a um fim específico ou não violação
                    de propriedade intelectual ou outra violação de direitos.
                    Além disso, o E-beer não garante ou faz qualquer representação relativa à precisão, aos resultados
                    prováveis ​​ou à confiabilidade do uso dos materiais em seu site ou de outra forma relacionado a
                    esses materiais ou em sites vinculados a este site.
                </p>
                <p>
                    4. Limitações:
                    Em nenhum caso o E-beer ou seus fornecedores serão responsáveis ​​por quaisquer danos (incluindo,
                    sem limitação, danos por perda de dados ou lucro ou devido a interrupção dos negócios) decorrentes
                    do uso ou da incapacidade de usar os materiais em E-beer, mesmo que E-beer ou um representante
                    autorizado da E-beer tenha sido notificado oralmente ou por escrito da possibilidade de tais danos.
                    Como algumas jurisdições não permitem limitações em garantias implícitas, ou limitações de
                    responsabilidade por danos conseqüentes ou incidentais, essas limitações podem não se aplicar a
                    você.
                </p>
                <p>
                    5. Precisão dos materiais:
                    Os materiais exibidos no site da E-beer podem incluir erros técnicos, tipográficos ou fotográficos.
                    E-beer não garante que qualquer material em seu site seja preciso, completo ou atual. E-beer pode
                    fazer alterações nos materiais contidos em seu site a qualquer momento, sem aviso prévio. No
                    entanto, E-beer não se compromete a atualizar os materiais.
                </p>
                <p>
                    6. Links:
                    O E-beer não analisou todos os sites vinculados ao seu site e não é responsável pelo conteúdo de
                    nenhum site vinculado. A inclusão de qualquer link não implica endosso por E-beer do site. O uso de
                    qualquer site vinculado é por conta e risco do usuário.
                </p>

                <p>
                    Modificações:
                    O E-beer pode revisar estes termos de serviço do site a qualquer momento, sem aviso prévio. Ao usar
                    este site, você concorda em ficar vinculado à versão atual desses termos de serviço.
                </p>
                <p>
                    Lei aplicável:
                    Estes termos e condições são regidos e interpretados de acordo com as leis do E-beer e você se
                    submete irrevogavelmente à jurisdição exclusiva dos tribunais naquele estado ou localidade.
                </p>
            </div>
        </div>

        <!-- Modal Políticas de Privacidade -->
        <div id="modal-privacidade" class="modal" style="display:none;">
            <div class="modal-content">
                <button onclick="fecharModal('privacidade')">X</button>

                <h2>Políticas de Privacidade</h2>
                <p>
                    A sua privacidade é importante para nós. É política do E-beer respeitar a sua privacidade em relação
                    a qualquer informação sua que possamos coletar no site E-beer, e outros sites que possuímos e
                    operamos.
                </p>

                <p>
                    Solicitamos informações pessoais apenas quando realmente precisamos delas para lhe fornecer um
                    serviço. Fazemo-lo por meios justos e legais, com o seu conhecimento e consentimento. Também
                    informamos por que estamos coletando e como será usado.
                </p>

                <p>
                    Apenas retemos as informações coletadas pelo tempo necessário para fornecer o serviço
                    solicitado.
                    Quando armazenamos dados, protegemos dentro de meios comercialmente aceitáveis ​​para evitar
                    perdas
                    e roubos, bem como acesso, divulgação, cópia, uso ou modificação não autorizados.
                </p>
                <p>
                    Não compartilhamos informações de identificação pessoal publicamente ou com terceiros, exceto
                    quando
                    exigido por lei.
                </p>
                <p>
                    O nosso site pode ter links para sites externos que não são operados por nós. Esteja ciente de
                    que
                    não temos controle sobre o conteúdo e práticas desses sites e não podemos aceitar
                    responsabilidade
                    por suas respectivas políticas de privacidade.
                </p>
                <p>
                    Você é livre para recusar a nossa solicitação de informações pessoais, entendendo que talvez não
                    possamos fornecer alguns dos serviços desejados.
                </p>
                <p>
                    O uso continuado de nosso site será considerado como aceitação de nossas práticas em torno de
                    privacidade e informações pessoais. Se você tiver alguma dúvida sobre como lidamos com dados do
                    usuário e informações pessoais, entre em contacto connosco.
                </p>

                <p>

                    O serviço Google AdSense que usamos para veicular publicidade usa um cookie DoubleClick para
                    veicular anúncios mais relevantes em toda a Web e limitar o número de vezes que um determinado
                    anúncio é exibido para você.
                    Para mais informações sobre o Google AdSense, consulte as FAQs oficiais sobre privacidade do
                    Google
                    AdSense.
                    Utilizamos anúncios para compensar os custos de funcionamento deste site e fornecer
                    financiamento
                    para futuros desenvolvimentos. Os cookies de publicidade comportamental usados ​​por este site
                    foram
                    projetados para garantir que você forneça os anúncios mais relevantes sempre que possível,
                    rastreando anonimamente seus interesses e apresentando coisas semelhantes que possam ser do seu
                    interesse.
                    Vários parceiros anunciam em nosso nome e os cookies de rastreamento de afiliados simplesmente
                    nos
                    permitem ver se nossos clientes acessaram o site através de um dos sites de nossos parceiros,
                    para
                    que possamos creditá-los adequadamente e, quando aplicável, permitir que nossos parceiros
                    afiliados
                    ofereçam qualquer promoção que pode fornecê-lo para fazer uma compra.
                </p>

                <p>

                    Compromisso do Usuário
                    O usuário se compromete a fazer uso adequado dos conteúdos e da informação que o E-beer oferece
                    no
                    site e com caráter enunciativo, mas não limitativo:

                    A) Não se envolver em atividades que sejam ilegais ou contrárias à boa fé a à ordem pública;
                    B) Não difundir propaganda ou conteúdo de natureza racista, xenofóbica, jogos de sorte ou azar,
                    qualquer tipo de pornografia ilegal, de apologia ao terrorismo ou contra os direitos humanos;
                    C) Não causar danos aos sistemas físicos (hardwares) e lógicos (softwares) do E-beer, de seus
                    fornecedores ou terceiros, para introduzir ou disseminar vírus informáticos ou quaisquer outros
                    sistemas de hardware ou software que sejam capazes de causar danos anteriormente mencionados.
                    Mais informações
                    Esperemos que esteja esclarecido e, como mencionado anteriormente, se houver algo que você não
                    tem
                    certeza se precisa ou não, geralmente é mais seguro deixar os cookies ativados, caso interaja
                    com um
                    dos recursos que você usa em nosso site.
                </p>
                <br><br>
                Esta política é efetiva a partir de 23 April 2025 12:06</p>
            </div>
        </div>

        <!-- Fundo escuro para ambos -->
        <div id="modal-backdrop" style="display:none"></div>

    </main>
</body>

</html>