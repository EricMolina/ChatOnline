<?php

include("../proc/utils.php");
include("../proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = $logged_user["id"];


$query_get_friend_ships = "SELECT IF(user1.id = :a, user2.username, user1.username) as 'friend_ship_username',
                            IF(user1.id = :b, user2.id, user1.id)  as 'friend_ship_user_id',
                            msg.content as 'last_message_content', DATE_FORMAT(msg.date, '%H:%i') as 'last_message_date'
                            FROM friend_ship
                            INNER JOIN user user1 ON user1.id = friend_ship.id_user1
                            INNER JOIN user user2 ON user2.id = friend_ship.id_user2
                            LEFT JOIN (
                                SELECT message.id_friendship, MAX(message.id) AS max_timestamp
                                FROM message
                                GROUP BY message.id_friendship
                            ) AS max_msg ON max_msg.id_friendship = friend_ship.id
                            LEFT JOIN message msg ON max_msg.id_friendship = msg.id_friendship AND max_msg.max_timestamp = msg.id
                            WHERE (friend_ship.id_user1 = :c OR friend_ship.id_user2 = :d)
                            ORDER BY msg.date DESC;";

$stmt_get_friend_ships = $conn->prepare($query_get_friend_ships);
$stmt_get_friend_ships->bindParam(":a", $logged_user_id);
$stmt_get_friend_ships->bindParam(":b", $logged_user_id);
$stmt_get_friend_ships->bindParam(":c", $logged_user_id);
$stmt_get_friend_ships->bindParam(":d", $logged_user_id);
$stmt_get_friend_ships->execute();
$friend_ships = $stmt_get_friend_ships->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($friend_ships);
