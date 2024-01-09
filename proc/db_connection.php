<?php

$db_server = "mysql:dbname=db_chatonline;host:localhost";
$db_username = "root";
$db_password = "";

try {
    $conn = new PDO($db_server, $db_username, $db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch(PDOException $e) {
    echo "Conexión fallida: ".$e->getMessage();
    exit();
}
