<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-
        scale=1.0">
    <title>DOA - Sobre</title>

    <link rel="stylesheet" href="css/sobre.css">
    <link rel="icon" href="assets/icon1.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

</head>

<body>
    <!--Navbar e Inicio-->
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index.php"><img src="assets/logo1.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="MenuItems">
                        <li>
                            <a href="perfil.php"> Perfil</a>
                        </li>
                        <li><a href="">Notificações</a></li>
                    </ul>
                </nav>
                <img src="assets/menu.png" class="menu-icon" width="30px" height="25px" onclick="menutoggle()">
            </div>
            <div class="row">
                <div class="col-2u">
                    <h1>Quem somos nós?</h1>
                    <p>O projeto foi criado pelos desenvolvedores: Arthur Silles, Gabriel Germano, Guilherme do Val, 
                    Heloisa Oliveira e Ricardo Sobral, visando apoiar doadores que desejam praticar ações solidárias e, 
                    consequentemente, ajudar as instituições e qualquer pessoa que necessita de uma doação.
                    </p>
                </div>
                <div class="col-2u">
                    <img src="assets/equipe.jpg">
                </div>
            </div>
        </div>
    </div>

    <!--Testioial
    <div class="testimonial">
        <div class="small-container">
            <h2 class="tittle">Por que doar?</h2>
            <div class="row">
                <div class="col-3pq">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    <p>Doar é bom para quem pratica a ação e para quem a recebe.</p>
                    <img src="assets/heart.png">
                </div>
                <div class="col-3pq">
                    <i class="fa fa-quote-left" aria-hidden="true"></i>
                    <p>Ao doar, você evita que mais coisas terminem no lixão.
                        Se todos adotassem esse comportamento, os lixões e aterros sanitários teriam só materiais
                        realmente descartáveis.</p>
                    <img src="assets/dump.png">
                </div>
                <div class="col-3pq">
                    <i class="fa fa-quote-left"></i>
                    <p>A doação é muito importante para organizações sem fins lucrativos como ONGS e Igrejas.</p>
                    <img src="assets/help.png">
                </div>
            </div>
        </div>
    </div>-->

    <!--Equipe-->
    <div class="testimonial">
        <div class="small-container">
            <h2 class="tittle">Nossa Equipe</h2>
            <div class="row">
                <div class="col-3">
                    <img src="assets/arthur.jpg">
                    <h4>Arthur Silles</h4>
                </div>
                <div class="col-3">
                    <img src="assets/germe.jpg">
                    <h4>Gabriel Germano</h4>
                </div>
                <div class="col-3">
                    <img src="assets/eu.jpg">
                    <h4>Guilherme do Val</h4>
                </div>
                <div class="col-3">
                    <img src="assets/helo.jpeg">
                    <h4>Heloisa Oliveira</h4>
                </div>
                <div class="col-3">
                    <img src="assets/sobral.jpg">
                    <h4>Ricardo Sobral</h4>
                </div>
            </div>
        </div>
    </div>
    <br>

    <!--Informações-->
    <div class="container">
        <h2 class="tittle">Informações</h2>
        <div class="row">
            <div class="col-2i">
               <a  target="_blank" href="https://www.youtube.com/watch?v=70yZLeAS0G8">
               <img src="assets/pitch.png"></a>
            </div>
            <div class="col-2">
                <h1>Nosso Objetivo</h1>
                <p>A idealização desse projeto surge por conta da situação que o Brasil vem enfrentando ao longo dos anos, o objetivo da plataforma DOA é tentar ao máximo ajudar as pessoas e instituições que estão passando por 
                alguma necessidade, melhorando não só a vida dos donatários mas também a vida dos doadores.
                </p>
            </div>
        </div>
    </div>

    <!--Marcas-->
    <div class="brands">
        <div class="small-container">
            <div class="row">
                <div class="col-3m">
                    <img src="assets/Logo-Brasão-DRC-CPS-2020_.png">
                </div>

                <div class="col-3m">
                    <img src="assets/logo1.png">
                </div>
            </div>
        </div>
    </div>


    <!--Footer-->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Iniciativa DOA</h3>
                    <p>Você já fez uma boa ação hoje?
                    </p>
                </div>
                <div class="footer-col-2">
                    <img src="assets/logo1white.png">
                    <h4>Mediando a Solidariedade</h4>
                </div>
                <div class="footer-col-3">
                    <h3>Links</h3>
                    <ul>
                        <li>Perfil</li>
                        <li>Doações</li>
                        <li><a href="sobre.php">Quem Somos</a></li>
                    </ul>
                </div>
                <div class="footer-col-4">
                    <h3>Contato</h3>
                    <ul>
                        <li>Facebook</li>
                        <li>Youtube</li>
                        <li>+13997665054</li>
                        <li></li>
                    </ul>
                </div>
            </div>
            <hr class="linha">
            <p class="copyright">© DOA 2021 Todos os Direitos Reservados</p>
        </div>
    </div>

</body>

</html>