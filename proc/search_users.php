<?php

include("../proc/utils.php");
include("../proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = $logged_user["id"];


$searched_user = "%".$_GET['searched_user']."%";

$query_filter_users = "SELECT user.id, user.username, 
                        SUM(CASE WHEN friend_ship.id_user1 = :a OR friend_ship.id_user2 = :b  THEN 1 ELSE null END) as 'is_friend',
                        SUM(CASE WHEN friend_request.id THEN 1 ELSE null END) as 'has_request'
                        FROM user
                        LEFT JOIN friend_ship ON (friend_ship.id_user1 = user.id OR friend_ship.id_user2 = user.id)
                        LEFT JOIN friend_request ON (friend_request.id_user_receiver = user.id AND friend_request.id_user_sender = :c)
                        WHERE (user.id != :d) AND (user.username LIKE :e OR user.name LIKE :f)
                        GROUP BY user.id;";
$stmt_filter_users = $conn->prepare($query_filter_users);
$stmt_filter_users->bindParam(":a", $logged_user_id);
$stmt_filter_users->bindParam(":b", $logged_user_id);
$stmt_filter_users->bindParam(":c", $logged_user_id);
$stmt_filter_users->bindParam(":d", $logged_user_id);
$stmt_filter_users->bindParam(":e", $searched_user);
$stmt_filter_users->bindParam(":f", $searched_user);
$stmt_filter_users->execute();
$filtered_users = $stmt_filter_users->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($filtered_users);
