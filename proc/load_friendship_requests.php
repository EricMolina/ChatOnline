<?php

include("../proc/utils.php");
include("../proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = mysqli_escape_string($conn, $logged_user["id"]);


$query_get_friend_requests = "SELECT user.username as 'user_sender', friend_request.id as 'request_id'
                                 FROM friend_request
                                 INNER JOIN user ON friend_request.id_user_sender = user.id
                                 WHERE friend_request.id_user_receiver = ?;";
    
$stmt_get_friend_requests = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt_get_friend_requests, $query_get_friend_requests);
mysqli_stmt_bind_param(
    $stmt_get_friend_requests,
    "i",
    $logged_user_id,
);
mysqli_stmt_execute($stmt_get_friend_requests);

$friend_requests_result = mysqli_stmt_get_result($stmt_get_friend_requests);
$friend_requests = mysqli_fetch_all($friend_requests_result, MYSQLI_ASSOC);

mysqli_stmt_close($stmt_get_friend_requests);

echo json_encode($friend_requests);
