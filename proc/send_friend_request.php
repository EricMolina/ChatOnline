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

$sender_user_id = $logged_user['id'];
$receiver_user_id = $_GET['id_user'];

try {
    // Create friend request
    $conn->beginTransaction();

    $query_create_friend_request = 'INSERT INTO friend_request VALUES (NULL, :a, :b);';
    $stmt_create_friend_request = $conn->prepare($query_create_friend_request);
    $stmt_create_friend_request->bindParam(":a", $sender_user_id);
    $stmt_create_friend_request->bindParam(":b", $receiver_user_id);
    $stmt_create_friend_request->execute();

    $conn->commit();

    header('Location: ../index.php?searched_user='.$searched_user);

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error al enviar petición de amistad: ".$e->getMessage();
    header("location: ../index.php");
}