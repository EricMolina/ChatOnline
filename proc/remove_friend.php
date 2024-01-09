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

$logged_user_id = $logged_user['id'];
$friend_user_id = $_GET['id_user'];


try {
    $conn->beginTransaction();


    // Get friend ship

    $query_get_contact_friend_ship = "SELECT friend_ship.id as 'id'
                                      FROM db_chatonline.friend_ship
                                      WHERE (friend_ship.id_user1 = :1_id_user1 AND friend_ship.id_user2 = :1_id_user2) OR
                                      (friend_ship.id_user1 = :2_id_user1 AND friend_ship.id_user2 = :2_id_user2);";

    $stmt_get_contact_friend_ship = $conn->prepare($query_get_contact_friend_ship);
    $stmt_get_contact_friend_ship->bindParam("1_id_user1", $logged_user_id);
    $stmt_get_contact_friend_ship->bindParam("1_id_user2", $friend_user_id);
    $stmt_get_contact_friend_ship->bindParam("2_id_user1", $friend_user_id);
    $stmt_get_contact_friend_ship->bindParam("2_id_user2", $logged_user_id);
    $stmt_get_contact_friend_ship->execute();

    $friend_ship = $stmt_get_contact_friend_ship->fetchAll(PDO::FETCH_ASSOC);

    if (count($friend_ship) == 0) {
        header('Location: ../');
        exit();
    }

    $friend_ship_id = $friend_ship[0]['id'];

    // Remove friend ship messages
    $query_delete_friend_ship_messages = 'DELETE FROM message WHERE id_friendship = :id;';
    $stmt_delete_friend_messages = $conn->prepare($query_delete_friend_ship_messages);
    $stmt_delete_friend_messages->bindParam(":id", $friend_ship_id);

    $stmt_delete_friend_messages->execute();


    // Remove friend ship
    $query_delete_friend_ship = 'DELETE FROM friend_ship WHERE id = :id;';
    $stmt_delete_friend_ship = $conn->prepare($query_delete_friend_ship);
    $stmt_delete_friend_ship->bindParam(":id", $friend_ship_id);
    $stmt_delete_friend_ship->execute();

    $conn->commit();

    header('Location: ../index.php?searched_user='.$searched_user);

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error al eliminar amigo: ".$e->getMessage();
    die();
}