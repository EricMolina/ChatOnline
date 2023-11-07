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

$logged_user_id = mysqli_escape_string($conn, $logged_user['id']);
$friend_user_id = mysqli_escape_string($conn, $_GET['id_user']);


try {
    mysqli_autocommit($conn, false);
    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    // Get friend ship

    $query_get_contact_friend_ship = "SELECT friend_ship.id as 'id'
                                      FROM db_chatonline.friend_ship
                                      WHERE (friend_ship.id_user1 = ? AND friend_ship.id_user2 = ?) OR
                                      (friend_ship.id_user1 = ? AND friend_ship.id_user2 = ?);";

    $stmt_get_contact_friend_ship = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_get_contact_friend_ship, $query_get_contact_friend_ship);
    mysqli_stmt_bind_param(
        $stmt_get_contact_friend_ship,
        "iiii",
        $logged_user_id,
        $friend_user_id,
        $friend_user_id,
        $logged_user_id
    );
    mysqli_stmt_execute($stmt_get_contact_friend_ship);

    $contact_friend_ship_result = mysqli_stmt_get_result($stmt_get_contact_friend_ship);

    if (mysqli_num_rows($contact_friend_ship_result) == 0) {
        header('Location: ../');
        exit();
    }

    $friend_ship = mysqli_fetch_all($contact_friend_ship_result, MYSQLI_ASSOC);
    $friend_ship_id = $friend_ship[0]['id'];

    // Remove friend ship messages

    $query_delete_friend_ship_messages = 'DELETE FROM message WHERE id_friendship = ?;';
    $stmt_delete_friend_messages = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_delete_friend_messages, $query_delete_friend_ship_messages);
    mysqli_stmt_bind_param(
        $stmt_delete_friend_messages,
        "i",
        $friend_ship_id
    );
    mysqli_stmt_execute($stmt_delete_friend_messages);


    // Remove friend ship

    $query_delete_friend_ship = 'DELETE FROM friend_ship WHERE id = ?;';
    $stmt_delete_friend_ship = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_delete_friend_ship, $query_delete_friend_ship);
    mysqli_stmt_bind_param(
        $stmt_delete_friend_ship,
        "i",
        $friend_ship_id
    );
    mysqli_stmt_execute($stmt_delete_friend_ship);

    mysqli_commit($conn);

    mysqli_stmt_close($stmt_get_contact_friend_ship);
    mysqli_stmt_close($stmt_delete_friend_ship);

    mysqli_close($conn);

    header('Location: ../index.php?searched_user='.$searched_user);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error al eliminar amigo: ".$e->getMessage();
    mysqli_close($conn);
    die();
}