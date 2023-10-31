<?php

include("./utils.php");
include("./db_connection.php");


session_start();

check_user_login("../views/login.php");

$logged_user = get_user_logedin();


if (!isset($_GET['id_user']) || empty($_GET['id_user'])) {
    header('Location: ../index.php');
    die();
}

$receiver_user_id = $_GET['id_user'];
$sender_user_id = $logged_user['id'];

/* try {
    echo "a";

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error al hacer registro: ".$e->getMessage();
    die();
} */