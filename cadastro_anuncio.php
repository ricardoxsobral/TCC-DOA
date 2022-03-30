<?php
require_once("connection.php");
$id = $_SESSION['cd_usuario'];
$sql = "SELECT * from tb_usuario where cd_usuario = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
if (isset($_POST['botaoR'])) {
    $erros = array();
    $nome = $_POST["nomedoacao"];
    $tipo = $_POST["tipo"];
    $cond = $_POST["cond"];
    $desc = $_POST["descricao"];
    $imagem = $_FILES["arquivo"]["name"];
    $temp = $_FILES["arquivo"]["tmp_name"];


    $sql = "INSERT INTO tb_itens (cd_usuario, nm_anuncio, ds_descricaoitem, ds_tipo, ds_condicao, nm_img) VALUES ('" . $id . "', '" . $nome . "', '" . $desc . "',  '" . $tipo . "', '" . $cond . "', '" . $imagem . "' )" ;
    $salvar = mysqli_query($conexao, $sql);
    $linhas = mysqli_affected_rows($conexao);
    move_uploaded_file($temp, "assets/" . $imagem);
    $erros[] = "<script>
            swal({
                title: 'Parabéns',
                text: 'Cadastro efetuado com sucesso',
                icon: 'success',
                type: 'success'}).then(okay => {
                    if(okay){
                        window.location.href='perfil.php';
                    }
                })
        </script>";
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA</title>

    <link rel="stylesheet" href="./vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./public/styles/main.min.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="assets/icon1.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script type="text/javascript" src="js/login.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="https://cdnjs.com/libraries/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>

    <!--Navbar e Inicio-->
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div class="logo">
                    <a href="index2.php">
                        <img src="assets/logo1.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="MenuItems">

                        <li>
                            <a href="perfil.php">
                                <img class="image-cropper-min" src="assets/<?= $dados['nm_img'];?>">
                            <?= explode(" ", $dados["nm_usuario"])[0];?>
                            </a>
                        </li>

                        <li class="dropdown">
                            <div role="button" id="notifications-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                Notificações <span class="badge bg-danger rounded-pill" id="unread-badge"></span>
                            </div>
                            <div class="border-0 dropdown-menu dropdown-menu-end px-2 rounded-4 shadow-lg" id="notifications" style="max-height: 30rem; overflow-y: scroll; scroll-behavior: smooth; width: 22.5rem;"></div>
                        </li>
                        
                    </ul>
                </nav>
                <img src="assets/menu.png" class="menu-icon" width="30px" height="25px" onclick="menutoggle()">
            </div>
        </div>

        <!--Cadastro-->
        <center>
            <div class="containerR">
                <h2 class="tittle">Cadastro de Doação</h2>
                <form action="cadastro_anuncio.php" method="POST" enctype="multipart/form-data">
                    <?php
                    if (!empty($erros)) {
                        foreach ($erros as $erro) {
                            echo $erro;
                        }
                    }
                    ?>
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">Nome da Doação</span>
                            <input type="text" name="nomedoacao" placeholder="Digite o nome da Doação" maxlength="100" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Tipo de Doação</span>
                            <select name="tipo" class="drop1" id="tipo">
                                <option value="Roupas">Roupas</option>
                                <option value="Alimentos">Alimentos</option>
                                <option value="Objetos">Objetos</option>
                                <option value="Trabalho voluntário">Trabalho voluntário</option>
                                <option value="Móveis">Móveis</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Condição Física da Doação</span>
                            <select name="cond" class="drop1" id="tipo">
                                <option value="Novo">Novo</option>
                                <option value="Semi-Novo">Semi-Novo</option>
                                <option value="Usado">Usado</option>
                                <option value="Desgastado">Desgastado</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <span class="details">Foto</span>
                            <input type="file" name="arquivo" id="arquivo" class="arquivo1">
                        </div>
                        <div class="input-box">
                        </div>
                        <div class="input-box">
                        </div>
                        <div class="input-box">
                            <span class="details">Descrição da Doação</span>
                            <textarea class="txtarea1" type="text" name="descricao" maxlength="1000" placeholder="Descreva a doação" required></textarea>
                        </div>
                        <button class="botaoR" name="botaoR" type="submit">Cadastrar</button>
                    </div>
                </form>
            </div>
        </center>


        <!-- <div class="footer">
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
                            <li><a href="sobre.php
                        ">Quem Somos</a></li>
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
        </div>-->

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

    <script src="./vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./public/scripts/notification.prod.js"></script>

</body>

</html>