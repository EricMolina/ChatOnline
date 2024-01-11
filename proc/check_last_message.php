<?php

include("./utils.php");
include("./db_connection.php");

session_start();

check_user_login("../view/login.php");

$logged_user = get_user_logedin();
$logged_user_id = $logged_user["id"];
$id_friendship = $_POST["id_friendship"];

$check_msg = $conn->prepare("SELECT id FROM message WHERE id_friendship = :id_friendship ORDER BY id DESC LIMIT 1");
$check_msg->bindParam(":id_friendship", $id_friendship);
$check_msg->execute();
$result = $check_msg->fetchAll(PDO::FETCH_ASSOC);
if (isset($result[0]["id"]))
    echo $result[0]["id"];
else
    echo 0;
?>