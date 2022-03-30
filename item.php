<?php
    require_once("connection.php");
    $_GET['pagina'];
    $_GET['page'];
    $id = $_SESSION['cd_usuario'];
    $sql = "SELECT * from tb_usuario where cd_usuario = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);

    if (!defined("requiring"))
        define("requiring", true);
    require_once "./app/Models/Model.php";
    class Item extends Model {

        private $database;

        function __construct() {
            $this->database = $this->connect_database();
        }

        public function show() {
            $query = $this->database->prepare("SELECT 
                    tb_usuario.nm_cidade, 
                    tb_usuario.sg_estado, 
                    tb_itens.* 
                FROM tb_itens 
                INNER JOIN tb_usuario ON tb_usuario.cd_usuario = tb_itens.cd_usuario 
                WHERE cd_item = ?;");
            $query->execute([
                $_GET["pagina"]
            ]);
            $data = $query->fetch();

            $is_paused = false;
            $is_requested = false;
            if (isset($_SESSION["cd_usuario"])) {
                if ($data["qt_solicitacao"] == $data["qt_max_solicitacao"])
                    $is_paused = true;
                
                $query = $this->database->prepare("SELECT cd_solicitacao FROM tb_solicitacao WHERE cd_item = ? AND cd_usuario = ?;");
                $query->execute([
                    $_GET["pagina"], 
                    $_SESSION["cd_usuario"]
                ]);
                if ($query->rowCount() != 0)
                    $is_requested = true;
            }   

            return [
                "data" => $data, 
                "is_paused" => $is_paused, 
                "is_requested" => $is_requested
            ];
        }

    }
    $item_show = (new Item)->show();

    if ($item_show["data"]["dt_conclusao"] != null)
        exit(header("Location: index2.php"));

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOA</title>

    <link href="./vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="./public/styles/main.min.css" rel="stylesheet">

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
                    <a href="index2.php">
                        <img src="assets/logo1.png" width="125px">
                    </a>
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
        <div class="container item">
            <div class="row">
                <div class="col-2">
                    <img src="assets/<?= $item_show["data"]["nm_img"];?>">
                </div>
                <div class="col-2">
                    <h1><?= $item_show["data"]["nm_anuncio"];?></h1>
                    <p class="pitem">
                    <?= "<span id='total_requests'>" . $item_show["data"]['qt_solicitacao'] . "</span>/" . $item_show["data"]['qt_max_solicitacao'] . " solicitações";?>
                    </p>
                    <p class="pitem">
                    <?= $item_show["data"]['ds_descricaoitem'];?>
                    </p>
                    <br>
                    <h4>Tipo:
                        <span class="text2">
                        <?= $item_show["data"]['ds_tipo'];?>
                        </span>
                    </h4>
                    <h4>Estado do item:
                        <span class="text2">
                        <?= $item_show["data"]['ds_condicao'];?>
                        </span>
                    </h4>

                    <h4>Localização:
                        <span class="text2">
                        <?= $item_show["data"]['nm_cidade'] . "(" . $item_show["data"]['sg_estado'] . ")";?>
                        </span>
                    </h4>

                <?php if (isset($_SESSION["cd_usuario"]) && $item_show["data"]["cd_usuario"] != $_SESSION["cd_usuario"]) {?>
                    <button class="bg-brand-500 btnd hover:bg-brand-400 text-white" 
                    <?= $item_show["is_requested"] || $item_show["is_paused"] ? "disabled" : "";?> 
                        id="request">
                    <?= $item_show["is_requested"] ? "Solicitado" : ($item_show["is_paused"] ? "Pausado" : "Solicitar");?>
                    </button>
                <?php }?>

                </div>
            </div>
        </div>
    <!--Outras Doações-->
<?php
    $sqli = "SELECT * from tb_itens";
    $result = mysqli_query($conexao, $sqli);
    if (mysqli_num_rows($result)  > 0) {
?>
        <div class="small-container">
            <h2 class="tittle">Ánuncios</h2>
            <div class="row">
            <?php
                while ($data = $result->fetch_array()) {
            ?>
                <div class="col-4">
                    <a class="pname" href="item.php?page=<?php echo $data['cd_usuario']; ?>&pagina=<?php echo $data['cd_item']; ?>">
                        <img src="assets/<?php echo $data['nm_img']; ?>">
                        <h4 class="tittled"><?php echo $data['nm_anuncio']; ?></h4>
                        <p class="pd"><?php echo $data['ds_tipo']; ?> </p>
                    </a>
                </div>
            <?php }} else {?>
            <div class="small-container">
                <h2 class="tittle">Anúncios</h2>
                <div class="row">
                    <div class="col-4">
                        <center>
                            <img src="assets/nada.png">
                            <h4>Nenhuma Doação</h4>
                            <p class="pd">Anuncie agora!</p>
                        </center>
                    </div>
                </div>
            </div>
            <?php }?>
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
    <!--Responsividade-->
    <script>
        var MenuItems = document.getElementById("MenuItems");
        MenuItems.style.maxHeight = "0px";
        function menutoggle() {
            if (MenuItems.style.maxHeight == "0px") {
                MenuItems.style.maxHeight = "200px";
            } 
            else {
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>

    <script src="./vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./public/scripts/notification.prod.js"></script>
    <script src="./public/scripts/announcement.prod.js"></script>

</body>
</html>