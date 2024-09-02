<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-beer</title>
    <link rel="stylesheet" href="../CSS/main-novo.css">
    <script src="../js/main-novo.js"></script>
    <script src="../js/acessibilidade.js"></script>
    <script src="../js/rolamento.js"></script>
</head>

<body>

    <header>
        <nav id="navegation-bar">
            <div id="logo-image">
                <img src="../img/logo_ebeer.png" alt="logo_ebeer" style="width: 110px; height: 50px;">
            </div>
            <div id="profile-config">
                <img src="../img/icons8-male-user-96.png" alt="" style="width: 50px; height: 50px;">
                <div id="name-account">
                    <p>Olá, João</p>
                    <button id="account">Conta</button>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="account-details" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-lg"
                viewBox="0 0 16 16" id="button-close">
                <path
                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
            </svg>
            <h1>João Victor Souza</h1>
            <p class="email-details">joaovictor@gmail.com</p>
            <p class="phone-details">+55(67)98411-3344</p>
            <button id="button-orders">Meus Pedidos</button>
            <button id="button-help">Ajuda</button>
            <button id="button-quit">Sair</button>
        </section>

        <section id="first-section">
            <h1>Encontrar sua cerveja perfeita <br> nunca foi tao fácil</h1>
            <button id="beer-test">BeerFeed</button>
        </section>

        <section id="second-section">
            <h1>Produtos</h1>
            <div id="second-section-images">
                <button id="button-back"><img src="../img/icons8-voltar-72.png" alt=""></button>
                <div>
                    <div>
                        <img src="../img/american_premium.png" alt="">
                        <p>American premium</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/apa.png" alt="">
                        <p>Apa</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/blond_ale.png" alt="">
                        <p>Blond ale</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/chop_doppelbock.png" alt="">
                        <p>doppel bock</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/chop_red_ale.png" alt="">
                        <p>red ale</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/chop_stout.png" alt="">
                        <p>stout</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/flanders_red_ale.png" alt="">
                        <p>flanders red ale</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/hidromel_dry_mead.png" alt="">
                        <p>dry mead</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/low_carb.png" alt="">
                        <p>low carb</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/pilsen_premium.png" alt="">
                        <p>pilsen premium</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/weiss.png" alt="">
                        <p>weiss</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <div>
                    <div>
                        <img src="../img/witbier.png" alt="">
                        <p>witbier</p>
                    </div>
                    <a href="">Ver Detalhes</a>
                </div>
                <button id="button-advance" type="button"><img src="../img/icons8-avançar-72.png" alt=""></button>
            </div>

        </section>

        <section id="third-section">
            <h2>Como funciona o e-Beer?</h2>
            <img src="../img/canecas.png" alt="">
            <p id="third-section-text">Com o e-beer, você pode responder ao nosso questionário interativo, o BeerFeed, e
                receber recomendações personalizadas de cervejas artesanais que combinam perfeitamente com o seu
                paladar. Basta algumas respostas para encontrar a cerveja ideal para o seu gosto</p>
        </section>
    </main>

    <footer id="footer">
        <div id="last-section">
            <a href="">Voltar ao topo</a>
        </div>
        <p>e-Beer</p>
    </footer>
</body>

</html>