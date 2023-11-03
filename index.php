<?php

include("./proc/utils.php");
include("./proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = mysqli_escape_string($conn, $logged_user["id"]);



if (isset($_GET['searched_user'])) {

    // Search user

    echo "---- BUSQUEDA USUARIOS ----<br>";

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
        $logged_user_id,
        $logged_user_id,
        $logged_user_id,
        $logged_user_id,
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
        echo "<a href='./proc/send_friend_request.php?id_user=".$user['id'].
             "&searched_user=".$_GET['searched_user']."'>Enviar petición</a>";
    }

} else if (isset($_GET['window']) && $_GET['window'] == 'requests') {
    
    // Recived friend request
    
    echo "---- SOLICITUDES DE AMISTAD ----<br>";
        
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
    
    foreach ($friend_requests as $request) {
        echo "Petición de ".$request['user_sender'].": ";
        echo "<a href='./proc/respond_friend_request.php?response=accept&request_id=".$request['request_id']."'>Acpetar petición</a> | ";
        echo "<a href='./proc/respond_friend_request.php?response=reject&request_id=".$request['request_id']."'>Rechazar petición</a>";
    }    

} else {

    // User friends

    echo "<br><br>---- CONTACTOS ----<br>";

    $query_get_friend_ships = "SELECT IF(user1.id = ?, user2.username, user1.username) as 'friend_ship_username'
                               FROM friend_ship
                               INNER JOIN user user1 ON user1.id = friend_ship.id_user1
                               INNER JOIN user user2 ON user2.id = friend_ship.id_user2
                               WHERE friend_ship.id_user1 = ? OR friend_ship.id_user2 = ?;";

    $stmt_get_friend_ships = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_get_friend_ships, $query_get_friend_ships);
    mysqli_stmt_bind_param(
    $stmt_get_friend_ships,
        "iii",
        $logged_user_id,
        $logged_user_id,
        $logged_user_id
    );
    mysqli_stmt_execute($stmt_get_friend_ships);

    $friend_ships_result = mysqli_stmt_get_result($stmt_get_friend_ships);
    $friend_ships = mysqli_fetch_all($friend_ships_result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt_get_friend_ships);

    echo "<ul>";
    foreach ($friend_ships as $friend_ship) {
        echo "<li>".$friend_ship['friend_ship_username']."</li>";
    }
    echo "</ul>";

} 
