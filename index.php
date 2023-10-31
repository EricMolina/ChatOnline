<?php

include("./proc/utils.php");
include("./proc/db_connection.php");

session_start();

check_user_login("./views/login.php");

$logged_user = get_user_logedin();


// Search user

if (isset($_GET['searched_user'])) {
    $searched_user = "%".mysqli_escape_string($conn, $_GET['searched_user'])."%";

    $query_filter_users = "SELECT user.id, user.username, 
                            SUM(CASE WHEN friend_ship.id_user1 = ? OR friend_ship.id_user2 = ?  THEN 1 ELSE 0 END) as 'is_friend',
                            SUM(CASE WHEN friend_request.id THEN 1 ELSE 0 END) as 'has_request'
                            FROM user
                            LEFT JOIN friend_ship ON (friend_ship.id_user1 = user.id OR friend_ship.id_user2 = user.id)
                            LEFT JOIN friend_request ON (friend_request.id_user_receiver = user.id AND friend_request.id_user_sender = ?)
                            WHERE (user.id != ?) AND (user.username LIKE ? OR user.name LIKE ?)
                            GROUP BY user.id;";

    $stmt_filter_users = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_filter_users, $query_filter_users);
    mysqli_stmt_bind_param(
        $stmt_filter_users,
        "iiiiss",
        $logged_user["id"],
        $logged_user["id"],
        $logged_user["id"],
        $logged_user["id"],
        $searched_user,
        $searched_user
    );
    mysqli_stmt_execute($stmt_filter_users);

    $filtered_users_result = mysqli_stmt_get_result($stmt_filter_users);
    $filtered_users = mysqli_fetch_all($filtered_users_result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt_filter_users);

    foreach ($filtered_users as $user) {
        echo "<br>";
        echo "Username: " .$user['username']. " | ";
        if ($user['is_friend']) {
            echo "Ya es tu amigo";
            continue;
        }
        if ($user['has_request']) {
            echo "Petición enviada";
            continue;
        }
        echo "<a href='./proc/send_friend_request.php?id_user=".$user['id']."'>Enviar petición</a>";
    }
}

