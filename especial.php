<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="assets/icon1.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

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
                        <li><a href="login.php">Entrar</a></li>                     
                    </ul>
                </nav>
                <img src="assets/menu.png" class="menu-icon" width="30px" height="25px" onclick="menutoggle()">
            </div>
        </div>

        <!-----Item------>
        <div class="container item">
            <div class="row">
                <div class="col-2">
                    <img src="assets/catedral.jpg">
                </div>
                <div class="col-2">
                    <p>Home / Anúncio Especial</p>
                    <h1>Trabalho Voluntário Catedral de Santos</h1>
                    <p class="pitem">
                        A Catedral de Santos irá realizar um evento voluntário no dia 22 de Maio às 8 horas.
                        Iremos nos reunir na Catedral e seguiremos para uma creche para entrega de 
                        brinquedos para as crianças. Contamos com sua presença!
                    </p>
                    <h3>Detalhes da Requisição<i class="fa fa-list-ul" style="margin-left: 12px;" aria-hidden="true"></i></h3>
                    <h4>Tipo:<span class="text2"> Trabalho voluntário</span></h4>
                    <h4>Localização:<span class="text2"> Praça José Bonifácio, Centro - Santos (SP)</span></h4>

                    <button class="btnd"><i class="fa fa-heart" id="icone" aria-hidden="true"></i>Favoritar</button>
                    <a class="btnd"><i class="fa fa-flag" id="icone" aria-hidden="true"></i>Denunciar</a>
                </div>
            </div>
        </div>

        <!--Informações-->
    <div class="testimoniali">
        <div class="small-container">
            <h2 class="tittle">Informações</h2>
            <div class="row">
                <div>
                    <img src="assets/ads.jpg">
                </div>
                <div class="col-3i">
                <center>
                    <div class="image-cropper">
                        <img src="assets/padre.jpg">
                    </div>
                </center>
                    <h3>Padre Marcello</h3>
                    <i class="fa fa-envelope-square" id="icones" aria-hidden="true"></i>
                    <i class="fa fa-facebook-square" id="icones" aria-hidden="true"></i>
                    <i class="fa fa-phone-square" id="icones" aria-hidden="true"></i>
                    <p style="color: lightslategrey;">Catedral de Santos - Santos (SP)</p>
                    <a href="" class="btnp">Perfil</a>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29169.322550158242!2d-46.356242117923344!3d-23.9545935572877!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce037f806a8f0f%3A0x43e5db9ec176a9d9!2sCatedral%20de%20Santos%20Nossa%20Senhora%20do%20Ros%C3%A1rio!5e0!3m2!1spt-BR!2sbr!4v1618180751384!5m2!1spt-BR!2sbr"
                    class="frame"></iframe>
                </div> 
                <div>
                    <img src="assets/ads.jpg">
                </div>
            </div>
        </div>
    </div>


        <div class="small-container">
            <h2 class="tittle">Outras Doações</h2>
            <div class="row">
                <div class="col-4">
                    <img src="assets/Ex1.jpg">
                    <h4 class="tittled">Camiseta Azul</h4>
                    <p class="pd">Bom Estado</p>
                </div>
                <div class="col-4">
                    <a class="pname" href="item.php">
                        <img src="assets/Ex2.1.jpg">
                        <h4 class="tittled">Calça Moletom Cinza</h4>
                        <p class="pd">São Vicente (SP)</p>
                    </a>
                </div>
                <div class="col-4">
                    <img src="assets/shirt.png">
                    <h4 class="tittled">Camiseta Azul</h4>
                    <p class="pd">Bom Estado</p>
                </div>
                <div class="col-4">
                    <img src="assets/shirt.png">
                    <h4 class="tittled">Camiseta Azul</h4>
                    <p class="pd">Bom Estado</p>
                </div>
                <a href="roupas.php" class="btni">Ver mais</a>
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
                        <a href="index.php"><img src="assets/logo1white.png"></a>
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

        <!--Responsividade-->
        <script>
            var MenuItems = document.getElementById("MenuItems");

            MenuItems.style.maxHeight = "0px";

            function menutoggle() {
                if (MenuItems.style.maxHeight == "0px") {
                    MenuItems.style.maxHeight = "200px";
                } else {
                    MenuItems.style.maxHeight = "0px";
                }
            }
        </script>

        <!----js carossel--->
        <script>

        </script>

</body>

</html>