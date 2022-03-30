<?php 
    if (!defined("requiring"))
        exit(http_response_code(404));

    abstract class Model {

        protected function connect_database() {
            $database = new PDO("mysql:host=localhost;dbname=bd_doa;charset=utf8", "root", "", [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '+00:00';", 
                PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT, 
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                PDO::ATTR_EMULATE_PREPARES => false
            ]);

            return $database;
        }

    }
?>