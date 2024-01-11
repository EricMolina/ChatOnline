<?php

include("./proc/utils.php");
include("./proc/db_connection.php");

session_start();

check_user_login("./view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = $logged_user["id"];

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PATACHAT</title>
    <link rel="icon" type="image/x-icon" href="./img/icon.ico">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/functions.js"></script>
    <script src="./js/main.js"></script>
</head>

<body class="chatonline-index-bg">
    <div class="container">
        <div class="row">
            <div class="column column-2 chatonline-header">
                <img src="./img/logo.svg" class="chatonline-img-logo chatonline-svg-white" />
                <p>PATACHAT</p>
            </div>
            <div class="column column-5"></div>
            <div class="column column-30" style="text-align: right; padding-top: 2.5%;">
                <a href="./view/login.php" style="color: white;">Close session [
                    <?php echo htmlentities(strtoupper($logged_user["username"]), ENT_QUOTES, 'UTF-8') ?>]
                </a>
            </div>
        </div>
        <div class="row">
            <div class="column column-30 chatonline-contacts">
                <div class="row">
                    <div class="column column-1 chatonline-contacts-title">
                        <div class="row">
                            <div class="column column-2">
                                <p id="current_tab">CONTACTS</p>
                            </div>
                            <div class="column column-2">
                                <div class="row chatonline-contacts-toggler">
                                    <div id="toggle_contacts"
                                        class="column column-2 chatonline-contacts-toggler-div-contacts">
                                        <img src="./img/contacts.svg"
                                            class="chatonline-contacts-toggler-icon chatonline-svg-white" />
                                    </div>
                                    <div id="toggle_requests"
                                        class="column column-2 chatonline-contacts-toggler-div-requests">
                                        <img src="./img/request.svg"
                                            class="chatonline-contacts-toggler-icon chatonline-svg-white" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column column-1 chatonline-contacts-finder">
                        <form action="" method="GET">
                            <input id="searched_user" type="text" name="searched_user"
                                class="chatonline-contacts-input">
                            <input id="searched_user_button" type="button" value="SEARCH"
                                class="chatonline-contacts-submit">
                        </form>
                        <form id="form_contact_field" action="./index.php" method="POST">
                            <input type="hidden" name="contact" id="contact_field" value="">
                        </form>
                    </div>
                    <div id="chatonline-contacts-container" class="row chatonline-contacts-contacts">
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
                                <img src="./img/user.png" alt="" style="float: left; width: 6vh; heigth: auto;">
                                <span>
                                    <h2 id="current_contact_username" style='padding-left: 18%; padding-top: 0.5%; color: white;'></h2>
                                </span>
                            </div>
                            <div class="column column-40"></div>
                        </div>
                    </div>
                    <div id="chatonline-messages-container" class="column column-1 chatonline-chat-chat-content">
                    </div>
                    <div class="column column-1 chatonline-chat-chat-footer">
                        <div id="_chatonline-chat-chat-footer-images" class="chatonline-chat-chat-footer-images">
                        </div>
                        <form id="message-form" action="./proc/send_message.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="contact_friend_ship" id="contact_friend_ship" value="">
                            <input type="hidden" name="contact" id="contact_field_send_msg" value="">

                            <label id="msg_file_info" for="msg_file"><img src="./img/file.svg" id="msg_file_icon"
                                    class="chatonline-svg-white" /></label>
                            <input type="file" name="msg_files[]" id="msg_file" multiple accept="image/*,video/*" onchange="validateFileCount()">
                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo (2 * 1024 * 1024); ?>">

                            <input id="msg-content" oninput="CheckChatText();" type="text" name="msg"
                                class="chatonline-chat-chat-footer-input" placeholder="Type a message">

                            <input id="send-message" type="button" value="SEND" class="chatonline-chat-chat-footer-submit" disabled>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>