<?php 
    if (!defined("requiring") && !isset($_POST["announcement_method"]))
        exit(http_response_code(404));

    error_reporting(0);
    set_time_limit(0);
    ignore_user_abort(false);

    setlocale(LC_ALL, "pt_BR", "brazil", "pt_BR.UTF-8", "pt_BR@real", "portuguese-brazilian");
    date_default_timezone_set("UTC");

    if (!defined("requiring"))
        define("requiring", true);
    require_once "NotificationController.php";
    require_once "../Models/Model.php";

    class Announcement extends Model {

        private $notification_controller;
        private $database;

        function __construct() {
            $this->notification_controller = new Notification;
            $this->database = $this->connect_database();
        }

        public function store() {
            $query = $this->database->prepare("SELECT cd_usuario FROM tb_itens WHERE cd_item = ?;");
            $query->execute([
                $_POST["announcement"]
            ]);
            $donor = $query->fetch();

            $query = $this->database->prepare("INSERT INTO tb_solicitacao (cd_item, cd_usuario) VALUES (?, ?);");
            $query->execute([
                $_POST["announcement"], 
                $_SESSION['cd_usuario']
            ]);

            $this->notification_controller->notify(["1", $this->database->lastInsertId(), $_SESSION["cd_usuario"]]);
            $this->notification_controller->notify(["2", $this->database->lastInsertId(), $donor["cd_usuario"]]);

            $query = $this->database->prepare("UPDATE tb_itens SET qt_solicitacao = qt_solicitacao + 1 WHERE cd_item = ?;");
            $query->execute([
                $_POST["announcement"], 
            ]);
        }

        public function edit() {
            if (isset($_SESSION["cd_usuario"]) && isset($_GET["announcement"]) && is_numeric($_GET["announcement"])) {
                $query = $this->database->prepare("SELECT * FROM tb_itens 
                    INNER JOIN tb_solicitacao ON tb_solicitacao.cd_item = tb_itens.cd_item
                    WHERE tb_itens.cd_item = ? AND tb_itens.cd_usuario = ?;");
                $query->execute([$_GET["announcement"], $_SESSION["cd_usuario"]]);
                if ($data = $query->fetch())
                    return $data;
                else
                    http_response_code(404);
            }
            else
                http_response_code(404);
        }

    }

    if (isset($_POST["announcement_method"])) {
        session_start();
        (new Announcement)->{ $_POST["announcement_method"] }();
        session_write_close();
    }
?>