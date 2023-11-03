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
                                <img src="./img/user.png" alt="" style="float: left; width: 55px; heigth: auto;">
                                <h2 style="padding-left: 18%; padding-top: 2%;">[USERNAME]</h2>
                            </div>
                            <div class="column column-40" style="padding-top: 1.5%;">
                                <form action="./index.php" method="POST">
                                    <input type="hidden" name="window" value="contacts">
                                    <input type="text" name="searched_msg" class="chatonline-contacts-input">
                                    <input type="hidden" name="contact" id="contact_field_searched_msg" value="<?php if (isset($_POST["contact"])) echo $_POST["contact"]; ?>">
                                    <input type="submit" value="SEARCH" class="chatonline-contacts-submit">
                                </form>
                            </div>
                            <div class="column column-10">
                                <img onclick="location.reload()" src="./img/reload.png" alt="" style="float: left; margin-top: 10%; width: 45px; heigth: auto; margin-left: 90%; cursor: pointer;">
                            </div>
                        </div>
                    </div>
                    <div class="column column-1 chatonline-chat-chat-content">
                        <div class="chatonline-chat-chat-content-message msg-received">
                            <p>test recibo</p>
                        </div>
                        <div class="chatonline-chat-chat-content-message msg-sent">
                            <p>test envío</p>
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