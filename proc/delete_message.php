<?php

include("../proc/utils.php");
include("../proc/db_connection.php");

session_start();
check_user_login("./view/login.php");


$message_id = $_POST['message_id'];

try {
    $query_delete_message = "DELETE FROM message
                             WHERE id = :message_id";
    
    $stmt_delete_message = $conn->prepare($query_delete_message);
    $stmt_delete_message->bindParam("message_id", $message_id);
    $stmt_delete_message->execute();
    echo "ok";
}  catch (PDOException $e) {
    echo "Error al eliminar mensaje: ".$e->getMessage();
    die();
}

