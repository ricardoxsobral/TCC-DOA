<?php 
    if (!defined("requiring") && !isset($_POST["notif_method"]))
        exit(http_response_code(404));

    error_reporting(0);
    set_time_limit(0);
    ignore_user_abort(false);
    
    setlocale(LC_ALL, "pt_BR", "brazil", "pt_BR.UTF-8", "pt_BR@real", "portuguese-brazilian");
    date_default_timezone_set("UTC");

    if (!defined("requiring"))
        define("requiring", true);
    require_once "../Models/Model.php";

    class Notification extends Model {

        private $database;

        function __construct() {
            $this->database = $this->connect_database();
        }

        public function show() {
            if (isset($_POST["latest"])) {
                $request_timestamp = (new DateTime("NOW"))->format("Y-m-d H:i:s");
                while (true) {
                    $query = $this->database->prepare("SELECT * FROM tb_notificacao WHERE cd_usuario = ? AND dt_criacao >= ? ORDER BY dt_criacao;");
                    $query->execute([
                        $_SESSION["cd_usuario"], 
                        $request_timestamp
                    ]);

                    if ($query->rowCount()) {
                        $response = $this->build_notifications($query->fetchAll());
                        break;
                    }
                    else {
                        session_write_close();
                        sleep(5);
                    }
                }
            }
            else {
                $query = $this->database->prepare("SELECT 
                        tb_notificacao.cd_notificacao, 
                        tb_notificacao.dt_criacao, 
                        tb_notificacao.ic_concluida, 
                        tb_notificacao.cd_tipo, 
                        tb_solicitacao.dt_conclusao, 
                        tb_solicitacao.cd_solicitacao 
                    FROM tb_notificacao 
                    INNER JOIN tb_solicitacao ON tb_solicitacao.cd_solicitacao = tb_notificacao.cd_solicitacao 
                    WHERE tb_notificacao.cd_usuario = ? AND (tb_notificacao.cd_tipo = 2 OR tb_notificacao.cd_tipo = 3 OR tb_notificacao.cd_tipo = 5);");
                $query->execute([
                    $_SESSION["cd_usuario"]
                ]);
                $all_data = $query->fetchAll();
                foreach ($all_data as $data) {
                    if (strtotime("+5 days", strtotime($data["dt_criacao"])) <= strtotime("now") && 
                        (($data["cd_tipo"] == 3 && !$data["dt_conclusao"]) || 
                        ($data["cd_tipo"] != 3 && $data["ic_concluida"] === null))) {
                        $query = $this->database->prepare("UPDATE tb_notificacao SET 
                                ic_visualizado = FALSE, 
                                dt_criacao = DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 SECOND) 
                            WHERE cd_notificacao = ?;");
                        $query->execute([
                            $data["cd_notificacao"]
                        ]);        
                    }
                }

                $query = $this->database->prepare("SELECT * FROM tb_notificacao WHERE cd_usuario = ? ORDER BY dt_criacao;");
                $query->execute([
                    $_SESSION["cd_usuario"]
                ]);

                if ($query->rowCount())
                    $response = $this->build_notifications($query->fetchAll());
                else
                    $response = [
                        "notifications" => "<div class='dropdown-item-text text-black-50'>Suas notificações aparecerão aqui.</div>", 
                    ];
            }

            echo json_encode($response);
        }

        private function build_notifications($notif_data) {
            $notifications = "";
            $unread_count = null;
            $notif_requests = [];
            $date = "";
            $year = "";

            foreach ($notif_data as $data) {
                $query = $this->database->prepare("SELECT cd_usuario FROM tb_solicitacao WHERE cd_solicitacao = ?");
                $query->execute([
                    $data["cd_solicitacao"]
                ]);
                $donee = $query->fetch();
                if ($donee["cd_usuario"] != $_SESSION["cd_usuario"])
                    $query = $this->database->prepare("SELECT 
                        tb_itens.cd_usuario, 
                        tb_usuario.sg_estado, 
                        tb_usuario.nm_cidade, 
                        tb_usuario.qt_reputacao, 
                        tb_usuario.vl_reputacao, 
                        tb_usuario.nm_usuario, 
                        tb_solicitacao.dt_conclusao, 
                        tb_itens.nm_anuncio, 
                        tb_usuario.cd_telefone 
                    FROM tb_solicitacao 
                    INNER JOIN tb_itens ON tb_itens.cd_item = tb_solicitacao.cd_item 
                    INNER JOIN tb_usuario ON tb_usuario.cd_usuario = tb_solicitacao.cd_usuario
                    WHERE cd_solicitacao = ?");
                else
                    $query = $this->database->prepare("SELECT 
                        tb_itens.cd_usuario, 
                        tb_usuario.sg_estado, 
                        tb_usuario.nm_cidade, 
                        tb_usuario.qt_reputacao, 
                        tb_usuario.vl_reputacao, 
                        tb_usuario.nm_usuario, 
                        tb_solicitacao.dt_conclusao, 
                        tb_itens.nm_anuncio, 
                        tb_usuario.cd_telefone 
                    FROM tb_solicitacao 
                    INNER JOIN tb_itens ON tb_itens.cd_item = tb_solicitacao.cd_item 
                    INNER JOIN tb_usuario ON tb_usuario.cd_usuario = tb_itens.cd_usuario
                    WHERE cd_solicitacao = ?");
                $query->execute([
                    $data["cd_solicitacao"]
                ]);
                $additional_data = $query->fetch();

                $unread = "text-black-50";
                if ($data["ic_visualizado"] == false) {
                    $unread_count++;
                    $unread = "";
                }

                if (!$year)
                    $year = date("Y", strtotime($data["dt_criacao"]));
                else if ($year != date("Y", strtotime($data["dt_criacao"]))) {
                    $notifications .= "
                        <div class='dropdown-item-text bg-gray-100 rounded-4'>
                            <span>$year</span>
                        </div>";
                    $year = date("Y", strtotime($data["dt_criacao"]));
                }

                $date = (new DateTime($data["dt_criacao"]))->setTimezone(new DateTimeZone($_POST["timezone"]));
                if (date("Y-m-d") == explode(" ", $data["dt_criacao"])[0])
                    $date = $date->format('H:i');
                else
                    $date = $date->format('d/m');

                switch ($data["cd_tipo"]) {
                    case "1":
                        $notifications .= "
                            <div class='d-flex flex-column px-3 py-2 rounded-4 $unread'>
                                <div class='align-items-center'>Solicitação em <strong>" . $additional_data["nm_anuncio"] . "</strong> enviada.</div>
                                <div class='align-items-center my-1'>$date</div>
                            </div>";
                        break;
                    case "2":
                        if ($data["ic_concluida"] === null)
                            $confirmacao = "<button class='bg-brand-500 notif-btn notif-btn-sm hover:bg-brand-400 rounded-4 text-white' id='confirm'>Confirmar</button>
                                <button class='bg-gray-300 notif-btn notif-btn-sm hover:bg-gray-200 ms-2 rounded-4' id='refuse'>Recusar</button>";
                        else if ($data["ic_concluida"] == true)
                            $confirmacao = "Confirmado";
                        else
                            $confirmacao = "Recusado";

                        if (floatval($additional_data["vl_reputacao"]) == 0)
                            $user_rate = "5,0";
                        else
                            $user_rate = number_format(floatval($additional_data["vl_reputacao"]) / floatval($additional_data["qt_reputacao"]), 1, ",", ".");
                        
                        $notifications .= "
                            <div class='d-flex flex-column hover:--hide:d-none hover:--show:d-inline-flex px-3 py-2 rounded-4 $unread'>
                                <div>
                                    <strong class='--hide'>" . explode(" ", $additional_data["nm_usuario"])[0] . " " . explode(" ", $additional_data["nm_usuario"])[count(explode(" ", $additional_data["nm_usuario"])) - 1] . "</strong>
                                    <div class='d-none mw-100 --show'>
                                        <span class='text-truncate'>" . $additional_data["nm_cidade"] . "</span>
                                        <div class='align-items-center d-flex text-nowrap'>
                                            <span>, " . strtoupper($additional_data["sg_estado"]) . " ·</span>
                                            <svg class='mx-1 text-brand-500' fill='currentColor' viewBox='0 0 20 20' width='18' height='18'>
                                                <path d='M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z'></path>
                                            </svg>
                                            <span>" . $user_rate . " (" . $additional_data["qt_reputacao"] . ")</span>
                                        </div>
                                    </div>
                                    <span>solicitou sua doação em 
                                        <strong>" . $additional_data["nm_anuncio"] . "</strong>
                                    </span>
                                </div>
                                <div class='align-items-center d-flex my-1'>
                                    <span>$date</span>
                                    <div class='ms-auto'>$confirmacao</div>
                                </div>
                            </div>";
                        break;
                    case "3":
                        $phone = [];
                        $phone[0] = substr($additional_data["cd_telefone"], 0, 2);
                        if (strlen($additional_data["cd_telefone"]) == 10) {
                            $phone[1] = substr($additional_data["cd_telefone"], 2, 4);
                            $phone[2] = substr($additional_data["cd_telefone"], 6);
                        }
                        else {
                            $phone[1] = substr($additional_data["cd_telefone"], 2, 5);
                            $phone[2] = substr($additional_data["cd_telefone"], 7);
                        }
                        
                        $conclusion = "";
                        if ($additional_data["dt_conclusao"] == null) {
                            if ($additional_data["cd_usuario"] == $_SESSION["cd_usuario"])
                                $conclusion = "<button class='bg-brand-500 notif-btn notif-btn-sm hover:bg-brand-400 me-2 rounded-4 text-white' id='conclude'>Concluir</button>";
                            $conclusion .= "<div class='dropup'>
                                <button class='bg-gray-300 notif-btn notif-btn-sm hover:bg-gray-200 rounded-4' data-bs-toggle='dropdown'>Contato</button>
                                <div class='dropdown-menu dropdown-menu-end'>
                                    <div class='dropdown-item-text text-nowrap'>(" . $phone[0] . ") " .  $phone[1]  . "-" .  $phone[2]  . "</div>
                                </div>
                            </div>";    
                        }
                        else
                            $conclusion = "Concluido";

                        if ($additional_data["cd_usuario"] == $_SESSION["cd_usuario"]) {
                            $notifications .= "
                                <div class='d-flex flex-column px-3 py-2 rounded-4 $unread'>
                                    <div class='align-items-center'>
                                        <span>Entre em contato com </span>
                                        <strong>" . explode(" ", $additional_data["nm_usuario"])[0] . " " . explode(" ", $additional_data["nm_usuario"])[count(explode(" ", $additional_data["nm_usuario"])) - 1] . "</strong>
                                        <span> para concluir a doação <strong>" . $additional_data["nm_anuncio"] . "</strong>.</span>
                                    </div>
                                    <div class='align-items-center d-flex my-1'>
                                        <span>$date</span>
                                        <div class='ms-auto d-flex'>$conclusion</div>
                                    </div>
                                </div>";
                        }
                        else
                            $notifications .= "
                                <div class='d-flex flex-column px-3 py-2 rounded-4 $unread'>
                                    <div class='align-items-center'>
                                        <strong>" . explode(" ", $additional_data["nm_usuario"])[0] . " " . explode(" ", $additional_data["nm_usuario"])[count(explode(" ", $additional_data["nm_usuario"])) - 1] . " </strong>
                                        <span>confirmou sua solicitacao. Entre em contato para concluir a doação 
                                            <strong>" . $additional_data["nm_anuncio"] . "</strong>.
                                        </span>
                                    </div>
                                    <div class='align-items-center d-flex my-1'>
                                        <span>$date</span>
                                        <div class='ms-auto d-flex'>$conclusion</div>
                                    </div>
                                </div>";
                        break;
                    case "4":
                        $notifications .= "
                            <div class='d-flex flex-column px-3 py-2 rounded-4 $unread'>
                                <div class='align-items-center'>
                                    <span>Sua solicitação em <strong>" . $additional_data["nm_anuncio"] . "</strong> foi recusada. Tente outro anúncio.</span>
                                </div>
                                <div class='align-items-center d-flex my-1'>
                                    <span>$date</span>
                                </div>
                            </div>";
                        break;
                    case "5":
                        if ($data["ic_concluida"] != true)
                            $notifications .= "
                                <div class='d-flex flex-column px-3 py-2 rounded-4 $unread'>
                                    <div class='align-items-center'>
                                        <span>Avalie o comportamento </span>
                                        <strong>" . explode(" ", $additional_data["nm_usuario"])[0] . " " . explode(" ", $additional_data["nm_usuario"])[count(explode(" ", $additional_data["nm_usuario"])) - 1] . "</strong>
                                        <span> durante a doação <strong>" . $additional_data["nm_anuncio"] . "</strong>.</span>
                                    </div>
                                    <div class='align-items-center d-flex my-1'>
                                        <span>$date</span>
                                        <div class='ms-auto d-flex'>
                                            <div class='stars-rating'>
                                                <svg class='text-brand-500' value='1' fill='none' stroke='currentColor' viewBox='0 0 20 20' width='22' height='22'>
                                                    <path d='M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z'></path>
                                                </svg>
                                                <svg class='text-brand-500' value='2' fill='none' stroke='currentColor' viewBox='0 0 20 20' width='22' height='22'>
                                                    <path d='M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z'></path>
                                                </svg>
                                                <svg class='text-brand-500' value='3' fill='none' stroke='currentColor' viewBox='0 0 20 20' width='22' height='22'>
                                                    <path d='M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z'></path>
                                                </svg>
                                                <svg class='text-brand-500' value='4' fill='none' stroke='currentColor' viewBox='0 0 20 20' width='22' height='22'>
                                                    <path d='M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z'></path>
                                                </svg>
                                                <svg class='text-brand-500' value='5' fill='none' stroke='currentColor' viewBox='0 0 20 20' width='22' height='22'>
                                                    <path d='M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z'></path>
                                                </svg>
                                            </div>
                                            <button class='bg-gray-300 disabled:bg-gray-200 notif-btn notif-btn-sm hover:bg-gray-200 ms-2 rounded-4' id='rate' disabled>Avaliar</button>
                                        </div>
                                    </div>
                                </div>";
                        else
                            $notifications .= "
                                <div class='d-flex flex-column px-3 py-2 rounded-4 $unread'>
                                    <div class='align-items-center'>
                                        <span>Avalie o comportamento </span>
                                        <strong>" . explode(" ", $additional_data["nm_usuario"])[0] . " " . explode(" ", $additional_data["nm_usuario"])[count(explode(" ", $additional_data["nm_usuario"])) - 1] . "</strong>
                                        <span> durante a doação <strong>" . $additional_data["nm_anuncio"] . "</strong>.</span>
                                    </div>
                                    <div class='align-items-center d-flex my-1'>
                                        <span>$date</span>
                                        <span class='ms-auto'>Avaliado</span>
                                    </div>
                                </div>";
                        break;
                }

                array_push($notif_requests, $data["cd_solicitacao"]);
            }

            return [
                "notifications" => $notifications, 
                "unread_count" => $unread_count, 
                "notif_requests" => $notif_requests
            ];
        }

        public function read_all() {
            $query = $this->database->prepare("UPDATE tb_notificacao SET ic_visualizado = TRUE WHERE cd_usuario = ? AND ic_visualizado = FALSE;");
            $query->execute([
                $_SESSION["cd_usuario"]
            ]);
        }

        public function notify($notif_data) {
            $query = $this->database->prepare("INSERT INTO tb_notificacao (cd_tipo, cd_solicitacao, cd_usuario) VALUES (?, ?, ?)");
            $query->execute($notif_data);
        }

        public function confirm() {
            $query = $this->database->prepare("UPDATE tb_notificacao SET ic_concluida = TRUE WHERE cd_usuario = ? AND cd_solicitacao = ? AND cd_tipo = 2;");
            $query->execute([
                $_SESSION["cd_usuario"], 
                $_POST["notif_request"]
            ]);

            $this->notify(["3", $_POST["notif_request"], $_SESSION["cd_usuario"]]);

            $query = $this->database->prepare("SELECT cd_usuario FROM tb_solicitacao WHERE cd_solicitacao = ?;");
            $query->execute([
                $_POST["notif_request"]
            ]);
            $donee = $query->fetch();
            $this->notify(["3", $_POST["notif_request"], $donee["cd_usuario"]]);
        }

        public function refuse() {
            $query = $this->database->prepare("UPDATE tb_notificacao SET ic_concluida = FALSE WHERE cd_usuario = ? AND cd_solicitacao = ? AND cd_tipo = 2;");
            $query->execute([
                $_SESSION["cd_usuario"], 
                $_POST["notif_request"]
            ]);

            $query = $this->database->prepare("SELECT cd_usuario FROM tb_solicitacao WHERE cd_solicitacao = ?;");
            $query->execute([
                $_POST["notif_request"]
            ]);
            $donee = $query->fetch();
            $this->notify(["4", $_POST["notif_request"], $donee["cd_usuario"]]);

            $query = $this->database->prepare("SELECT cd_item FROM tb_solicitacao WHERE cd_solicitacao = ?;");
            $query->execute([
                $_POST["notif_request"]
            ]);
            $announcement = $query->fetch()["cd_item"];
            $query = $this->database->prepare("UPDATE tb_itens SET qt_solicitacao = qt_solicitacao - 1 WHERE cd_item = ?;");
            $query->execute([
                $announcement
            ]);

            $query = $this->database->prepare("UPDATE tb_solicitacao SET dt_conclusao = CURRENT_TIMESTAMP WHERE cd_solicitacao = ?;");
            $query->execute([
                $_POST["notif_request"]
            ]);
        }

        public function conclude() {
            $query = $this->database->prepare("UPDATE tb_solicitacao SET dt_conclusao = CURRENT_TIMESTAMP WHERE cd_solicitacao = ?;");
            $query->execute([
                $_POST["notif_request"]
            ]);

            $this->notify(["5", $_POST["notif_request"], $_SESSION["cd_usuario"]]);

            $query = $this->database->prepare("SELECT cd_usuario FROM tb_solicitacao WHERE cd_solicitacao = ?;");
            $query->execute([
                $_POST["notif_request"]
            ]);
            $donee = $query->fetch();
            $this->notify(["5", $_POST["notif_request"], $donee["cd_usuario"]]);

            $query = $this->database->prepare("SELECT 
                    tb_solicitacao.cd_item, 
                    tb_itens.qt_max_solicitacao
                FROM tb_solicitacao 
                INNER JOIN tb_itens ON tb_itens.cd_item = tb_solicitacao.cd_item 
                WHERE tb_solicitacao.cd_solicitacao = ?;");
            $query->execute([
                $_POST["notif_request"]
            ]);
            $item = $query->fetch();
            $query = $this->database->prepare("SELECT cd_solicitacao FROM tb_solicitacao WHERE cd_item = ? AND dt_conclusao IS NOT null;");
            $query->execute([
                $item["cd_item"]
            ]);
            if ($query->rowCount() == $item["qt_max_solicitacao"]) {
                $query = $this->database->prepare("UPDATE tb_itens SET dt_conclusao = CURRENT_TIMESTAMP WHERE cd_item = ?;");
                $query->execute([
                    $item["cd_item"]
                ]);    
            }
        }

        public function rate() {
            $query = $this->database->prepare("SELECT 
                    tb_solicitacao.cd_usuario AS donee, 
                    tb_itens.cd_usuario AS donator 
                FROM tb_solicitacao 
                INNER JOIN tb_itens ON tb_itens.cd_item = tb_solicitacao.cd_item 
                WHERE cd_solicitacao = ?;");
            $query->execute([
                $_POST["notif_request"]
            ]);
            $users = $query->fetch();

            $query = $this->database->prepare("UPDATE tb_usuario SET vl_reputacao = vl_reputacao + ?, qt_reputacao = qt_reputacao + 1 WHERE cd_usuario = ?;");
            if ($users["donee"] != $_SESSION["cd_usuario"])
                $query->execute([
                    $_POST["rate"], 
                    $users["donee"]
                ]);
            else
                $query->execute([
                    $_POST["rate"], 
                    $users["donator"]
                ]);
            
            $query = $this->database->prepare("UPDATE tb_notificacao SET ic_concluida = TRUE WHERE cd_usuario = ? AND cd_solicitacao = ? AND cd_tipo = 5;");
            $query->execute([
                $_SESSION["cd_usuario"], 
                $_POST["notif_request"], 
            ]);
        }

    }
    
    if (isset($_POST["notif_method"])) {
        session_start();
        (new Notification)->{ $_POST["notif_method"] }();
        session_write_close();
    }
?>