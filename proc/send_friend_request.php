<?php

include("./utils.php");
include("./db_connection.php");


session_start();

check_user_login("../view/login.php");

$logged_user = get_user_logedin();


if (!isset($_GET['id_user']) || empty($_GET['id_user'])) {
    header('Location: ../index.php');
    die();
}


$searched_user = isset($_GET['searched_user']) ? $_GET['searched_user'] : "";

$sender_user_id = mysqli_escape_string($conn, $logged_user['id']);
$receiver_user_id = mysqli_escape_string($conn, $_GET['id_user']);

try {
    // Create friend request
    mysqli_autocommit($conn, false);
    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    $query_create_friend_request = 'INSERT INTO friend_request VALUES (NULL, ?, ?);';
    $stmt_create_friend_request = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_create_friend_request, $query_create_friend_request);
    mysqli_stmt_bind_param(
        $stmt_create_friend_request,
        "ii",
        $sender_user_id,
        $receiver_user_id,
    );
    mysqli_stmt_execute($stmt_create_friend_request);

    mysqli_commit($conn);

    mysqli_stmt_close($stmt_create_friend_request);
    mysqli_close($conn);

    header('Location: ../index.php?searched_user='.$searched_user);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error al enviar petición de amistad: ".$e->getMessage();
    mysqli_close($conn);
    header("location: ../index.php");
}