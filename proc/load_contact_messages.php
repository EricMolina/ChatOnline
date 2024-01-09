<?php

include("../proc/utils.php");
include("../proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = mysqli_escape_string($conn, $logged_user["id"]);


// Get contact friend ship

$contact_id = mysqli_escape_string($conn, $_GET["contact"]);

$query_get_contact_friend_ship = "SELECT friend_ship.id as 'id', user.name as 'contact_username'
                                    FROM db_chatonline.friend_ship
                                    INNER JOIN user ON user.id = IF(friend_ship.id_user1=?, id_user2, id_user1)
                                    WHERE (friend_ship.id_user1 = ? AND friend_ship.id_user2 = ?) OR
                                    (friend_ship.id_user1 = ? AND friend_ship.id_user2 = ?);";

$stmt_get_contact_friend_ship = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt_get_contact_friend_ship, $query_get_contact_friend_ship);
mysqli_stmt_bind_param(
    $stmt_get_contact_friend_ship,
    "iiiii",
    $logged_user_id,
    $logged_user_id,
    $contact_id,
    $contact_id,
    $logged_user_id
);
mysqli_stmt_execute($stmt_get_contact_friend_ship);

$contact_friend_ship_result = mysqli_stmt_get_result($stmt_get_contact_friend_ship);

mysqli_stmt_close($stmt_get_contact_friend_ship);

if (mysqli_num_rows($contact_friend_ship_result) == 0) {
    header('Location: .');
    exit();
}

$contact_friend_ship = mysqli_fetch_all($contact_friend_ship_result, MYSQLI_ASSOC);
$contact_friend_ship_id = $contact_friend_ship[0]['id'];
$contact_username = $contact_friend_ship[0]['contact_username'];


// Get contact messages

$query_get_contact_messages = "SELECT *, DATE_FORMAT(message.date, '%Y/%m/%d %H:%i') as 'message_datetime'
                                    FROM db_chatonline.message
                                    WHERE id_friendship = ?;";

$stmt_get_contact_messages = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt_get_contact_messages, $query_get_contact_messages);
mysqli_stmt_bind_param(
    $stmt_get_contact_messages,
    "i",
    $contact_friend_ship_id,
);
mysqli_stmt_execute($stmt_get_contact_messages);

$contact_messages_result = mysqli_stmt_get_result($stmt_get_contact_messages);

mysqli_stmt_close($stmt_get_contact_messages);

$contact_messages = mysqli_fetch_all($contact_messages_result, MYSQLI_ASSOC);


$data = [
    'logged_user_id' => $logged_user_id,
    'contact_friendship_id' => $contact_friend_ship_id,
    'contact_username' => $contact_username,
    'contact_messages' => $contact_messages
];

echo json_encode($data);
