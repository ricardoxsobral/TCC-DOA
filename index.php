<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA</title>
    <script type="text/javascript" src="js/login.js"></script>
    <script src="js/sweetalert.min.js"></script>
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
            <div class="row">
                <div class="col-2">
                    <h1>Mediando a Solidariedade</h1>
                    <p style="color: lightslategray;">
                        Faça uma boa ação hoje! <br>
                        Veja as doações disponíveis
                    </p>
                    <a href="#categoria" class="btni">Começar</a>
                </div>
                <div class="col-2">
                    <img src="assets/hom1.jpg">
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>

    <!--Texto-->
    <div class="container">
        <div class="row">
            <div class="col-2t">
                <img src="assets/ajudando.jpg">
            </div>
            <div class="col-2t">
                <h1>Doações Online Agora</h1>
                <p>
                    Unindo boas ações e tornando o mundo um lugar melhor,<br>
                    Venha conhecer nossa equipe!
                </p>
                <a class="btni"onclick="swal({
                    title: 'Atenção',
                    text: 'Faça o Login para continuar...',
                    icon: 'info',
                    type: 'success'}).then(okay => {
                        if(okay){
                            window.location.href='login.php';
                        }
                    })"> Descubra</a>
            </div>
        </div>
    </div>
    </div>

    <!--Especial-->
    <div class="offer">
        <div class="small-container">
            <div class="row">
                <div class="col-2" style="margin-top: 10px;">
                    <img src="assets/catedral.jpg" class="especial">
                </div>
                <div class="col-2">
                    <p>ANÚNCIO ESPECIAL</p>
                    <h1>Trabalho Voluntário</h1>
                    <p class="esptxt">
                        A Catedral de Santos irá realizar um evento voluntário no dia 22 de Maio.
                        Venha participar!
                    </p>
                    <a href="especial.php" class="btn">Saiba Mais <i class="fa fa-info-circle" style="margin-left: 4px;" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>




    <!--Categorias-->
    <div class="small-container">
        <h2 class="tittle" id="categoria">Categorias</h2>
        <div class="row">
            <div class="col-5" onclick="swal({
                    title: 'Atenção',
                    text: 'Faça o Login para continuar...',
                    icon: 'info',
                    type: 'success'}).then(okay => {
                        if(okay){
                            window.location.href='login.php';
                        }
                    })">
                <img src="assets/shirt.png">
                <h4>Roupas</h4>
            </div>
            <div class="col-5" onclick="swal({
                    title: 'Atenção',
                    text: 'Faça o Login para continuar...',
                    icon: 'info',
                    type: 'success'}).then(okay => {
                        if(okay){
                            window.location.href='login.php';
                        }
                    })">
                <img src="assets/diet.png">
                <h4>Alimentos</h4>
            </div>
            <div class="col-5" onclick="swal({
                    title: 'Atenção',
                    text: 'Faça o Login para continuar...',
                    icon: 'info',
                    type: 'success'}).then(okay => {
                        if(okay){
                            window.location.href='login.php';
                        }
                    })">
                <img src="assets/objetos.png">
                <h4>Objetos</h4>
            </div>
            <div class="col-5" onclick="swal({
                    title: 'Atenção',
                    text: 'Faça o Login para continuar...',
                    icon: 'info',
                    type: 'success'}).then(okay => {
                        if(okay){
                            window.location.href='login.php';
                        }
                    })">
                <img src="assets/volunteer.png">
                <h4>Voluntariado</h4>
            </div>
            <div class="col-5" onclick="swal({
                    title: 'Atenção',
                    text: 'Faça o Login para continuar...',
                    icon: 'info',
                    type: 'success'}).then(okay => {
                        if(okay){
                            window.location.href='login.php';
                        }
                    })">
                <img src="assets/furn.png">
                <h4>Móveis</h4>
            </div>
        </div>
    </div>

    <!--Descubra-->
   

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
</body>

</html>