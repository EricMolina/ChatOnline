<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PATACHAT</title>
    <link rel="icon" type="image/x-icon" href="./img/icon.ico">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="./js/functions.js"></script>
</head>
<?php
    session_start();
    if (!isset($_SESSION["is_logged"]) || $_SESSION["is_logged"] == false) {
        session_abort();
        session_destroy();
        header("location: ./view/login.php");
        exit();
    } else { 
        //all mysql code

        if (!isset($_POST["contact"]) || $_POST["contact"] == "") {
            $_SESSION["contact"] = "null";
        } else {
            $_SESSION["contact"] = $_POST["contact"];
            echo '<input type="hidden" id="contact_id">'; //needed for js things

            //on chat, read all chat
        }

        if (isset($_POST["searched_msg"]) && $_POST["searched_msg"] != "") {
            //echo "<script>console.log('".($_POST["searched_msg"])."');</script>";

            //find searched messages with mysql
        }
    }
    ?>
<body class="chatonline-index-bg">
    <div class="container">
        <div class="row">
            <div class="column column-2 chatonline-header">
                <img src="./img/logo.svg" class="chatonline-img-logo chatonline-svg-white"/>
                <p>PATACHAT</p>
            </div>
            <div class="column column-5"></div>
            <div class="column column-30" style="text-align: right; padding-top: 2.5%;">
                <a href="./view/login.php" style="color: white;">Close session</a>
            </div>
        </div>
        <div class="row">
            <div class="column column-30 chatonline-contacts">
                <div class="row">
                    <div class="column column-1 chatonline-contacts-title">
                        <div class="row">
                            <div class="column column-2">
                                <p>CONTACTS</p>
                            </div>
                            <div class="column column-2">
                                <div class="row chatonline-contacts-toggler">
                                    <div onclick="ChangeToggler('contacts')" class="column column-2 chatonline-contacts-toggler-div-contacts">
                                    <img src="./img/contacts.svg" class="chatonline-contacts-toggler-icon chatonline-svg-white"/>
                                    </div>
                                    <div onclick="ChangeToggler('requests');" class="column column-2 chatonline-contacts-toggler-div-requests">
                                    <img src="./img/request.svg" class="chatonline-contacts-toggler-icon chatonline-svg-white"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column column-1 chatonline-contacts-finder">
                        <form action="" method="GET">
                            <input type="text" name="searched_user" class="chatonline-contacts-input">
                            <input type="submit" value="SEARCH" class="chatonline-contacts-submit">
                        </form>
                    </div>
                    <div class="row chatonline-contacts-contacts">
                        <form id="form_contact_field" action="./index.php" method="POST">
                            <input type="hidden" name="contact" id="contact_field" value="">
                        </form>
                        <div onclick="ChangeContact(1)" class="column column-1 chatonline-contacts-contact">
                            <div class="row">
                                <div class="column column-30 chatonline-contacts-contact-hide-column">
                                    <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                </div>
                                <div class="column column-60">
                                    <h1>[USERNAME]</h1>
                                    <p>[LAST MSG]</p>
                                </div>
                                <div class="column column-10 chatonline-contacts-contact-hide-column">
                                    <h2>15:05</h2>
                                </div>
                            </div>
                        </div>

                        <div onclick="ChangeContact(2)" class="column column-1 chatonline-contacts-contact">
                            <div class="row">
                                <div class="column column-30 chatonline-contacts-contact-hide-column">
                                    <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                </div>
                                <div class="column column-60">
                                    <h1>[USERNAME]</h1>
                                    <p>[LAST MSG]</p>
                                </div>
                                <div class="column column-10 chatonline-contacts-contact-hide-column">
                                    <h2>15:05</h2>
                                </div>
                            </div>
                        </div>
                        <div onclick="ChangeContact(3)" class="column column-1 chatonline-contacts-contact">
                            <div class="row">
                                <div class="column column-30 chatonline-contacts-contact-hide-column">
                                    <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                </div>
                                <div class="column column-60">
                                    <h1>[USERNAME]</h1>
                                    <p>[LAST MSG]</p>
                                </div>
                                <div class="column column-10 chatonline-contacts-contact-hide-column">
                                    <h2>15:05</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column chatonline-chat">
                <div class="chatonline-chat-nochat" style="display: none;">
                    <div>
                        <img src="./img/logo.svg" class="chatonline-chat-nochat-img-logo chatonline-svg-gray">
                        <h2>PATACHAT for Web</h2>
                        <p>Send and get messages with your friends!</p>
                    </div>
                </div>
                <div class="row chatonline-chat-chat" style="display: none;">
                    <div class="column column-1 chatonline-chat-chat-header">
                        <div class="row">
                            <div class="column column-2">
                                <img src="./img/user.png" alt="" style="float: left; width: 7vh; heigth: auto;">
                                <h2 style="padding-left: 18%; padding-top: 2%;">[USERNAME]</h2>
                            </div>
                            <div class="column column-40"></div>
                            <div class="column column-10">
                                <img onclick="location.reload()" src="./img/reload.png" alt="" class="chatonline-chat-reload">
                            </div>
                        </div>
                    </div>
                    <div class="column column-1 chatonline-chat-chat-content">
                        <div class="chatonline-chat-chat-content-message msg-received">
                            <span class="chatonline-chat-chat-message-text">Hola, ¿cómo estás? Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?Hola, ¿cómo estás?</span>
                            <span class="chatonline-chat-chat-timestamp">10/11/23 15:30</span>
                        </div>
                        <div class="chatonline-chat-chat-content-message msg-sent">
                            <span class="chatonline-chat-chat-message-text">¡Hola! Estoy bien, gracias. ¿Y tú?</span>
                            <span class="chatonline-chat-chat-timestamp">10/11/23 15:32</span>
                        </div>
                    </div>
                    <div class="column column-1 chatonline-chat-chat-footer">
                        <form action="./proc/send_msg.php" method="POST">
                            <input type="hidden" name="window" value="contacts">
                            <input type="hidden" name="contact" id="contact_field_send_msg" value="<?php if (isset($_POST["contact"])) echo $_POST["contact"]; ?>">
                            <input type="text" name="msg" class="chatonline-chat-chat-footer-input" placeholder="Type a message">
                            <input type="submit" value="SEND" class="chatonline-chat-chat-footer-submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
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
