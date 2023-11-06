<?php

include("./proc/utils.php");
include("./proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = mysqli_escape_string($conn, $logged_user["id"]);


if (isset($_GET['searched_user'])) {

    // Search user

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


} else if (isset($_GET['window']) && $_GET['window'] == 'requests') {
    
    // Recived friend request
            
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
    

} else {

    // User friends

    $query_get_friend_ships = "SELECT IF(user1.id = ?, user2.username, user1.username) as 'friend_ship_username',
                                IF(user1.id = ?, user2.id, user1.id)  as 'friend_ship_user_id',
                                msg.content as 'last_message_content', DATE_FORMAT(msg.date, '%H:%i') as 'last_message_date'
                                FROM friend_ship
                                INNER JOIN user user1 ON user1.id = friend_ship.id_user1
                                INNER JOIN user user2 ON user2.id = friend_ship.id_user2
                                LEFT JOIN (
                                    SELECT message.id_friendship, MAX(message.date) AS max_timestamp
                                    FROM message
                                    GROUP BY message.id_friendship
                                ) AS max_msg ON max_msg.id_friendship = friend_ship.id
                                LEFT JOIN message msg ON max_msg.id_friendship = msg.id_friendship AND max_msg.max_timestamp = msg.date
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
} 
?>


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
    //all mysql code

    if (!isset($_POST["contact"]) || $_POST["contact"] == "") {
        $_SESSION["contact"] = "null";
    } else {
        $_SESSION["contact"] = $_POST["contact"];
        echo '<input type="hidden" id="contact_id">'; //needed for js things


        // Get contact friend ship

        $contact_id = mysqli_escape_string($conn, $_POST["contact"]);
        
        $query_get_contact_friend_ship = "SELECT friend_ship.id as 'id', user.username as 'contact_username'
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
                <a href="./view/login.php" style="color: white;">Close session [<?php echo strtoupper($logged_user["username"]) ?>]</a>
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

                        <?php

                        if (isset($_GET['searched_user'])) {

                            // Search user list

                            foreach ($filtered_users as $user) {
                                ?>
                                <div class="column column-1 chatonline-contacts-contact"
                                    <?php
                                    if ($user['is_friend']) {
                                        echo "onclick='window.location.href = \"./proc/remove_friend.php?id_user=".$user['id'].
                                        "&searched_user=".$_GET['searched_user']."\"'";
                                    } else if  ($user['has_request']) {
                                        echo "onclick=''";
                                    } else {
                                        echo "onclick='window.location.href = \"./proc/send_friend_request.php?id_user=".$user['id'].
                                        "&searched_user=".$_GET['searched_user']."\"'";
                                    }
                                    ?>
                                >
                                    <div class="row">
                                        <div class="column column-30 chatonline-contacts-contact-hide-column">
                                            <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                        </div>
                                        <div class="column column-2">
                                            <h1><?php echo $user['username']; ?></h1>
                                            <p class="chatonline-contacts-contact-request-text">
                                            <?php
                                            if ($user['is_friend']) {
                                                echo "Remove contact";
                                            } else if  ($user['has_request']) {
                                                echo "Pending request";
                                            } else {
                                                echo "Send request";
                                            }
                                            ?>
                                            </p>
                                        </div>
                                        <div class="column column-5 chatonline-contacts-contact-hide-column">
                                            <img src="
                                            <?php
                                            if ($user['is_friend']) {
                                                echo "./img/user_del.png";
                                            } else if  ($user['has_request']) {
                                                echo "./img/user_req.png";
                                            } else {
                                                echo "./img/user_add.png";
                                            }
                                            ?>
                                            " alt="logo" class="chatonline-contacts-contact-request-button">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                
                            }

                        } else if (!isset($_GET['window']) || $_GET['window'] != 'requests') {

                            // User friend ships list

                            foreach ($friend_ships as $friend_ship) {
                                ?>
                                <div onclick="ChangeContact(<?php echo $friend_ship['friend_ship_user_id']; ?>)" class="column column-1 chatonline-contacts-contact">
                                    <div class="row">
                                        <div class="column column-30 chatonline-contacts-contact-hide-column">
                                            <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                        </div>
                                        <div class="column column-60">
                                            <h1><?php echo $friend_ship['friend_ship_username']; ?></h1>
                                            <p style="opacity: 60%"><?php 
                                            
                                            if (strlen($friend_ship['last_message_content']) <= 15) {
                                                echo $friend_ship['last_message_content'];
                                            } else {
                                                echo str_split($friend_ship['last_message_content'], 15)[0]."...";
                                            }

                                            ?></p>
                                        </div>
                                        <div class="column column-10 chatonline-contacts-contact-hide-column">
                                            <h2><?php echo $friend_ship['last_message_date']; ?></h2>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }

                        } else {

                            // User friend request list

                            foreach ($friend_requests as $request) {
                                ?>

                                <div class="column column-1 chatonline-contacts-contact">
                                    <div class="row">
                                        <div class="column column-30 chatonline-contacts-contact-hide-column">
                                            <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                        </div>
                                        <div class="column column-60">
                                            <h1><?php echo $request['user_sender']; ?></h1>
                                            <p><a href='./proc/respond_friend_request.php?response=accept&request_id=<?php echo $request['request_id']; ?>'>Acpetar petición</a></p>
                                            <p><a href='./proc/respond_friend_request.php?response=reject&request_id=<?php echo $request['request_id']; ?>'>Rechazar petición</a></p>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }    
                        }

                        ?>

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
                                <?php 
                                
                                if (isset($_POST['contact'])) {
                                    echo "<h2 style='padding-left: 18%; padding-top: 2%;'>".$contact_username."</h2>";
                                }
                                
                                ?>
                            </div>
                            <div class="column column-40"></div>
                            <div class="column column-10">
                                <img onclick="location.reload()" src="./img/reload.png" alt="" class="chatonline-chat-reload">
                            </div>
                        </div>
                    </div>
                    <div class="column column-1 chatonline-chat-chat-content">
                        <?php

                        if (isset($_POST['contact'])) {
                            foreach ($contact_messages as $message) {
                                $message_sender = $message['id_user_sender'] == $logged_user_id ? 'msg-sent' : 'msg-received';
                                ?>
                                <div class="chatonline-chat-chat-content-message <?php echo $message_sender; ?>">
                                    <span class="chatonline-chat-chat-message-text"><?php echo $message['content']; ?></span>
                                    <span class="chatonline-chat-chat-timestamp"><?php echo $message['message_datetime']; ?></span>
                                </div>
                                <?php
                            }
                        }

                        ?>
                    </div>
                    <div class="column column-1 chatonline-chat-chat-footer">
                        <form action="./proc/send_message.php" method="POST">
                            <input type="hidden" name="window" value="contacts">
                            <input type="hidden" name="contact_friend_ship" id="contact_friend_ship" value="<?php if (isset($_POST["contact"])) echo $contact_friend_ship_id; ?>">
                            <input type="hidden" name="contact" id="contact_field_send_msg" value="<?php if (isset($_POST["contact"])) echo $_POST["contact"]; ?>">
                            <input oninput="CheckChatText();" type="text" name="msg" class="chatonline-chat-chat-footer-input" placeholder="Type a message">
                            <input type="submit" value="SEND" class="chatonline-chat-chat-footer-submit" disabled>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
