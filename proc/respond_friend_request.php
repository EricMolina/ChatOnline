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
$request_id = mysqli_escape_string($conn, $_GET['request_id']);

try {
    mysqli_autocommit($conn, false);
    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    if ($request_response == 'accept') {
        // Get friend request
        $query_get_friend_request = "SELECT * FROM friend_request
                                     WHERE id = ?;";
    
        $stmt_get_friend_request = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt_get_friend_request, $query_get_friend_request);
        mysqli_stmt_bind_param(
            $stmt_get_friend_request,
            "i",
            $request_id,
        );
        mysqli_stmt_execute($stmt_get_friend_request);
        
        $friend_request_result = mysqli_stmt_get_result($stmt_get_friend_request);

        if (mysqli_num_rows($friend_request_result) == 0) {
            header('Location: ../index.php');
            exit();
        }

        $friend_request = mysqli_fetch_all($friend_request_result, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt_get_friend_request);

        $id_friend_request_sender = $friend_request[0]['id_user_sender'];
        $id_friend_request_receiver = $friend_request[0]['id_user_receiver'];

        // Create friend ship

        $query_create_friend_ship = 'INSERT INTO friend_ship VALUES (NULL, ?, ?);';
        $stmt_create_friend_ship = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt_create_friend_ship, $query_create_friend_ship);
        mysqli_stmt_bind_param(
            $stmt_create_friend_ship,
            "ii",
            $id_friend_request_sender,
            $id_friend_request_receiver
        );
        mysqli_stmt_execute($stmt_create_friend_ship);
    }

    //Delete friend request

    $query_delete_friend_request = 'DELETE FROM friend_request where id = ?;';
    $stmt_delete_friend_request = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_delete_friend_request, $query_delete_friend_request);
    mysqli_stmt_bind_param(
        $stmt_delete_friend_request,
        "i",
        $request_id
    );
    mysqli_stmt_execute($stmt_delete_friend_request);

    mysqli_commit($conn);

    mysqli_stmt_close($stmt_delete_friend_request);
    if ($request_response == 'accept') {
        mysqli_stmt_close($stmt_create_friend_ship);
    }
    mysqli_close($conn);

    header('Location: ../index.php?window=requests'.$searched_user);

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error al enviar petición de amistad: ".$e->getMessage();
    mysqli_close($conn);
    header("location: ../index.php");
}