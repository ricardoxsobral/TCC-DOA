<?php
require_once("connection.php");
if (isset($_POST['botao'])) {
    $erros = array();
    $email =mysqli_escape_string($conexao, $_POST['email']);
    $senha =mysqli_escape_string($conexao, $_POST['senha']);

    if (empty($email) || empty($senha)) {
        $erros[] = "<script>swal('Oops', 'Email e Senha precisam ser preenchidos', 'error');</script>";
    } else {
        $sql = "SELECT ds_email from tb_usuario where ds_email = '$email'";
        $resultado = mysqli_query($conexao, $sql);

        if (mysqli_num_rows($resultado) > 0) {

            $sql = "SELECT * from tb_usuario where ds_email = '$email' and ds_senha = '$senha'";
            $resultado = mysqli_query($conexao, $sql);

            if (mysqli_num_rows($resultado) == 1) {
                $dados = mysqli_fetch_array($resultado);
                $_SESSION['logado'] = true;
                $_SESSION['cd_usuario'] = $dados['cd_usuario'];
                $erros[] = "<script>
                swal({
                    title: 'Parabéns',
                    text: 'Login efetuado com sucesso',
                    icon: 'success',
                    type: 'success'}).then(okay => {
                        if(okay){
                            window.location.href='index2.php';
                        }
                    })
            </script>";
            } else {
                $erros[] = "<script>swal('Oops', 'Usuario e Senha não conferem', 'error');</script>";
            }
        } else {
            $erros[] = "<script>swal('Oops', 'Usuario Inexistente', 'error');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="assets/icon1.png">
    <script type="text/javascript" src="js/login.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://cdnjs.com/libraries/jquery.mask.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
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

        <!--Conta-->
        <div class="account-page">
            <div class="container">
                <div class="rowl">
                    <div class="col-2l">
                        <img class="login-img" src="assets/login2.png" width="100%">
                    </div>
                    <div class="col-2l">
                        <div class="form-container">
                            <h2 class="tittle">Login</h2>
                            <form id="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <?php
                                if (!empty($erros)) {
                                    foreach ($erros as $erro) {
                                        echo $erro;
                                    }
                                }
                                ?>
                                <input class="slot" id="email" type="email" placeholder="Email" name="email" required>
                                <input class="slot" id="senha" type="password" placeholder="Senha" name="senha" maxlength="16" required>
                                <br>
                                <a class="form-a" href="cadastro.php">Ainda não tem cadastro?</a>
                                <button class="botao" name="botao" type="submit">Entrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        
        <!--Footer-->
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
        </div> -->

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