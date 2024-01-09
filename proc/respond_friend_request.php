<?php

include("./utils.php");
include("./db_connection.php");

session_start();

check_user_login("../view/login.php");

$logged_user = get_user_logedin();


if ((!isset($_GET['response']) || empty($_GET['response'])) ||
    (!isset($_GET['request_id']) || empty($_GET['request_id']))) {
    header('Location: ../index.php');
    die();
}

$request_response = $_GET['response'];
$request_id = $_GET['request_id'];

try {
    $conn->beginTransaction();

    if ($request_response == 'accept') {
        // Get friend request
        $query_get_friend_request = "SELECT * FROM friend_request WHERE id = :id;";
        $stmt_get_friend_request = $conn->prepare($query_get_friend_request);
        $stmt_get_friend_request->bindParam(":id", $request_id);
        $stmt_get_friend_request->execute();
        
        $friend_request_result = $stmt_get_friend_request->fetchAll(PDO::FETCH_ASSOC);

        if (count($friend_request_result) == 0) {
            header('Location: ../index.php');
            exit();
        }

        $id_friend_request_sender = $friend_request_result[0]['id_user_sender'];
        $id_friend_request_receiver = $friend_request_result[0]['id_user_receiver'];

        // Create friend ship
        $query_create_friend_ship = 'INSERT INTO friend_ship VALUES (NULL, :sender, :receiver);';
        $stmt_create_friend_ship = $conn->prepare($query_create_friend_ship);
        $stmt_create_friend_ship->bindParam(":sender", $id_friend_request_sender);
        $stmt_create_friend_ship->bindParam(":receiver", $id_friend_request_receiver);
        $stmt_create_friend_ship->execute();
    }

    //Delete friend request
    $query_delete_friend_request = 'DELETE FROM friend_request where id = :id;';
    $stmt_delete_friend_request = $conn->prepare($query_delete_friend_request);
    $stmt_delete_friend_request->bindParam(":id", $request_id);
    $stmt_delete_friend_request->execute();

    $conn->commit();

    header('Location: ../index.php?window=requests'.$searched_user);

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error al enviar petición de amistad: ".$e->getMessage();
    header("location: ../index.php");
}