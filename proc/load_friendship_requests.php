<?php

include("../proc/utils.php");
include("../proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = $logged_user["id"];


$query_get_friend_requests = "SELECT user.username as 'user_sender', friend_request.id as 'request_id'
                                 FROM friend_request
                                 INNER JOIN user ON friend_request.id_user_sender = user.id
                                 WHERE friend_request.id_user_receiver = :a;";
$stmt_get_friend_requests = $conn->prepare($query_get_friend_requests);
$stmt_get_friend_requests->bindParam(":a", $logged_user_id);
$stmt_get_friend_requests->execute();
$friend_requests = $stmt_get_friend_requests->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($friend_requests);
