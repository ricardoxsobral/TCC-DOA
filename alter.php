<?php
require_once("connection.php");
$id = $_SESSION['cd_usuario'];
$sql = "SELECT * from tb_usuario where cd_usuario = '$id'";
$resultado = mysqli_query($conexao, $sql);
$dados = mysqli_fetch_array($resultado);
if (isset($_POST['botao'])) {
    $erros = array();
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $nascimento = $_POST["nascimento"];
    $telefone = $_POST["telefone"];
    $cep = $_POST["cep"];
    $uf = $_POST["uf"];
    $cidade = $_POST["cidade"];
    $bairro = $_POST["bairro"];
    $rua = $_POST["rua"];
    $cpf = $_POST["cpf"];
    $cnpj = $_POST["cnpj"];
    $imagem = $_FILES["arquivo"]["name"];
    $temp = $_FILES["arquivo"]["tmp_name"];

    $sql = "UPDATE tb_usuario SET cd_telefone = $telefone,  ds_email = $email, ds_senha = $senha, nm_cidade = $cidade, nm_usuario = $nome, sg_estado = $uf
    , dt_nascimento = $nascimento, cd_cep = $cep, ds_bairro = $bairro, ds_rua = $rua, nm_img = $imagem, cd_cpf = $cpf, cd_cnpj = $cnpj WHERE cd_usuario = $id;";

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
                    <a href="index2.php"><img src="assets/logo1.png" width="125px"></a>
                </div>
                <nav>
                    <ul id="MenuItems">

                        <li>
                            <a href="perfil.php">
                                <img class="image-cropper-min" src="assets/<?= $dados['nm_img'];?>">
                            <?= explode(" ", $dados["nm_usuario"])[0];?>
                            </a>
                        </li>

                        <li><a href="sobre.php">Quem Somos</a></li>

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
                <h2 class="tittle">Alterar Cadastro</h2>
                <form action="cadastro.php" method="POST" enctype="multipart/form-data">
                    <?php
                    if (!empty($erros)) {
                        foreach ($erros as $erro) {
                            echo $erro;
                        }
                    }
                    ?>
                    <div class="user-details">
                        <div class="input-box">
                            <span class="details">Nome Completo</span>
                            <input type="text" name="nome" placeholder="Digite seu Nome" maxlength="100" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Email</span>
                            <input type="email" name="email" placeholder="Digite seu Email" maxlength="50" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Senha</span>
                            <input type="password" name="senha" placeholder="Digite uma Senha" maxlength="16" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Data de Nascimento</span>
                            <input type="date" name="nascimento" required>
                        </div>
                        <div class="input-box">
                            <span class="details">Telefone</span>
                            <input type="number" name="telefone" placeholder="Digite seu Telefone" maxlength="11" required>
                        </div>
                        <div class="input-box">
                            <span class="details">CEP</span>
                            <input name="cep" type="text" name="cep" id="cep" class="slot " class="mascCEP" value="" size="10" maxlength="9" onblur="pesquisacep(this.value);" placeholder="CEP">
                        </div>
                        <div class="input-box">
                            <span class="details">UF</span>
                            <input class="slot" name="uf" name="uf" type="text" id="uf" maxlength="2" size="2" placeholder="Estado">
                        </div>
                        <div class="input-box">
                            <span class="details">Cidade</span>
                            <input class="slot" name="cidade" type="text" id="cidade" size="40" placeholder="Cidade">
                        </div>
                        <div class="input-box">
                            <span class="details">Bairro</span>
                            <input class="slot" name="bairro" type="text" id="bairro" size="40" placeholder="Bairro">
                        </div>
                        <div class="input-box">
                            <span class="details">Rua</span>
                            <input class="rua1" name="rua" type="text" id="rua" size="40" placeholder="Rua">
                        </div>

                        <div class="input-box">
                            <span class="detailsRb">Identificação</span>
                            <label class="containerRb">CPF
                                <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck" required>
                                <span class="checkmark"></span>
                            </label>
                            <label class="containerRb">CNPJ
                                <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" required>
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="input-box">
                            <div class="cpf">
                                <div id="ifYes" style="visibility:hidden">CPF:
                                    <input type='text' name='cpf' onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' maxlength="14" placeholder="Digite seu CPF">
                                </div>
                            </div>
                            <div class="cnpj">
                                <div id="ifNo" style="visibility:hidden">CNPJ:
                                    <input type='text' name='cnpj' onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()' maxlength="18" placeholder="Digite seu CNPJ">
                                </div>
                            </div>
                        </div>
                        <div class="input-box">
                            <span class="details">Foto</span>
                            <input type="file" name="arquivo" id="arquivo" class="arquivo1">
                        </div>
                        <button class="botaoR" name="botao" type="submit">Alterar</button>

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