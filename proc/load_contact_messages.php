<?php

include("../proc/utils.php");
include("../proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = $logged_user["id"];


// Get contact friend ship

$contact_id = $_GET["contact"];

$query_get_contact_friend_ship = "SELECT friend_ship.id as 'id', user.name as 'contact_username'
                                    FROM db_chatonline.friend_ship
                                    INNER JOIN user ON user.id = IF(friend_ship.id_user1= :a, id_user2, id_user1)
                                    WHERE (friend_ship.id_user1 = :b AND friend_ship.id_user2 = :c) OR
                                    (friend_ship.id_user1 = :d AND friend_ship.id_user2 = :e);";

$stmt_get_contact_friend_ship = $conn->prepare($query_get_contact_friend_ship);
$stmt_get_contact_friend_ship->bindParam(":a", $logged_user_id);
$stmt_get_contact_friend_ship->bindParam(":b", $logged_user_id);
$stmt_get_contact_friend_ship->bindParam(":c", $contact_id);
$stmt_get_contact_friend_ship->bindParam(":d", $contact_id);
$stmt_get_contact_friend_ship->bindParam(":e", $logged_user_id);
$stmt_get_contact_friend_ship->execute();
$contact_friend_ship_result = $stmt_get_contact_friend_ship->fetchAll(PDO::FETCH_ASSOC);

if (count($contact_friend_ship_result) == 0) {
    header('Location: .');
    exit();
}
$contact_friend_ship_id = $contact_friend_ship_result[0]['id'];
$contact_username = $contact_friend_ship_result[0]['contact_username'];


// Get contact messages

$query_get_contact_messages = "SELECT *, DATE_FORMAT(message.date, '%Y/%m/%d %H:%i') as 'message_datetime'
                                    FROM db_chatonline.message
                                    WHERE id_friendship = :a;";

$stmt_get_contact_messages = $conn->prepare($query_get_contact_messages);
$stmt_get_contact_messages->bindParam(":a", $contact_friend_ship_id);
$stmt_get_contact_messages->execute();
$contact_messages = $stmt_get_contact_messages->fetchAll(PDO::FETCH_ASSOC);

$data = [
    'logged_user_id' => $logged_user_id,
    'contact_friendship_id' => $contact_friend_ship_id,
    'contact_username' => $contact_username,
    'contact_messages' => $contact_messages
];

echo json_encode($data);
