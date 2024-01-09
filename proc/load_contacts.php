<?php

include("../proc/utils.php");
include("../proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = mysqli_escape_string($conn, $logged_user["id"]);


$query_get_friend_ships = "SELECT IF(user1.id = ?, user2.username, user1.username) as 'friend_ship_username',
                            IF(user1.id = ?, user2.id, user1.id)  as 'friend_ship_user_id',
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
                            WHERE (friend_ship.id_user1 = ? OR friend_ship.id_user2 = ?)
                            ORDER BY msg.date DESC;";

$stmt_get_friend_ships = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt_get_friend_ships, $query_get_friend_ships);
mysqli_stmt_bind_param(
    $stmt_get_friend_ships,
    "iiii",
    $logged_user_id,
    $logged_user_id,
    $logged_user_id,
    $logged_user_id
);
mysqli_stmt_execute($stmt_get_friend_ships);

$friend_ships_result = mysqli_stmt_get_result($stmt_get_friend_ships);
$friend_ships = mysqli_fetch_all($friend_ships_result, MYSQLI_ASSOC);

mysqli_stmt_close($stmt_get_friend_ships);

echo json_encode($friend_ships);
