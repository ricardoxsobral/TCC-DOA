<?php
    session_start();
    $hostname = "localhost";
    $user = "root";
    $password = "";
    $database = "bd_doa";
    $conexao = mysqli_connect($hostname, $user, $password, $database); 
    if(!$conexao){
        print "Falha na conexão com o banco de dados!";
    }
?>