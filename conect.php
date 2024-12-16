<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dpname = 'ifto_connect';

     $conect = new mysqli($servername, $username, $password, $dpname);

     if ($conect->connect_errno){
        die("ERRO: " . $conect->connect_error);
     }
?>